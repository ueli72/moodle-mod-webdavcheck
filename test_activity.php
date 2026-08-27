<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * WebDAV Check activity test page.
 *
 * @package    mod_webdavcheck
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('lib.php');

$instance = required_param('instance', PARAM_INT);
$testuser = optional_param('testuser', '', PARAM_RAW);

$webdavcheck = $DB->get_record('webdavcheck', ['id' => $instance], '*', MUST_EXIST);
$cm = get_coursemodule_from_instance('webdavcheck', $instance);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/webdavcheck:addinstance', $context);

$PAGE->set_url('/mod/webdavcheck/test_activity.php', ['instance' => $instance]);
$PAGE->set_context($context);
$PAGE->set_title(get_string('testconnection', 'mod_webdavcheck') . ' - ' . format_string($webdavcheck->name));
$PAGE->set_heading(get_string('testconnection', 'mod_webdavcheck'));

$testresult = null;
$foundfiles = [];
$rawresponse = '';
$curlerror = '';
$curlhttpcode = 0;
if ($testuser) {
    $testuserobj = new stdClass();
    $testuserobj->username = $testuser;
    $testresult = webdavcheck_check_file($webdavcheck, $testuserobj);
    
    // Also get the raw file list for display.
    $config = get_config('mod_webdavcheck');
    if (!empty($config->webdavurl) && !empty($config->webdavuser) && !empty($config->webdavpass)) {
        $path = str_replace(['{$user}', '{user}'], $testuser, $webdavcheck->pathtemplate);
        $url = rtrim($config->webdavurl, '/') . '/' . ltrim($path, '/');
        
        // Direct curl test with full debug output.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $config->webdavuser . ':' . $config->webdavpass);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        $rawresponse = curl_exec($ch);
        $curlhttpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlerror = curl_error($ch);
        curl_close($ch);
        
        $foundfiles = webdavcheck_webdav_propfind($url, $config->webdavuser, $config->webdavpass);
        if (is_string($foundfiles)) {
            $foundfiles = []; // Error occurred, show empty list.
        }
    }
}

$output = $PAGE->get_renderer('mod_webdavcheck');
echo $output->header();
echo $output->heading(get_string('testconnection', 'mod_webdavcheck') . ': ' . format_string($webdavcheck->name));

// Show current settings.
$config = get_config('mod_webdavcheck');
$table = new html_table();
$table->attributes['class'] = 'generaltable';
$table->head = [get_string('setting', 'mod_webdavcheck'), get_string('value', 'mod_webdavcheck')];
$table->data = [
    [get_string('webdavurl', 'mod_webdavcheck'), s($config->webdavurl ?: '-')],
    [get_string('webdavuser', 'mod_webdavcheck'), s($config->webdavuser ?: '-')],
    [get_string('pathtemplate', 'mod_webdavcheck'), s($webdavcheck->pathtemplate)],
    [get_string('filepattern', 'mod_webdavcheck'), s($webdavcheck->filepattern)],
];
if ($testuser) {
    $fullpath = rtrim($config->webdavurl, '/') . '/' . ltrim(str_replace(['{$user}', '{user}'], $testuser, $webdavcheck->pathtemplate), '/');
    $table->data[] = [get_string('fullpath', 'mod_webdavcheck'), s($fullpath)];
}
echo html_writer::table($table);

// Test form.
echo html_writer::start_tag('form', ['method' => 'get', 'class' => 'mt-3']);
$formurl = new moodle_url($PAGE->url);
$formurl->remove_params('testuser');
echo html_writer::input_hidden_params($formurl);
echo html_writer::start_div('form-inline');
echo html_writer::empty_tag('input', [
    'type' => 'text',
    'name' => 'testuser',
    'value' => s($testuser),
    'placeholder' => get_string('username'),
    'class' => 'form-control',
]);
echo ' ';
echo html_writer::tag('button', get_string('testbutton', 'mod_webdavcheck'), [
    'type' => 'submit',
    'class' => 'btn btn-secondary',
]);
echo html_writer::end_div();
echo html_writer::end_tag('form');

// Result.
if ($testresult !== null) {
    echo html_writer::start_div('mt-3');
    if ($testresult['found']) {
        echo $OUTPUT->notification(
            get_string('testresult_found', 'mod_webdavcheck'),
            'success'
        );
    } else if ($testresult['error']) {
        echo $OUTPUT->notification(
            get_string('testresult_error', 'mod_webdavcheck', $testresult['error']),
            'warning'
        );
    } else {
        echo $OUTPUT->notification(
            get_string('testresult_notfound', 'mod_webdavcheck'),
            'error'
        );
    }
    echo html_writer::end_div();
    
    // Always show found files for debugging.
    echo html_writer::tag('h5', 'Gefundene Dateien:', ['class' => 'mt-3']);
    if (!empty($foundfiles)) {
        echo html_writer::alist($foundfiles);
    } else {
        echo html_writer::tag('p', 'Keine Dateien gefunden (oder Fehler bei der Abfrage).', ['class' => 'text-muted']);
    }
    echo html_writer::tag('p', 'Datei-Muster: ' . s($webdavcheck->filepattern), ['class' => 'text-muted small']);
    
    // Show raw debug info.
    echo html_writer::tag('h5', 'Debug: Server-Antwort', ['class' => 'mt-3']);
    echo html_writer::tag('p', 'HTTP Code: ' . s($curlhttpcode), ['class' => 'text-muted']);
    if ($curlerror) {
        echo html_writer::tag('p', 'cURL Fehler: ' . s($curlerror), ['class' => 'text-danger']);
    }
    echo html_writer::tag('pre', s(substr($rawresponse, 0, 3000)), ['style' => 'max-height: 400px; overflow: auto; background: #f5f5f5; padding: 10px; font-size: 11px;']);
}

echo $OUTPUT->footer();
