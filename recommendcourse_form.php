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
 * Recommend a course form class for the block_recommend_course plugin.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once("$CFG->libdir/formslib.php");
/**
 * Form for recommending a course to selected users.
 *
 * This form allows selecting a course and one or more users to whom the
 * recommendation will be sent. AJAX-based autocomplete fields may be used
 * depending on configuration.
 *
 * @package    block_recommend_course
 * @category   form
 */
class recommendcourse_form extends moodleform {
    /**
     * Add elements to form
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form;

        // Add course autocomplete with AJAX.
        $options = [
            'ajax' => 'block_recommend_course/form-course-selector',
            'multiple' => false,
            'noselectionstring' => get_string('select_course', 'block_recommend_course'),
        ];
        $mform->addElement(
            'autocomplete',
            'course',
            get_string('select_course', 'block_recommend_course'),
            [],
            $options
        );
        $mform->addRule('course', get_string('required'), 'required', null, 'client');

        // Add user multi-select autocomplete with AJAX.
        $useroptions = [
            'ajax' => 'block_recommend_course/form-user-selector',
            'multiple' => true,
            'noselectionstring' => get_string('noselection_string', 'block_recommend_course'),
        ];
        $mform->addElement(
            'autocomplete',
            'users',
            get_string('select_users', 'block_recommend_course'),
            [],
            $useroptions
        );
        $mform->addRule('users', get_string('required'), 'required', null, 'client');

        $this->add_action_buttons(true, get_string('submit'));
    }
}
