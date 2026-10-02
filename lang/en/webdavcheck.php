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
 * English strings for WebDAV Check.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['completionwebdav'] = 'WebDAV file present';
$string['curlerror'] = 'cURL error: {$a}';
$string['debugresponse'] = 'Debug: server response';
$string['error_curl'] = 'Connection error: {$a}';
$string['error_http'] = 'WebDAV server returned HTTP error: {$a}';
$string['error_noconfig'] = 'WebDAV is not configured. Please contact the administrator.';
$string['error_notfound'] = 'The WebDAV folder was not found.';
$string['error_unauthorized'] = 'WebDAV authentication failed. Please check the credentials in the admin settings.';
$string['error_xml'] = 'Invalid response from WebDAV server.';
$string['failuretext'] = 'Failure Message';
$string['filepattern'] = 'File Pattern';
$string['filepattern_help'] = 'File pattern with wildcards. Example: *.docx';
$string['foundfiles'] = 'Files found:';
$string['fullpath'] = 'Full Path';
$string['generalsettings'] = 'General Settings';
$string['httpcode'] = 'HTTP code: {$a}';
$string['messagetexts'] = 'Message Texts';
$string['modulename'] = 'WebDAV Check';
$string['modulename_help'] = 'The WebDAV Check activity connects to a WebDAV server and checks if a specific file exists. If found, the activity is marked as completed.';
$string['modulenameplural'] = 'WebDAV Checks';
$string['nofilesfound'] = 'No files found (or error while querying).';
$string['nowebdavchecks'] = 'No WebDAV Check activities found in this course.';
$string['pathtemplate'] = 'Path Template';
$string['pathtemplate_help'] = 'Relative path to the WebDAV folder. Use {$user} as placeholder for the username. Example: Shared/{$user}/submissions/';
$string['pluginadministration'] = 'WebDAV Check administration';
$string['pluginname'] = 'WebDAV Check';
$string['privacy:metadata'] = 'The WebDAV Check activity does not store any personal data. It connects to the configured WebDAV server on behalf of the current user to check for the presence of a file.';
$string['setting'] = 'Setting';
$string['successtext'] = 'Success Message';
$string['test_info'] = 'Click the button below to test the WebDAV connection using the configured settings.';
$string['test_success'] = 'Connection successful! Found {$a} items on the WebDAV server.';
$string['testbutton'] = 'Test Connection';
$string['testconnection'] = 'Test Connection';
$string['testresult'] = 'Test Result';
$string['testresult_error'] = 'Error during check: {$a}';
$string['testresult_found'] = 'Condition met! The file was found for this user.';
$string['testresult_notfound'] = 'Condition not met! The file was not found for this user.';
$string['testwithuser'] = 'Connection Check';
$string['testwithuser_desc'] = 'Enter a username to test if the WebDAV path and file pattern match for this user.';
$string['value'] = 'Value';
$string['webdavcheck:addinstance'] = 'Add a new WebDAV Check activity';
$string['webdavcheck:view'] = 'View WebDAV Check activity';
$string['webdavcheckname'] = 'Activity Name';
$string['webdavpass'] = 'WebDAV Password';
$string['webdavpass_desc'] = 'Password for WebDAV authentication';
$string['webdavsettings'] = 'WebDAV Settings';
$string['webdavurl'] = 'WebDAV URL';
$string['webdavurl_desc'] = 'Base URL of the WebDAV server. Example: https://alfresco.example.com/alfresco/webdav/';
$string['webdavuser'] = 'WebDAV Username';
$string['webdavuser_desc'] = 'Username for WebDAV authentication';
