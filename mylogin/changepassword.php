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
 * TODO describe file changepassword
 *
 * @package    local_mylogin
 * @copyright  2025 Mary Katsamani
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('classes/form/changepassword_form.php');

require_login();

$PAGE->set_url('/local/mylogin/changepassword.php');
$PAGE->set_context(\core\context\system::instance());
$PAGE->set_pagelayout('login');
$PAGE->set_heading($SITE->fullname);
echo $OUTPUT->header();

$strchangepassword = get_string('changepassword', 'local_mylogin');
$PAGE->set_title($strchangepassword);


$templatecontext = (object)[
    'changepasswordFormHeaderText' => 'Change Password Form',
];

echo $OUTPUT->render_from_template('local_mylogin/changepassword', $templatecontext);

$mform = new changepassword_form();

if ($mform->is_cancelled()) {

    redirect('changepassword.php', 'You cancelled the message form!');
} else if ($fromform = $mform->get_data()) {
    // When the form is submitted, and the data is successfully validated,
    // the `get_data()` function will return the data posted in the form.
    // var_dump($fromform);
    // die().
    $user = $DB->get_record('local_user', ['email' => $fromform->username, 'password' => hash("sha512", $fromform->password)]);

    if ($user) {

        $hashed = hash("sha512", $fromform->passwordNew);

        $user->password = $hashed;
        $date = new DateTime();
        $user->lastlogindate = date('Y-m-d h:i:sa');
        $DB->update_record('local_user', $user);
    }


       redirect('login.php', 'User ' . $fromform->surname . ' ' . $fromform->name . 'has changed password!');
}
$mform->display();

echo $OUTPUT->footer();
?>

<script>
    // const myElement = document.getElementById("id_submitbutton");
    // myElement.style.backgroundColor = "grey";

    // const myElementUsername = document.getElementById("id_username");
    // myElementUsername.style.width = "300px";
    // const myElementPassword = document.getElementById("id_password");
    // myElementPassword.style.width = "300px";
    // const myElementPasswordNew = document.getElementById("id_passwordNew");
    // myElementPasswordNew.style.width = "300px";
</script>
