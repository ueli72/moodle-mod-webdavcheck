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
 * Defines all the backup steps for mod_webdavcheck.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Defines the complete structure for backing up one WebDAV Check activity.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_webdavcheck_activity_structure_step extends backup_activity_structure_step {
    /**
     * Define the structure of the backup.
     *
     * @return backup_nested_element the complete structure to be backed up
     */
    protected function define_structure() {

        $paths = [];

        $webdavcheck = new backup_nested_element('webdavcheck', ['id'], [
            'course', 'name', 'intro', 'introformat', 'pathtemplate',
            'filepattern', 'successtext', 'successtextformat',
            'failuretext', 'failuretextformat', 'completionwebdav', 'timemodified',
        ]);
        $paths[] = $webdavcheck;

        // Back up the file areas used by this activity.
        $webdavcheck->annotate_files('mod_webdavcheck', 'intro', null);
        $webdavcheck->annotate_files('mod_webdavcheck', 'successtext', null);
        $webdavcheck->annotate_files('mod_webdavcheck', 'failuretext', null);

        // Return the root element wrapped in the standard activity structure.
        return $this->prepare_activity_structure($webdavcheck);
    }
}
