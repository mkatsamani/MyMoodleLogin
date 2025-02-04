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
 * TODO describe file signin
 *
 * @package    local_mylogin
 * @copyright  2025 Mary Katsamani
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once('classes/form/login_form.php');
require_login();

$PAGE->set_url('/local/mylogin/login.php');
$PAGE->set_context(\core\context\system::instance());
$PAGE->set_pagelayout('login');

$PAGE->set_heading($SITE->fullname);

$strlogin = get_string('login', 'local_mylogin');
$PAGE->set_title($strlogin);

echo $OUTPUT->header();

$templatecontext = (object)[
    'loginFormHeaderText' => 'Log In For MoodleSite',
];
echo $OUTPUT->render_from_template('local_mylogin/login', $templatecontext);

echo "<b> <i> Welcome to MoodleSite. Please sign in with your credentials.</b></i><p>";

$mform = new login_form();

if ($mform->is_cancelled()) {
    // Go back.
    redirect('login.php', 'You cancelled the message form!');
} else if ($fromform = $mform->get_data()) {

    $hashed = hash("sha512", $fromform->password);
    $user = $DB->get_record('local_user', ['email' => $fromform->username, 'password' => $hashed]);
    if ($user) {
        if ($user->lastlogindate == null) {
            redirect('changepassword.php');
        } else {
            // Update login date.
            $date = new DateTime();
            $user->lastlogindate = date('Y-m-d h:i:sa');
            $DB->update_record('local_user', $user);

            // Go to Dashboard.
            redirect('/moodle/my/index.php');
        }
    } else {
        redirect('login.php', 'Error', 10);
    }
}
$mform->display();


echo $OUTPUT->footer();
