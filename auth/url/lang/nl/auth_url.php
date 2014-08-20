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

$string['auth_urldescription'] = 'Deze authenticatie methode maakt het mogelijk om mbv een url aanroep in te loggenmet het juist token, gebruikersnaame en (encoded) password.<br/> Indien cusrus id (courseid) en optioneel sectie nummer (section id) als paramter worden meegeven wordt er geforward naar de betreffende cursus en sectie.<br/> Voorbeeld: http://dev-moodle-2-7-0/auth/url/logonrequest.php?username=user003&password=dXBhZG0xbi1NMDBkbDM=&token=5b1a0afd40a09e4cf93d447f5c6aae4637332c89d57e332b58ed6dbf4f0de932&courseid=2&sectionid=7';
$string['pluginname'] = 'URL requests';

$string['eventuserloginfailed'] = 'Gebruiker inloggen mislukt';

$string['authurl_settings'] = 'Auth URL Settings';
$string['incorrectcredentialsurl'] = 'Verkeerde credentials URL';
$string['incorrectcredentialsurl_desc'] = 'Deze URL wordt aangeroepen als de credentials fout zijn. De varaiablen {} worden ingevuld.';

$string['ssoappnameheader'] = 'SSO App Naam';
$string['ssoapptokenheader'] = 'SSO App Token';

$string['newapp'] = 'Nieuwe App:';

$string['newappname_desc'] = 'Nieuwe App Naam';

$string['addapp'] = 'Voeg App toe';
