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
 * WebDAV Check view page.
 *
 * @package    mod_webdavcheck
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('lib.php');

$id = required_param('id', PARAM_INT);

$cm = get_coursemodule_from_id('webdavcheck', $id, 0, false, MUST_EXIST);
$course = $DB->get_record('course', ['id' => $cm->course], '*', MUST_EXIST);
$webdavcheck = $DB->get_record('webdavcheck', ['id' => $cm->instance], '*', MUST_EXIST);

require_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/webdavcheck:view', $context);

$PAGE->set_url('/mod/webdavcheck/view.php', ['id' => $cm->id]);
$PAGE->set_title(format_string($webdavcheck->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($context);

// Completion tracking.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

// Check WebDAV file for current user (used for display only).
$result = webdavcheck_check_file($webdavcheck, $USER);

$output = $PAGE->get_renderer('mod_webdavcheck');
echo $output->header();
echo $output->heading(format_string($webdavcheck->name));

if (!empty($webdavcheck->intro)) {
    echo $output->box(format_module_intro('webdavcheck', $webdavcheck, $cm->id), 'generalbox', 'intro');
}

echo $output->render_check_result($result, $webdavcheck, $context);
echo $output->footer();
