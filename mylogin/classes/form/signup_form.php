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
 * TODO describe file signup_form
 *
 * @package    local_mylogin
 * @copyright  2025 Mary Katsamani
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

/**
 * Definition.
 */
class signup_form extends moodleform {
    /**
     * Define the form.
     */
    public function definition() {

        global $CFG;
        global $DB;
        $mform = $this->_form; // Don't forget the underscore.

        $mform->addElement('text', 'surname', get_string('surname', 'local_mylogin'), 'maxlength="100" size="50"');
        $mform->addRule('surname', null, 'required', null, 'client');
        $mform->setType('surname', PARAM_NOTAGS);
        $mform->setDefault('surname', 'Please add surname');

        $mform->addElement('text', 'name', get_string('name', 'local_mylogin'), 'maxlength="100" size="50"');
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->setType('name', PARAM_NOTAGS);
        $mform->setDefault('name', 'Please add name');

        $country0 = [
            '0' => 'Please select your country',
        ];

        $country1 = $DB->get_records_menu('local_country');
        $country = array_merge($country0, $country1);

        $mform->addElement('select', 'country', get_string('country', 'local_mylogin'), $country);
        $mform->setDefault('country', '0');

        $mform->addElement('text', 'email', get_string('email', 'local_mylogin'), 'maxlength="100" size="50"');
        $mform->addRule('email', null, 'email', null, 'client');
        $mform->setType('email', PARAM_NOTAGS);
        $mform->setDefault('email', 'Please add email');

        $this->add_action_buttons(false, get_string('createaccount'));

    } // Close the function

}// Close the class
