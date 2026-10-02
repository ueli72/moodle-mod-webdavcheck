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
 * WebDAV Check connection test page.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/lib/formslib.php');
require_once('lib.php');

require_login();
require_capability('moodle/site:config', context_system::instance());

$PAGE->set_url('/mod/webdavcheck/test.php');
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('testconnection', 'mod_webdavcheck'));
$PAGE->set_heading(get_string('testconnection', 'mod_webdavcheck'));

$config = get_config('mod_webdavcheck');

/**
 * Form for the administrator WebDAV connection test.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class webdavcheck_test_form extends moodleform {
    /**
     * Define the form.
     */
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('submit', 'test', get_string('testbutton', 'mod_webdavcheck'));
    }
}

$mform = new webdavcheck_test_form();
$testresult = null;

if ($mform->is_submitted()) {
    if (!empty($config->webdavurl) && !empty($config->webdavuser) && !empty($config->webdavpass)) {
        $url = rtrim($config->webdavurl, '/');
        $files = webdavcheck_webdav_propfind($url, $config->webdavuser, $config->webdavpass);
        if (is_string($files)) {
            $testresult = ['success' => false, 'message' => $files];
        } else {
            $testresult = ['success' => true, 'message' => get_string('test_success', 'mod_webdavcheck', count($files))];
        }
    } else {
        $testresult = ['success' => false, 'message' => get_string('error_noconfig', 'mod_webdavcheck')];
    }
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('testconnection', 'mod_webdavcheck'));

echo html_writer::tag('p', get_string('test_info', 'mod_webdavcheck'));

// Display current settings.
$table = new html_table();
$table->attributes['class'] = 'generaltable';
$table->head = [get_string('setting', 'mod_webdavcheck'), get_string('value', 'mod_webdavcheck')];
$table->data = [
    [get_string('webdavurl', 'mod_webdavcheck'), s($config->webdavurl ?: '-')],
    [get_string('webdavuser', 'mod_webdavcheck'), s($config->webdavuser ?: '-')],
    [get_string('webdavpass', 'mod_webdavcheck'), '*****'],
];
echo html_writer::table($table);

$mform->display();

if ($testresult !== null) {
    if ($testresult['success']) {
        echo $OUTPUT->notification($testresult['message'], 'success');
    } else {
        echo $OUTPUT->notification($testresult['message'], 'error');
    }
}

echo $OUTPUT->footer();
