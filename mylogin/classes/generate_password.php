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
 * Class generate_password
 *
 * @package    local_mylogin
 * @copyright  2025 Mary Katsamani
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class generate_password {
     /**
      * Define generatepassword.
      */
    public function generatepassword($len) {

        $alphasmall = 'abcdefghijklmnopqrstuvwxyz';            // Small letters.
        $alphacaps  = strtoupper($alphasmall);                // CAPITAL LETTERS.
        $numerics   = '1234567890';                            // Numerics.
        $specialchars = '%-#_*@';                              // Special Characters.

        $container = $alphasmall.$alphacaps.$numerics.$specialchars;   // Contains all characters.
        $password = '';         // Will contain the desired pass - will use later.
        // Loop till two characters less than the desired length.
        for ($i = 2; $i < $len; $i++) {
            $rand = rand(0, strlen($container) - 1);                  // Get Randomized Length.
            $password .= substr($container, $rand, 1);                // Returns part of the string.
        }
        $password .= substr($numerics, rand(0, strlen($numerics) - 1), 1);    // Add a number.
        $password .= substr($specialchars, rand(0, strlen($specialchars) - 1), 1);    // Add a special character.

          // Shuffle the password characters because the number and the special characters comes at fixed position.
          $passwordarray = str_split($password);
          shuffle($passwordarray);
          $password = implode('', $passwordarray);

        return $password;       // Test Returns the generated Pass.
    }
}
