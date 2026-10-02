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
 * WebDAV Check renderer.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * WebDAV Check renderer class.
 *
 * @package    mod_webdavcheck
 * @copyright  2026 Ueli Leutwyler
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_webdavcheck_renderer extends plugin_renderer_base {
    /**
     * Render the check result with icons and text.
     *
     * @param array $result Check result ['found' => bool, 'error' => string|null]
     * @param stdClass $webdavcheck WebDAV Check instance
     * @param context_module $context Module context
     * @return string HTML output
     */
    public function render_check_result($result, $webdavcheck, $context) {
        $output = '';

        if ($result['found']) {
            $text = file_rewrite_pluginfile_urls(
                $webdavcheck->successtext,
                'pluginfile.php',
                $context->id,
                'mod_webdavcheck',
                'successtext',
                0
            );
            $text = format_text($text, $webdavcheck->successtextformat, ['context' => $context]);
            $output .= html_writer::div(
                html_writer::tag('i', '', ['class' => 'fa-solid fa-check-circle fa-3x text-success']) .
                html_writer::div($text, 'webdavcheck-text'),
                'webdavcheck-status webdavcheck-success'
            );
        } else if ($result['error']) {
            $output .= html_writer::div(
                html_writer::tag('i', '', ['class' => 'fa-solid fa-exclamation-triangle fa-3x text-warning']) .
                html_writer::div($result['error'], 'webdavcheck-text alert alert-warning'),
                'webdavcheck-status webdavcheck-error'
            );
        } else {
            $text = file_rewrite_pluginfile_urls(
                $webdavcheck->failuretext,
                'pluginfile.php',
                $context->id,
                'mod_webdavcheck',
                'failuretext',
                0
            );
            $text = format_text($text, $webdavcheck->failuretextformat, ['context' => $context]);
            $output .= html_writer::div(
                html_writer::tag('i', '', ['class' => 'fa-solid fa-times-circle fa-3x text-danger']) .
                html_writer::div($text, 'webdavcheck-text'),
                'webdavcheck-status webdavcheck-failure'
            );
        }

        return $output;
    }
}
