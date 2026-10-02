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
 * Defines restore_webdavcheck_activity_task class.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Provides all the settings and steps to perform one complete restore of a WebDAV Check activity.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_webdavcheck_activity_task extends restore_activity_task {
    /**
     * Define (add) particular settings of this activity.
     */
    protected function define_my_settings() {
    }

    /**
     * Define (add) particular steps of this activity.
     */
    protected function define_my_steps() {
        $this->add_step(new restore_webdavcheck_activity_structure_step('webdavcheck_structure', 'webdavcheck.xml'));
    }

    /**
     * Define the contents in the activity that must be processed by the link decoder.
     */
    public static function define_decode_contents() {
        $contents = [];

        $contents[] = new restore_decode_content('webdavcheck', ['intro'], 'webdavcheck');
        $contents[] = new restore_decode_content('webdavcheck', ['successtext'], 'webdavcheck');
        $contents[] = new restore_decode_content('webdavcheck', ['failuretext'], 'webdavcheck');

        return $contents;
    }

    /**
     * Define the decoding rules for links belonging to the activity to be executed by the link decoder.
     */
    public static function define_decode_rules() {
        $rules = [];

        $rules[] = new restore_decode_rule('WEBDAVCHECKINDEX', '/mod/webdavcheck/index.php', 'course');
        $rules[] = new restore_decode_rule('WEBDAVCHECKINDEXBYID', '/mod/webdavcheck/index.php?id=$1', 'course');
        $rules[] = new restore_decode_rule('WEBDAVCHECKVIEWBYID', '/mod/webdavcheck/view.php?id=$1', 'course_module');

        return $rules;
    }
}
