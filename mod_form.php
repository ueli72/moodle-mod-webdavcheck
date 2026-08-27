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
 * WebDAV Check mod form.
 *
 * @package    mod_webdavcheck
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');

/**
 * WebDAV Check settings form.
 *
 * @package    mod_webdavcheck
 * @copyright  2026
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_webdavcheck_mod_form extends moodleform_mod {

    /**
     * Define the form.
     */
    public function definition() {
        $mform = $this->_form;

        // General settings.
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('webdavcheckname', 'mod_webdavcheck'), ['size' => '64']);
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        $this->standard_intro_elements();

        // WebDAV settings.
        $mform->addElement('header', 'webdavsettings', get_string('webdavsettings', 'mod_webdavcheck'));

        $mform->addElement('text', 'pathtemplate', get_string('pathtemplate', 'mod_webdavcheck'), ['size' => '64']);
        $mform->setType('pathtemplate', PARAM_TEXT);
        $mform->addRule('pathtemplate', null, 'required', null, 'client');
        $mform->addHelpButton('pathtemplate', 'pathtemplate', 'mod_webdavcheck');

        $mform->addElement('text', 'filepattern', get_string('filepattern', 'mod_webdavcheck'), ['size' => '64']);
        $mform->setType('filepattern', PARAM_TEXT);
        $mform->setDefault('filepattern', '*.docx');
        $mform->addRule('filepattern', null, 'required', null, 'client');
        $mform->addHelpButton('filepattern', 'filepattern', 'mod_webdavcheck');

        // Message texts.
        $mform->addElement('header', 'messagetexts', get_string('messagetexts', 'mod_webdavcheck'));

        $editoroptions = ['subdirs' => true, 'maxfiles' => -1];

        $mform->addElement('editor', 'successtext', get_string('successtext', 'mod_webdavcheck'), null, $editoroptions);
        $mform->setType('successtext', PARAM_RAW);
        $mform->addRule('successtext', null, 'required', null, 'client');

        $mform->addElement('editor', 'failuretext', get_string('failuretext', 'mod_webdavcheck'), null, $editoroptions);
        $mform->setType('failuretext', PARAM_RAW);
        $mform->addRule('failuretext', null, 'required', null, 'client');

        // Connection test link (only when editing existing instance).
        if ($this->current && !empty($this->current->instance)) {
            $mform->addElement('header', 'testsection', get_string('testconnection', 'mod_webdavcheck'));
            $testurl = new moodle_url('/mod/webdavcheck/test_activity.php', ['instance' => $this->current->instance]);
            $testlink = html_writer::link(
                $testurl,
                get_string('testbutton', 'mod_webdavcheck'),
                ['class' => 'btn btn-secondary', 'target' => '_blank']
            );
            $mform->addElement('static', 'testlink', '', $testlink);
            $mform->addHelpButton('testlink', 'testwithuser', 'mod_webdavcheck');
        }

        $this->standard_coursemodule_elements();
        $this->add_action_buttons();
    }

    /**
     * Add custom completion rules.
     *
     * @return array List of element names that are completion rules.
     */
    public function add_completion_rules() {
        $mform = $this->_form;
        $mform->addElement('checkbox', 'completionwebdav', '', get_string('completionwebdav', 'mod_webdavcheck'));
        return ['completionwebdav'];
    }

    /**
     * Check whether a custom completion rule is enabled.
     *
     * @param array $data Submitted form data
     * @return bool
     */
    public function completion_rule_enabled($data) {
        return !empty($data['completionwebdav']);
    }

    /**
     * Preprocess form data before display.
     *
     * @param array $defaultvalues
     */
    public function data_preprocessing(&$defaultvalues) {
        parent::data_preprocessing($defaultvalues);

        if ($this->current->instance) {
            $context = $this->context;
            $editoroptions = ['subdirs' => true, 'maxfiles' => -1];

            $draftitemid = file_get_submitted_draft_itemid('successtext');
            $defaultvalues['successtext'] = [
                'text' => file_prepare_draft_area($draftitemid, $context->id, 'mod_webdavcheck', 'successtext', 0, $editoroptions, $defaultvalues['successtext'] ?? ''),
                'format' => $defaultvalues['successtextformat'] ?? FORMAT_HTML,
                'itemid' => $draftitemid,
            ];

            $draftitemid = file_get_submitted_draft_itemid('failuretext');
            $defaultvalues['failuretext'] = [
                'text' => file_prepare_draft_area($draftitemid, $context->id, 'mod_webdavcheck', 'failuretext', 0, $editoroptions, $defaultvalues['failuretext'] ?? ''),
                'format' => $defaultvalues['failuretextformat'] ?? FORMAT_HTML,
                'itemid' => $draftitemid,
            ];
        } else {
            $defaultvalues['successtext'] = [
                'text' => '',
                'format' => editors_get_preferred_format(),
                'itemid' => 0,
            ];
            $defaultvalues['failuretext'] = [
                'text' => '',
                'format' => editors_get_preferred_format(),
                'itemid' => 0,
            ];
        }
    }
}
