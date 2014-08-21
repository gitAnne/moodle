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
 * Strings for component 'enrol_url', language 'nl'.
 *
 * @package   enrol_url
 * @copyright 2014 UP Learnin, 1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['url:config'] = 'Configureer URL enrol instances';
$string['url:unenrol'] = 'Unenrol suspended users';
$string['debugdb'] = 'Debug ADOdb';
$string['debugdb_desc'] = 'Debug ADOdb connection to external database - use when getting empty page during login. Not suitable for production sites!';
$string['defaultcategory'] = 'Default new course category';
$string['defaultcategory_desc'] = 'The default category for auto-created courses. Used when no new category id specified or not found.';
$string['defaultrole'] = 'Default rol';
$string['defaultrole_desc'] = 'De rol die wordt toegewezen bij het automatisch deelnemen aan een cursus.';
$string['ignorehiddencourses'] = 'Negeer onzichtbare cursussen';
$string['ignorehiddencourses_desc'] = 'Indien geselecteerd wordt gebruiker niet enrolled in cursussen die niet beschikbaar zijn voor een gebruiker.';
$string['pluginname'] = 'URL cursus enrolment';
$string['pluginname_desc'] = 'De URL enrolment kan gebruikt worden om iemand met de juiste url direct toegangt e geven tot een cursus.';
$string['templatecourse'] = 'Templete cursus.';
$string['templatecourse_desc'] = 'Optioneel: automatisch aangemaakt cursussen kunnen op basis van een template worden gemaakt..';

$string['settingsheaderurl'] = 'Algemene settings';
$string['settingsheaderlocal'] = 'Filter veld selectie';

$string['status'] = 'Enable url enrolments';
$string['status_desc'] = 'Allow course access of internally enrolled users. This should be kept enabled in most cases.';
$string['status_help'] = 'This setting determines whether users can be enrolled manually, via a link in the course administration settings, by a user with appropriate permissions such as a teacher.';
$string['statusenabled'] = 'Enabled';
$string['statusdisabled'] = 'Disabled';
$string['unenrol'] = 'Unenrol user';
$string['unenrolselectedusers'] = 'Unenrol selected users';

$string['filteruserfield1'] = 'User field filter 1';
$string['filteruserfield2'] = 'User field filter 2';
$string['filteruserfield3'] = 'User field filter 3';
$string['filteruserfield4'] = 'User field filter 4';
$string['filteruserfield5'] = 'User field filter 5';

$string['filterfield'] = 'Filter field';
$string['filterfield_option_ignore'] = 'Ignore';
$string['filterfield_option_contains'] = 'Contains';
$string['filterfield_option_not_contains'] = 'Does NOT contain';
$string['filterfield_help'] = 'Select which filter to apply for this field.<br/>If the user field does not meet the filter they will not be enrolled automatically<br/>Options are:<br/>Ignore - Filtering on this field is ignored,<br/>Contains - The (caseinsensative) text must be present in this field<br/>Does not contain - The (caseinsensative) text must NOT be present in this field';
