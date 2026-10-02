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
 * Defines all the restore steps for mod_webdavcheck.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Structure step to restore one WebDAV Check activity.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class restore_webdavcheck_activity_structure_step extends restore_activity_structure_step {
    /**
     * Define the structure of the restore.
     *
     * @return array of restore_path_element
     */
    protected function define_structure() {

        $paths = [];
        $paths[] = new restore_path_element('webdavcheck', '/activity/webdavcheck');

        return $paths;
    }

    /**
     * Process the restored data for one WebDAV Check instance.
     *
     * @param array|object $data the parsed backup data
     * @return object the new instance record
     */
    protected function process_webdavcheck($data) {
        global $DB;

        $data = (object) $data;
        $oldid = $data->id;
        $data->course = $this->get_courseid();

        $newitemid = $DB->insert_record('webdavcheck', $data);
        $this->set_mapping('webdavcheck', $oldid, $newitemid);
        $this->apply_activity_instance($newitemid);

        return $data;
    }

    /**
     * Post-execution actions, e.g. restore the annotated files.
     */
    protected function after_execute() {
        $this->add_related_files('mod_webdavcheck', 'intro', null);
        $this->add_related_files('mod_webdavcheck', 'successtext', null);
        $this->add_related_files('mod_webdavcheck', 'failuretext', null);
    }
}
