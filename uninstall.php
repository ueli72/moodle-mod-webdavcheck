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
 * Uninstall code for mod_webdavcheck.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Remove all data belonging to the mod_webdavcheck plugin.
 *
 * @return bool
 */
function xmldb_webdavcheck_uninstall() {
    global $DB;

    $dbman = $DB->get_manager();

    $table = new xmldb_table('webdavcheck');
    if ($dbman->table_exists($table)) {
        $dbman->drop_table($table);
    }

    unset_all_config_for_plugin('mod_webdavcheck');

    return true;
}
