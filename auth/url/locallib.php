<?php

namespace auth_url;

/*
 * Get all defined SSO Apps from auth_url table
 * 
 * @return Array $ssoApps Array of records SSO Apps
 */
function getSsoApps() {
  global $DB;
  $ssoApps = $DB->get_records('auth_url');
  if ($ssoApps === false) {
    $ssoApps = array();
  }
  return $ssoApps; 
}


/*
 * Create HTML for displaying SSO App information
 * 
 * @return String $ssoapphtml The table html code for the SSO App info  
 */
function getSsoAppHtml() {
  global $CFG, $OUTPUT;
  include_once($CFG->libdir . '/outputcomponents.php');
  include_once($CFG->libdir . '/weblib.php');
  $ssoapphtml = "";
  $ssoApps = \auth_url\getSsoApps();
  foreach ($ssoApps as $said => $ssoApp) {
    $url = new \moodle_url('/admin/auth_config.php', array('delete'=>$said, 'auth' => 'url', 'sesskey'=>sesskey()));
    $img = \html_writer::empty_tag('img', array('src'=>$OUTPUT->pix_url('t/delete'), 'alt'=>'', 'class'=>'iconsmall'));
    $dellink = \html_writer::link($url, $img, array('title'=>'delete'));
    
    $ssoapphtml .= '<tr>
        <td align="right">' . 
        htmlspecialchars($ssoApp->appname) . 
        '</td><td>' . 
        $ssoApp->token . 
        '</td><td>' . $dellink . '</td></tr>'; 
  }
  if (!empty($ssoapphtml)) {
    $ssoapphtml = "<tr><th>" . get_string('ssoappnameheader', 'auth_url') . "</th><th>" . get_string('ssoapptokenheader', 'auth_url') . "</th><th></th></tr>" . $ssoapphtml;
  }
  return $ssoapphtml;
}

/*
 * Generate a (md5 or sha256) token
 * 
 * If hash sha256 is availble the sha256 method is used, otherwise a simpler md5
 * 
 * @return String $token The token (null if none set) 
 *  
 */
function generateToken() {
  // generate a token from an unique value
  $token = md5(uniqid(microtime(), true));
  try {
    $salt = '@=3_{h2Ng*7)N|7LedEB~RDd;/kEra-`MBj@(==!.#<,mPIJ%ssAH69P%53d6Q,9';
    $random = rand();
    $token = hash('sha256', $salt . $random);
    
  } catch (Exception $e) {
    // silent
  }
  return $token;
}


/*
 * Delete a SSO App from the auth_url table
 * 
 * @param int $deleteId The id of the record to delete
 */
function deleteSsoApp($deleteId) {
  global $DB;
  $DB->delete_records('auth_url', array('id' => $deleteId));
  
}