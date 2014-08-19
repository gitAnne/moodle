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
 * Strings for component 'auth_url', language 'en'.
 *
 * @package   auth_url
 * @copyright 2014 UP Learning, 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// TODO No expiration

$string['auth_urldescription'] = 'This method allows logon using the correct url with token, username and (encoded) password.<br/> If course id and section id are present it then redirects to the requested course and section.<br/> Example: http://dev-moodle-2-7-0/auth/url/logonrequest.php?username=user003&password=$2y$10$Q9ofcE71sQpKJKHcYHG.ZO51QmGaoHZz7O.8gBrxKvJeMXZj4Cx/G&token=5b1a0afd40a09e4cf93d447f5c6aae4637332c89d57e332b58ed6dbf4f0de932&courseid=2&sectionid=7';
$string['pluginname'] = 'URL requests';

$string['eventuserloginfailed'] = 'User login failed';

$string['authurl_settings'] = 'Auth URL Settings';
$string['incorrectcredentialsurl'] = 'Incorrect Credentials URL';
$string['incorrectcredentialsurl_desc'] = 'URL to call when incorrect credentials are used.';

$string['ssoappnameheader'] = 'SSO App Name';
$string['ssoapptokenheader'] = 'SSO App Token';

$string['newapp'] = 'New App:';

$string['newappname_desc'] = 'New App Name';

$string['addapp'] = 'Add App';
