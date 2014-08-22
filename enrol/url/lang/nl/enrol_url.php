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
$string['url:unenrol'] = 'Verwijder geschorste gebruikers uit cursus';
$string['debugdb'] = 'Debug ADOdb';
$string['debugdb_desc'] = 'Debug ADOdb connection to external database - use when getting empty page during login. Not suitable for production sites!';
$string['defaultcategory'] = 'Standaardcategorie voor nieuwe cursussen';
$string['defaultcategory_desc'] = 'De standaarcategorie voor automatisch aangemaakte cursussen. Gebruikt wanneer er geen categorieID is opgegeven of wanneer die niet gevonden is.';
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

$string['status'] = 'Zet url enrolments aan';
$string['status_desc'] = 'Sta het inschrijven via de url methode toe. Dit zal over het algemeen aan moeten blijven staan.';
$string['status_help'] = 'Deze instellingen bepalen of een gebruiker automatisch kan worden ingeschreven indien bepaalde veld waarden voldoen aan de opgegeven filters.';
$string['statusenabled'] = 'Aan';
$string['statusdisabled'] = 'Uit';
$string['unenrol'] = 'Schrijf gebruiker uit';
$string['unenrolselectedusers'] = 'Schrijf geselecteerde gebruikers uit';

$string['filteruserfield1'] = 'User field filter 1';
$string['filteruserfield2'] = 'User field filter 2';
$string['filteruserfield3'] = 'User field filter 3';
$string['filteruserfield4'] = 'User field filter 4';
$string['filteruserfield5'] = 'User field filter 5';

$string['filterfield'] = 'Filter field';
$string['filterfield_option_ignore'] = 'Negeer';
$string['filterfield_option_contains'] = 'Bevat';
$string['filterfield_option_not_contains'] = 'Bevat NIET';
$string['filterfield_help'] = 'Selecteer welk filter moet worden toegepast voor het veld.<br/>Als de waarde(s) van de gebruiker (user) niet voldoet aan de 1 van de filters zal deze niet automatisch worden ingeschreven.<br/>Opties zijn:<br/>Negeer - Dit filter wordt niet gebruikt,<br/>Bevat - De (caseinsensative) waarde moet in het veld voor komen<br/>Bevat NIET - De (caseinsensative) waarde moet NIET in het veld voor komen';
