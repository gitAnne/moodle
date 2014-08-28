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
 * Adds new instance of enrol_url to specified course
 * or edits current instance.
 *
 * @package    enrol_url
 * @copyright  2014 UP Learning, 2010 Petr Skoda  {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/formslib.php');

class enrol_url_edit_form extends moodleform {

    function definition() {
        // Get the selected field filters
        $plugin = enrol_get_plugin('url');
        $filterfields = array();
        for ($i=1; $i<=5; $i++) {
          $filterfields[$i] = $plugin->get_config('filteruserfield' . $i); 
        }
      
        $mform = $this->_form;

        list($instance, $plugin, $context) = $this->_customdata;

        $mform->addElement('header', 'header', get_string('settingsheaderurl', 'enrol_url'));

        $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                         ENROL_INSTANCE_DISABLED => get_string('no'));
        
        $mform->addElement('select', 'status', get_string('status', 'enrol_url'), $options);
        $mform->addHelpButton('status', 'status', 'enrol_url');
        $mform->setDefault('status', $plugin->get_config('status'));

        if ($instance->id) {
            $roles = get_default_enrol_roles($context, $instance->roleid);
        } else {
            $roles = get_default_enrol_roles($context, $plugin->get_config('roleid'));
        }
        $mform->addElement('select', 'roleid', get_string('defaultrole', 'role'), $roles);
        $mform->setDefault('roleid', $plugin->get_config('roleid'));
        
        $mform->addElement('header', 'header', get_string('settingsheaderlocal', 'enrol_url'));
        
        if (isset($instance->customtext1) && !empty($instance->customtext1)) {
          $storedfilters = unserialize($instance->customtext1);
          
          
        }
        
        $attributes = array('size' => '110', 'maxsize' => 255);
        $filteroptions = array($plugin::FIELD_FILTER_NOT_CONTAINS => get_string('filterfield_option_not_contains', 'enrol_url'),
                              $plugin::FIELD_FILTER_CONTAINS => get_string('filterfield_option_contains', 'enrol_url'),
                              $plugin::FIELD_FILTER_IGNORE   => get_string('filterfield_option_ignore', 'enrol_url'));
        foreach ($filterfields as $filterfield) {
          if (!empty($filterfield) && ($filterfield != $plugin::FIELD_FILTER_NONE)) {
            if (!isset($storedfilters[$filterfield][$plugin::FIELD_FILTER_CONDITION])) {
              $storedfilters[$filterfield][$plugin::FIELD_FILTER_CONDITION] = $plugin::FIELD_FILTER_IGNORE; 
            }
            if (!isset($storedfilters[$filterfield][$plugin::FIELD_FILTER_VALUE])) {
              $storedfilters[$filterfield][$plugin::FIELD_FILTER_VALUE] = ''; 
            }
            $filterarray = array();
            $filterarray[] =& $mform->createElement('select', 'filterfields[' . $filterfield . ']['. $plugin::FIELD_FILTER_CONDITION . ']', '', $filteroptions);
            $filterarray[] =& $mform->createElement('text', 'filterfields[' . $filterfield . ']['. $plugin::FIELD_FILTER_VALUE . ']', '', $attributes);
            
            $mform->addGroup($filterarray, 'filterar_' . $filterfield, $filterfield, array(' '), false);
            
            $mform->addHelpButton('filterar_' . $filterfield, 'filterfield', 'enrol_url');
            $mform->setDefault('filterfields[' . $filterfield . ']['. $plugin::FIELD_FILTER_CONDITION . ']', $storedfilters[$filterfield][$plugin::FIELD_FILTER_CONDITION]);
            $mform->setType('filterfields[' . $filterfield . ']['. $plugin::FIELD_FILTER_VALUE . ']', PARAM_RAW);
            $mform->setDefault('filterfields[' . $filterfield . ']['. $plugin::FIELD_FILTER_VALUE . ']', $storedfilters[$filterfield][$plugin::FIELD_FILTER_VALUE]);
            
          }
        }
        
        $mform->addElement('hidden', 'courseid');
        $mform->setType('courseid', PARAM_INT);

        if (function_exists('enrol_accessing_via_instance') && enrol_accessing_via_instance($instance)) {
            $mform->addElement('static', 'selfwarn', get_string('instanceeditselfwarning', 'core_enrol'), get_string('instanceeditselfwarningtext', 'core_enrol'));
        }

        $this->add_action_buttons(true, ($instance->id ? null : get_string('addinstance', 'enrol')));

        $this->set_data($instance);
    }

    function validation($data, $files) {
        global $DB;

        $errors = parent::validation($data, $files);

        return $errors;
    }
}
