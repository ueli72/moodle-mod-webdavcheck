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
 * Custom completion rules for mod_webdavcheck.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

declare(strict_types=1);

namespace mod_webdavcheck\completion;

use core_completion\activity_custom_completion;

/**
 * Activity custom completion subclass for the WebDAV Check activity.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class custom_completion extends activity_custom_completion {

    /**
     * Fetches the completion state for a given completion rule.
     *
     * @param string $rule The completion rule.
     * @return int The completion state.
     */
    public function get_state(string $rule): int {
        global $CFG, $DB;

        $this->validate_rule($rule);

        $webdavcheck = $DB->get_record('webdavcheck', ['id' => $this->cm->instance]);
        if (!$webdavcheck || empty($webdavcheck->completionwebdav)) {
            return COMPLETION_INCOMPLETE;
        }

        $user = $DB->get_record('user', ['id' => $this->userid, 'deleted' => 0], 'id, username');
        if (!$user) {
            return COMPLETION_INCOMPLETE;
        }

        // Perform the real WebDAV check for this user.
        require_once($CFG->dirroot . '/mod/webdavcheck/lib.php');
        $result = webdavcheck_check_file($webdavcheck, $user);

        return $result['found'] ? COMPLETION_COMPLETE : COMPLETION_INCOMPLETE;
    }

    /**
     * Fetch the list of custom completion rules that this module defines.
     *
     * @return array
     */
    public static function get_defined_custom_rules(): array {
        return [
            'completionwebdav',
        ];
    }

    /**
     * Returns an associative array of the descriptions of custom completion rules.
     *
     * @return array
     */
    public function get_custom_rule_descriptions(): array {
        return [
            'completionwebdav' => get_string('completiondetail:webdavfile', 'mod_webdavcheck'),
        ];
    }

    /**
     * Returns an array of all completion rules, in the order they should be displayed to users.
     *
     * @return array
     */
    public function get_sort_order(): array {
        return [
            'completionview',
            'completionwebdav',
        ];
    }
}
