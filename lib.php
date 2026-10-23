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
 * WebDAV Check main library functions.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/completionlib.php');

/**
 * Return the editor options for WebDAV Check text fields.
 *
 * @param context $context Context object
 * @return array Editor options
 */
function webdavcheck_get_editor_options($context) {
    return ['subdirs' => true, 'maxfiles' => -1];
}

/**
 * Serve files from the editor text areas (images etc.).
 *
 * @param stdClass $course Course object
 * @param stdClass $cm Course module object
 * @param context $context Module context
 * @param string $filearea File area
 * @param array $args Remaining path arguments (itemid, filepath..., filename)
 * @param bool $forcedownload Force download
 * @param array $options Send file options
 */
function webdavcheck_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = []) {
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/webdavcheck:view', $context)) {
        return false;
    }

    if (!in_array($filearea, ['successtext', 'failuretext'], true)) {
        return false;
    }

    $itemid = array_shift($args);
    $filename = array_pop($args);
    $filepath = $args ? '/' . implode('/', $args) . '/' : '/';

    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'mod_webdavcheck', $filearea, $itemid, $filepath, $filename);

    if (!$file || $file->is_directory()) {
        send_file_not_found();
    }

    send_stored_file($file, null, 0, true, $options);
}

/**
 * Add a new WebDAV Check instance.
 *
 * @param stdClass $data Form data
 * @param mod_webdavcheck_mod_form $mform The form
 * @return int New webdavcheck instance id
 */
function webdavcheck_add_instance($data, $mform = null) {
    global $DB;

    $data->timemodified = time();

    // Keep the editor arrays intact so we can still access ['itemid'] below;
    // copy text/format out into the scalar DB fields first.
    $successtext = $data->successtext;
    $failuretext = $data->failuretext;

    if (is_array($successtext)) {
        $data->successtextformat = $successtext['format'];
        $data->successtext = $successtext['text'];
    }
    if (is_array($failuretext)) {
        $data->failuretextformat = $failuretext['format'];
        $data->failuretext = $failuretext['text'];
    }

    $data->id = $DB->insert_record('webdavcheck', $data);

    // We need to use context now, so we need to make sure all needed info is already in db.
    $DB->set_field('course_modules', 'instance', $data->id, ['id' => $data->coursemodule]);
    $context = context_module::instance($data->coursemodule);

    // Save editor files and rewrite draftfile.php URLs to @@PLUGINFILE@@.
    if ($mform) {
        $editoroptions = webdavcheck_get_editor_options($context);

        if (!empty($successtext['itemid'])) {
            $data->successtext = file_save_draft_area_files(
                $successtext['itemid'],
                $context->id,
                'mod_webdavcheck',
                'successtext',
                0,
                $editoroptions,
                $data->successtext
            );
        }
        if (!empty($failuretext['itemid'])) {
            $data->failuretext = file_save_draft_area_files(
                $failuretext['itemid'],
                $context->id,
                'mod_webdavcheck',
                'failuretext',
                0,
                $editoroptions,
                $data->failuretext
            );
        }
        $DB->update_record('webdavcheck', $data);
    }

    return $data->id;
}

/**
 * Update an existing WebDAV Check instance.
 *
 * @param stdClass $data Form data
 * @param mod_webdavcheck_mod_form $mform The form
 * @return bool
 */
function webdavcheck_update_instance($data, $mform = null) {
    global $DB;

    $data->timemodified = time();
    $data->id = $data->instance;

    // Keep the editor arrays intact so we can still access ['itemid'] below;
    // copy text/format out into the scalar DB fields first.
    $successtext = $data->successtext;
    $failuretext = $data->failuretext;

    if (is_array($successtext)) {
        $data->successtextformat = $successtext['format'];
        $data->successtext = $successtext['text'];
    }
    if (is_array($failuretext)) {
        $data->failuretextformat = $failuretext['format'];
        $data->failuretext = $failuretext['text'];
    }

    $DB->update_record('webdavcheck', $data);

    $context = context_module::instance($data->coursemodule);

    // Save editor files and rewrite draftfile.php URLs to @@PLUGINFILE@@.
    if ($mform) {
        $editoroptions = webdavcheck_get_editor_options($context);

        if (!empty($successtext['itemid'])) {
            $data->successtext = file_save_draft_area_files(
                $successtext['itemid'],
                $context->id,
                'mod_webdavcheck',
                'successtext',
                0,
                $editoroptions,
                $data->successtext
            );
        }
        if (!empty($failuretext['itemid'])) {
            $data->failuretext = file_save_draft_area_files(
                $failuretext['itemid'],
                $context->id,
                'mod_webdavcheck',
                'failuretext',
                0,
                $editoroptions,
                $data->failuretext
            );
        }
        $DB->update_record('webdavcheck', $data);
    }

    return true;
}

/**
 * Delete a WebDAV Check instance.
 *
 * @param int $id Instance id
 * @return bool
 */
function webdavcheck_delete_instance($id) {
    global $DB;

    if (!$DB->record_exists('webdavcheck', ['id' => $id])) {
        return false;
    }

    $DB->delete_records('webdavcheck', ['id' => $id]);

    return true;
}

