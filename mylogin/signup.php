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
 * TODO describe file signup
 *
 * @package    local_mylogin
 * @copyright  Mary Katsamani
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

require_once('classes/form/signup_form.php');
require_once('classes/generate_password.php');

$PAGE->set_url('/local/mylogin/signup.php');
$PAGE->set_context(\core\context\system::instance());
$PAGE->set_pagelayout('login');
$PAGE->set_heading($SITE->fullname);
$strsignup = get_string('signup', 'local_mylogin');
$PAGE->set_title($strsignup);

echo $OUTPUT->header();

$temppassword = new generate_password();

$templatecontext = (object)[
    'signupFormHeaderText' => 'Sign Up For MoodleSite',
];

echo $OUTPUT->render_from_template('local_mylogin/signup', $templatecontext);

$mform = new signup_form();

if ($mform->is_cancelled()) {
    // Go back.
    redirect('signup.php', 'You cancelled the message form!');
} else if ($fromform = $mform->get_data()) {

    $recordtoinsert = new stdClass();
    $recordtoinsert->surname = $fromform->surname;
    $recordtoinsert->name = $fromform->name;
    $recordtoinsert->countryid = (int)$fromform->country;
    $recordtoinsert->email = $fromform->email;
    $temppasswordtosend = $temppassword->generatepassword(13);
    $recordtoinsert->password = hash("sha512", $temppasswordtosend);
    $recordtoinsert->lastlogindate = null;
    $DB->insert_record('local_user', $recordtoinsert);

    $subject = "Verification Email";
    $message = '<html><body>Welcome to Moodle. Temporary password <b>' .  $temppasswordtosend . '</b> has been created Please <a href="http://localhost/moodle/local/mylogin/login.php" target="_blank"> log in </a> using this password and change your password afterwards.</body></html>';

    // To send HTML mail, the Content-type header must be set.
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=iso-8859-1';

    $success = mail($fromform->email, $subject, $message, implode("\r\n", $headers));
    if (!$success) {
        error_get_last()['message'];
    } else {
        echo 'User ' . $fromform->surname . ' ' . $fromform->name .
            ' has been created. A verification email has been sent to your email with a temporary password. Please login in and change your password.';
    }
} else {
    echo "<b> <i> Welcome to our site. Please sign up.</b></i><p>";
    $mform->display();
    echo "<i>Already have an account?. <a href='http://localhost/moodle/local/mylogin/login.php' target='_blank'> Log In </a></i>";
}


echo $OUTPUT->footer();
?>

<script>
    // const myElement1 = document.getElementById("id_cancel");
    // myElement1.hidden=true;

    // const myElement = document.getElementById("id_submitbutton");
    // myElement.value = "Continue";
    // myElement.style.backgroundColor = "grey";


    // const myElementSurname = document.getElementById("id_surname");
    // myElementSurname.style.width = "300px";
    // const myElementName = document.getElementById("id_name");
    // myElementName.style.width = "300px";
    // const myElementEmail = document.getElementById("id_email");
    myElementEmail.style.width = "300px";
    const myElementCountry = document.getElementById("id_country");
    myElementCountry.style.width = "300px";
</script>
