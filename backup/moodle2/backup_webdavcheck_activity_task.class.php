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
 * Defines backup_webdavcheck_activity_task class.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Provides the steps to perform one complete backup of a WebDAV Check instance.
 *
 * @package    mod_webdavcheck
 * @category   backup
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_webdavcheck_activity_task extends backup_activity_task {
    /**
     * No specific settings for this activity.
     */
    protected function define_my_settings() {
    }

    /**
     * Define the backup steps of this activity.
     */
    protected function define_my_steps() {
        $this->add_step(new backup_webdavcheck_activity_structure_step('webdavcheck_structure', 'webdavcheck.xml'));
    }

    /**
     * Encode content links prior to backup.
     *
     * @param string $content the content to encode links in
     * @return string the encoded content
     */
    public static function encode_content_links($content) {
        global $CFG;

        $base = preg_quote($CFG->wwwroot, '/');

        // Link to the list of webdavcheck activities.
        $search = '/(' . $base . '\/mod\/webdavcheck\/index.php\?id=)([0-9]+)/';
        $content = preg_replace($search, '$@WEBDAVCHECKINDEX*$2@$', $content);

        // Link to a single webdavcheck activity by cmid.
        $search = '/(' . $base . '\/mod\/webdavcheck\/view.php\?id=)([0-9]+)/';
        $content = preg_replace($search, '$@WEBDAVCHECKVIEWBYID*$2@$', $content);

        return $content;
    }
}
