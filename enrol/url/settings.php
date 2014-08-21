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
 * URL enrolment plugin settings and presets.
 *
 * @package    enrol_url
 * @copyright  2014 UP Learning, 2010 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_url_settings', '', get_string('pluginname_desc', 'enrol_url')));

    $settings->add(new admin_setting_heading('enrol_url_exdbheader', get_string('settingsheaderurl', 'enrol_url'), ''));

    if (!during_initial_install()) {
      $options = get_default_enrol_roles(context_system::instance());
      $student = get_archetype_roles('student');
      $student = reset($student);
      $settings->add(new admin_setting_configselect('enrol_url/defaultrole', get_string('defaultrole', 'enrol_url'), get_string('defaultrole_desc', 'enrol_url'), $student->id, $options));
      
      $settings->add(new admin_setting_configselect('enrol_url/defaultcategory', get_string('defaultcategory', 'enrol_url'), get_string('defaultcategory_desc', 'enrol_url'), 1, make_categories_options()));
    }
    
    
    $settings->add(new admin_setting_heading('enrol_url_localheader', get_string('settingsheaderlocal', 'enrol_url'), ''));
    
    $userfields = array('idnumber', 'firstname', 'lastname', 'email', 'institution', 'department', 'address', 'city', 'country', 'middlename', 'alternatename');
    $options = array('none' => '');
    foreach ($userfields as $field) {
      $options[$field] = $field;
    }
    
    $settings->add(new admin_setting_configselect('enrol_url/filteruserfield1', get_string('filteruserfield1', 'enrol_url'), '', 'none', $options));

    $settings->add(new admin_setting_configselect('enrol_url/filteruserfield2', get_string('filteruserfield2', 'enrol_url'), '', 'none', $options));

    $settings->add(new admin_setting_configselect('enrol_url/filteruserfield3', get_string('filteruserfield3', 'enrol_url'), '', 'none', $options));

    $settings->add(new admin_setting_configselect('enrol_url/filteruserfield4', get_string('filteruserfield4', 'enrol_url'), '', 'none', $options));

    $settings->add(new admin_setting_configselect('enrol_url/filteruserfield5', get_string('filteruserfield5', 'enrol_url'), '', 'none', $options));

}
