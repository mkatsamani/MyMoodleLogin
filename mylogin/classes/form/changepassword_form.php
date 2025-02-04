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
 * TODO describe file changepassword_form
 *
 * @package    local_mylogin
 * @copyright  2025 Mary Katsamani
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

require_login();

/**
 * Definition
 */
class changepassword_form extends moodleform {
    /**
     * Define the form.
     */
    public function definition() {

        global $CFG;
        global $DB;
        $mform = $this->_form; // Don't forget the underscore!

        $mform->addElement('text', 'username', get_string('email', 'local_mylogin'), 'maxlength="100" size="50"');
        $mform->addRule('username', null, 'email', null, 'client');
        $mform->setType('username', PARAM_NOTAGS);
        $mform->setDefault('username', 'Insert email');

        $mform->addElement('password', 'password', get_string('password', 'local_mylogin'), 'maxlength="100" size="50"');
        $mform->addRule('password', null, 'required', null, 'client');
        $mform->setType('password', PARAM_RAW);

        $mform->addElement('password', 'passwordNew', get_string('passwordNew', 'local_mylogin'), 'maxlength="100" size="50"');
        $mform->addRule('passwordNew', null, 'required', null, 'client');
        $mform->setType('passwordNew', PARAM_RAW);

        $mform->addElement('password', 'passwordNew2', get_string('newpassword') . ' (' . get_String('again') . ')',
         'maxlength="100" size="50"');
        $mform->addRule('passwordNew2', get_string('required'), 'required', null, 'client');
        $mform->setType('passwordNew2', PARAM_RAW);

        $this->add_action_buttons(false);

    } // Close the function

}// Close the class
