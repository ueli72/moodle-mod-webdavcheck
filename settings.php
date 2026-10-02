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
 * WebDAV Check admin settings.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_heading(
        'mod_webdavcheck/general',
        get_string('generalsettings', 'mod_webdavcheck'),
        ''
    ));

    $settings->add(new admin_setting_configtext(
        'mod_webdavcheck/webdavurl',
        get_string('webdavurl', 'mod_webdavcheck'),
        get_string('webdavurl_desc', 'mod_webdavcheck'),
        '',
        PARAM_URL
    ));

    $settings->add(new admin_setting_configtext(
        'mod_webdavcheck/webdavuser',
        get_string('webdavuser', 'mod_webdavcheck'),
        get_string('webdavuser_desc', 'mod_webdavcheck'),
        '',
        PARAM_TEXT
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'mod_webdavcheck/webdavpass',
        get_string('webdavpass', 'mod_webdavcheck'),
        get_string('webdavpass_desc', 'mod_webdavcheck'),
        ''
    ));

    // Test connection link.
    $testurl = new moodle_url('/mod/webdavcheck/test.php');
    $testlink = html_writer::link(
        $testurl,
        get_string('testconnection', 'mod_webdavcheck'),
        ['class' => 'btn btn-secondary', 'target' => '_blank']
    );
    $settings->add(new admin_setting_heading(
        'mod_webdavcheck/testconnection',
        get_string('testconnection', 'mod_webdavcheck'),
        $testlink
    ));
}