/**
 * Return the features supported by this module.
 *
 * @param string $feature FEATURE_xx constant
 * @return mixed True if feature supported, null if not
 */
function webdavcheck_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return true;
        case FEATURE_SHOW_DESCRIPTION:
            return true;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_COMPLETION_HAS_RULES:
            return true;
        case FEATURE_MODEDIT_DEFAULT_COMPLETION:
            return COMPLETION_TRACKING_AUTOMATIC;
        case FEATURE_BACKUP_MOODLE2:
            return true;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        default:
            return null;
    }
}

/**
 * Add a get_coursemodule_info function in case any WebDAV Check type wants to add 'extra' information
 * for the course (see resource).
 *
 * Given a course_module object, this function returns any "extra" information that may be needed
 * when printing this activity in a course listing. See get_array_of_activities() in course/lib.php.
 *
 * @param stdClass $coursemodule The coursemodule object (record).
 * @return cached_cm_info|false An object on information that the courses will know about
 */
function webdavcheck_get_coursemodule_info($coursemodule) {
    global $DB;

    $fields = 'id, name, intro, introformat, completionwebdav';
    if (!$webdavcheck = $DB->get_record('webdavcheck', ['id' => $coursemodule->instance], $fields)) {
        return false;
    }

    $result = new cached_cm_info();
    $result->name = $webdavcheck->name;

    if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
        $result->content = format_module_intro('webdavcheck', $webdavcheck, $coursemodule->id, false);
    }

    // Populate the custom completion rules as key => value pairs, but only if the completion mode is 'automatic'.
    if ($coursemodule->completion == COMPLETION_TRACKING_AUTOMATIC) {
        $result->customdata['customcompletionrules']['completionwebdav'] = $webdavcheck->completionwebdav;
    }

    return $result;
}

/**
 * Return the decrypted WebDAV service password from the admin settings.
 *
 * The password is stored encrypted by admin_setting_encryptedpassword
 * (see settings.php) using core\encryption.
 *
 * @return string The decrypted password, or an empty string if not set or not decryptable.
 */
function webdavcheck_get_webdav_password() {
    $stored = get_config('mod_webdavcheck', 'webdavpass');
    if ($stored === null || $stored === '') {
        return '';
    }

    try {
        return \core\encryption::decrypt($stored);
    } catch (\moodle_exception $e) {
        // The value cannot be decrypted with the current server key.
        return '';
    }
}

/**
 * Check if a file exists on the WebDAV server.
 *
 * @param stdClass $webdavcheck WebDAV Check instance
 * @param stdClass $user User object
 * @return array ['found' => bool, 'error' => string|null]
 */
function webdavcheck_check_file($webdavcheck, $user) {
    $config = get_config('mod_webdavcheck');

    if (empty($config->webdavurl) || empty($config->webdavuser) || empty($config->webdavpass)) {
        return ['found' => false, 'error' => get_string('error_noconfig', 'mod_webdavcheck')];
    }

    $pathtemplate = $webdavcheck->pathtemplate;
    $path = str_replace(['{$user}', '{user}'], rawurlencode($user->username), $pathtemplate);
    $url = rtrim($config->webdavurl, '/') . '/' . ltrim($path, '/');

    $files = webdavcheck_webdav_propfind($url, $config->webdavuser, webdavcheck_get_webdav_password());

    if (is_string($files)) {
        return ['found' => false, 'error' => $files];
    }

    foreach ($files as $file) {
        if (fnmatch($webdavcheck->filepattern, $file)) {
            return ['found' => true, 'error' => null];
        }
    }

    return ['found' => false, 'error' => null];
}

/**
 * Translate a curl result into a user-facing error string, or null if there was no error.
 *
 * @param string|bool $response curl response
 * @param int $httpcode HTTP status code
 * @param string $error curl error message
 * @return string|null error string or null if the request succeeded
 */
function webdavcheck_curl_error($response, $httpcode, $error) {
    if ($response === false) {
        return get_string('error_curl', 'mod_webdavcheck', $error);
    }
    if ($httpcode == 401) {
        return get_string('error_unauthorized', 'mod_webdavcheck');
    }
    if ($httpcode == 404) {
        return get_string('error_notfound', 'mod_webdavcheck');
    }
    return null;
}

/**
 * Perform a WebDAV PROPFIND request.
 *
 * @param string $url WebDAV URL
 * @param string $username WebDAV username
 * @param string $password WebDAV password
 * @return array|string Array of filenames or error string
 */
