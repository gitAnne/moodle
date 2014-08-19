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
 * Authentication Plugin: URL Authentication
 * Just does a simple check against the moodle database.
 *
 * @package    auth_url
 * @copyright  2014 UPLearning, 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');

include($CFG->dirroot . '/auth/url/classes/event/user_login_failed.php');
$incfile = $CFG->dirroot . '/auth/url/locallib.php';
include_once($incfile);

$delete = optional_param('delete', -1, PARAM_INTEGER);
if ($delete != -1) {
  \auth_url\deleteSsoApp($delete);
}


/**
 * URL authentication plugin.
 *
 * @package    auth
 * @subpackage url
 * @copyright  2014 UPLearning, 1999 onwards Martin Dougiamas (http://dougiamas.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class auth_plugin_url extends auth_plugin_base {

    /**
     * The name of the component. Used by the configuration.
     */
    const COMPONENT_NAME = 'auth_url';

    /**
     * Constructor.
     */
    function auth_plugin_url() {
        $this->authtype = 'url';
        $this->config = get_config(self::COMPONENT_NAME);
    }

    /**
     * Returns true if the username and password work and false if they are
     * wrong or don't exist. (Non-mnet accounts only!)
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool Authentication success or failure.
     */
    function user_login($username, $password) {
        global $CFG, $DB, $USER;
        if (!$user = $DB->get_record('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id))) {
            return false;
        }
        $succes = ($user->password == $password); 
        return $succes;
    }

    /**
     * Updates the user's password.
     *
     * Called when the user password is updated.
     *
     * @param  object  $user        User table object
     * @param  string  $newpassword Plaintext password
     * @return boolean result
     */
    function user_update_password($user, $newpassword) {
        $user = get_complete_user_data('id', $user->id);
        set_user_preference('auth_url_passwordupdatetime', time(), $user->id);
        // This will also update the stored hash to the latest algorithm
        // if the existing hash is using an out-of-date algorithm (or the
        // legacy md5 algorithm).
        return update_internal_user_password($user, $newpassword);
    }

    function prevent_local_passwords() {
        return false;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return true;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
      return true;
      return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return moodle_url
     */
    function change_password_url() {
        return null;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    function can_reset_password() {
        return true;
    }

    /**
     * Returns true if plugin can be manually set.
     *
     * @return bool
     */
    function can_be_manually_set() {
        return true;
    }

    /**
     * Prints a form for configuring this authentication plugin.
     *
     * This function is called from admin/auth.php, and outputs a full page with
     * a form for configuring this plugin.
     *
     * @param array $config An object containing all the data for this page.
     * @param string $error
     * @param array $user_fields
     * @return void
     */
    function config_form($config, $err, $user_fields) {
        include 'config.html';
    }

    /**
     * Return number of days to user password expires.
     * As the user password does not expire, it returns 0.
     *
     * @param mixed $username username (with system magic quotes)
     * @return integer 0
     */
    public function password_expire($username) {
        $result = 0;
        return $result;
    }

    /**
     * Processes and stores configuration data for this authentication plugin.
     * Expiration is NOT supported
     *
     * @param stdClass $config
     * @return void
     */
    function process_config($config) {
      global $DB, $CFG;
      $process = (isset($config) && isset($config->newappname) && !empty($config->newappname)); 
      if ($process) {
        // add app
        $appName = $config->newappname;
        $curapp = $DB->get_record('auth_url', array('appname' => $appName));
        if ($curapp === false) {
          $tok = \auth_url\generateToken();
          $newapp = array('appname' => $appName, 'token' => $tok);
          $newid = $DB->insert_record('auth_url', $newapp);
        }
      
      }
      
      if (empty($config->incorrectcredentialsurl)) {
        $config->incorrectcredentialsurl = 'https://programmaleiderschap.nl/moodle/feedback/bad_credentials/{username}/{password}/{errorMessage}';
      }
      set_config('incorrectcredentialsurl', $config->incorrectcredentialsurl, self::COMPONENT_NAME);
      
      $returnurl = "$CFG->wwwroot/$CFG->admin/auth_config.php?auth=url";
      redirect($returnurl);
      exit;
        
      return true;
    }

   /**
    * Confirm the new user as registered. This should normally not be used,
    * but it may be necessary if the user auth_method is changed to URL
    * before the user is confirmed.
    *
    * @param string $username
    * @param string $confirmsecret
    */
    function user_confirm($username, $confirmsecret = null) {
        global $DB;

        $user = get_complete_user_data('username', $username);

        if (!empty($user)) {
            if ($user->confirmed) {
                return AUTH_CONFIRM_ALREADY;
            } else {
                $DB->set_field("user", "confirmed", 1, array("id"=>$user->id));
                if ($user->firstaccess == 0) {
                    $DB->set_field("user", "firstaccess", time(), array("id"=>$user->id));
                }
                return AUTH_CONFIRM_OK;
            }
        } else  {
            return AUTH_CONFIRM_ERROR;
        }
    }

    /**
     * Hook for overriding behaviour of login page.
     * This method is called from login/index.php page for all enabled auth plugins.
     *
     * @global object
     * @global object
     */
    function loginpage_hook() {
      global $DB;
      global $frm;  // can be used to override submitted login form
      global $user; // can be used to replace authenticate_user_login()
      //override if needed
      $username = optional_param('username', '', PARAM_RAW);
      $password = optional_param('password', '', PARAM_RAW);
      if (!empty($username) && !empty($password)) {
        $frm->username = $username;
        $frm->password = $password;
        $user = $DB->get_record('user', array('username' => $username));
      }
      $courseid = optional_param('courseid', '', PARAM_RAW);
      $sectionid = optional_param('sectionid', '', PARAM_RAW);
      if (!empty($courseid)) {
        $SESSION->wantsurl = $CFG->wwwroot . '/course/view.php?id=' . $courseid;
        if (!empty($sectionid)) {
          $SESSION->wantsurl .= '&section-' . $sectionid;
        }
      }
    }
    
    
}