function webdavcheck_webdav_propfind($url, $username, $password) {
    $curl = new curl();
    $curl->setHeader(['Depth: 1', 'Content-Type: text/xml']);
    $response = $curl->get($url, [], [
        'CURLOPT_CUSTOMREQUEST' => 'PROPFIND',
        'CURLOPT_RETURNTRANSFER' => true,
        'CURLOPT_USERPWD' => $username . ':' . $password,
        'CURLOPT_TIMEOUT' => 30,
        'CURLOPT_CONNECTTIMEOUT' => 10,
    ]);

    $httpcode = $curl->get_info()['http_code'] ?? 0;
    $contenttype = $curl->get_info()['content_type'] ?? '';

    if ($errorstring = webdavcheck_curl_error($response, $httpcode, $curl->error)) {
        return $errorstring;
    }

    // Alfresco and some servers do not support PROPFIND (501).
    // If we get HTML instead of WebDAV XML, use GET fallback.
    if ($httpcode == 501 || stripos($contenttype, 'html') !== false) {
        return webdavcheck_webdav_get_html($url, $username, $password);
    }

    if ($httpcode != 207 && $httpcode != 200) {
        return get_string('error_http', 'mod_webdavcheck', $httpcode);
    }

    $files = webdavcheck_parse_webdav_xml($response, $url);
    if (is_string($files)) {
        // XML parsing failed, try HTML fallback.
        return webdavcheck_webdav_get_html($url, $username, $password);
    }
    return $files;
}

/**
 * Fallback: GET request and parse HTML directory listing.
 *
 * @param string $url WebDAV URL
 * @param string $username WebDAV username
 * @param string $password WebDAV password
 * @return array|string Array of filenames or error string
 */
function webdavcheck_webdav_get_html($url, $username, $password) {
    $curl = new curl();
    $response = $curl->get($url, [], [
        'CURLOPT_RETURNTRANSFER' => true,
        'CURLOPT_USERPWD' => $username . ':' . $password,
        'CURLOPT_TIMEOUT' => 30,
        'CURLOPT_CONNECTTIMEOUT' => 10,
    ]);

    $httpcode = $curl->get_info()['http_code'] ?? 0;

    if ($errorstring = webdavcheck_curl_error($response, $httpcode, $curl->error)) {
        return $errorstring;
    }

    if ($httpcode != 200) {
        return get_string('error_http', 'mod_webdavcheck', $httpcode);
    }

    $files = [];
    $parentlinks = ['[Eine Ebene höher]', '[Up a level]', '[Parent Directory]', '..'];

    // Use regex for more robust HTML parsing (Alfresco HTML is not well-formed).
    if (preg_match_all('/<a\s+[^>]*href=["\']([^"\']+)["\'][^>]*>(.*?)<\/a>/is', $response, $matches, PREG_SET_ORDER)) {
        foreach ($matches as $match) {
            $href = html_entity_decode($match[1], ENT_QUOTES, 'UTF-8');
            // Decode HTML entities in link text (e.g., h&#246;her -> höher).
            $text = html_entity_decode(trim(strip_tags($match[2])), ENT_QUOTES, 'UTF-8');
            // Skip parent directory links.
            if (in_array($text, $parentlinks, true)) {
                continue;
            }
            // Skip empty or javascript links.
            if (empty($text) || strpos($href, 'javascript:') === 0) {
                continue;
            }
            // Skip directories (URLs ending with /).
            if (substr($href, -1) === '/') {
                continue;
            }
            $files[] = $text;
        }
    }

    return $files;
}

/**
 * Parse WebDAV XML response.
 *
 * @param string $response XML response
 * @param string $url Request URL for comparison
 * @return array|string Array of filenames or error string
 */
function webdavcheck_parse_webdav_xml($response, $url) {
    $files = [];
    $xml = @simplexml_load_string($response);
    if ($xml === false) {
        return get_string('error_xml', 'mod_webdavcheck');
    }

    $xml->registerXPathNamespace('d', 'DAV:');
    $responses = $xml->xpath('//d:response');

    if (empty($responses)) {
        return get_string('error_xml', 'mod_webdavcheck');
    }

    $basepath = basename(urldecode(parse_url($url, PHP_URL_PATH)));
    foreach ($responses as $response) {
        $children = $response->children('DAV:');
        $href = (string) $children->href;
        $filename = basename(urldecode($href));
        if ($filename && $filename != $basepath) {
            $files[] = $filename;
        }
    }

    return $files;
}

/**
 * Event observer: course_module_created.
 * Moves draft files to the plugin file area after the module is created.
 *
 * @param \core\event\course_module_created $event
 */
function mod_webdavcheck_course_module_created($event) {
    global $DB;

    if ($event->other['modulename'] !== 'webdavcheck') {
        return;
    }

    $cmid = $event->objectid;
    $context = context_module::instance($cmid);
    $instanceid = $event->other['instanceid'];

    $webdavcheck = $DB->get_record('webdavcheck', ['id' => $instanceid]);
    if (!$webdavcheck) {
        return;
    }

    $editoroptions = ['subdirs' => true, 'maxfiles' => -1];

    // Process draft files in text fields.
    foreach (['successtext', 'failuretext'] as $field) {
        $text = $webdavcheck->$field;
        if (empty($text)) {
            continue;
        }

        // Find draft itemids in the text.
        if (preg_match_all('/draftfile\.php\#\/\d+\/user\/draft\/(\d+)\//', $text, $matches)) {
            $itemids = array_unique($matches[1]);
            foreach ($itemids as $itemid) {
                file_save_draft_area_files($itemid, $context->id, 'mod_webdavcheck', $field, 0, $editoroptions);
            }
        }
    }
}
