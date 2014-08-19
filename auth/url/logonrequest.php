<?php

// We do not need to be logged in but we do need to load the basics
$conffile = dirname(dirname(dirname(__FILE__))) . "/config.php";
include($conffile);

include($CFG->dirroot . '/auth/url/classes/event/user_login_failed.php');

// Get the parameters
// Although they are not all optional, we do not want Moodle to through exceptions
$token = optional_param('token', '', PARAM_RAW);
$username = optional_param('username', '', PARAM_RAW);
$password = optional_param('password', '', PARAM_RAW);
$courseid = optional_param('courseid', '', PARAM_RAW);
$sectionid = optional_param('sectionid', '', PARAM_RAW);

// Check if token parameter is present and valid
// If not log and die
$validtoken = false;
if (!empty($token)) {
  $app = $DB->get_record('auth_url', array('token' => $token));
  if ($app !== false) {
    $validtoken = true;
  }  
}
if (!$validtoken) {
  auth_url_log("Invalid token used: '{$token}' (Request IP: " . getremoteaddr() . ")");
  die();  
}

// Check if username present and exists
// If not log and die
$validuser = false;
if (!empty($username)) {
  $user = $DB->get_record('user', array('username' => $username));
  $validuser = ($user !== false);
}
if (!$validuser) {
  auth_url_log("Invalid user: '{$username}' (Request IP: " . getremoteaddr() . ")");
  die();
}

// Check if the user has the auth_url als authentication method
// If not log and die
$validauth = false;
if ($user !== false) {
  $validauth = ($user->auth == 'url');
}
if (!$validauth) {
  auth_url_log("User: '{$username}' has wrong auth method set (Request IP: " . getremoteaddr() . ")");
  die();
}

// Check if a password is present
// If not log and die
$passwordpresent = (isset($password) && (!empty($password)));
if (!$passwordpresent) {
  auth_url_log("User: '{$username}' provided no password (Request IP: " . getremoteaddr() . ")");
  die();
}

// Check if password is correct for the user
// If not, 
// log, 
// call url
// show response stating that the combination of username/password does not exist
$correctpassword = ($user->password == $password);
if (!$correctpassword) {
  $config = get_config('auth_url');
  
  $errormess = "Username and password combination was not found!";
  $incorrectcredentialsurl = $config->incorrectcredentialsurl;
  $incorrectcredentialsurl = str_replace('{username}', $username, $incorrectcredentialsurl);
  $incorrectcredentialsurl = str_replace('{password}', $password, $incorrectcredentialsurl);
  $incorrectcredentialsurl = str_replace('{errorMessage}', $errormess, $incorrectcredentialsurl);
  auth_url_log("User: '{$username}' provided wrong password: '{$password}' (Request IP: " . getremoteaddr() . ")");
  postURL($incorrectcredentialsurl, array('username' => $username, 'password' => $password));
  die($errormess);
}

// Check if courseid present and valid
// If not log and show this as response
$courseidexists = false;
if (!empty($courseid)) {
  $course = $DB->get_record('course', array('id' => $courseid));
  $courseidexists = ($course !== false);
}
if (!$courseidexists) {
  auth_url_log("Course id: '{$courseid}' does not exist (Request IP: " . getremoteaddr() . ")");
  die("Course id: '{$courseid}' does not exist!");
}

$user = $DB->get_record('user', array('username' => $username));
if ($user !== false) {
  $USER = $user;
}

// Create url to redirect page with course and section
// Post to that url using username and password
// authurlredirect.php
// $redirurl = $CFG->wwwroot . "/auth/url/authurlredirect.php?courseid={$courseid}";
$redirurl =  $CFG->wwwroot . "/login/index.php?username={$username}&password={$password}&courseid={$courseid}";
$redirurl =  $CFG->wwwroot . "/auth/url/authurlredirect.php?username={$username}&password={$password}&courseid={$courseid}";
if (!empty($sectionid)) {
  $redirurl .= "&sectionid={$sectionid}";
}

$loginurl =  $CFG->wwwroot . "/login/index.php?username={$username}&password={$password}&courseid={$courseid}";
if (!empty($sectionid)) {
  $loginurl .= "&sectionid={$sectionid}";
}

// redirect($redirurl, 'Redirect to course');
// // redirect($loginurl, 'Redirect to course');

// postURL($CFG->wwwroot . "/login/index.php", array('username' => $username, 'password' => $password, 'courseid' => $courseid));
redirect($redirurl, 'Redirect to course');
// never reached
// die('App fail...');


/*
 * DEBUG_NONE DEBUG_MINIMAL DEBUG_NORMAL DEBUG_ALL DEBUG_DEVELOPER
*/
function auth_url_log($logtext, $loglevel = DEBUG_NONE) {
  global $CFG;
  $curLogLevel = $CFG->debug;
  // Always log level <DEBUG_NONE
  if ($loglevel <= DEBUG_NONE) {
    $event = \auth_url\event\user_login_failed::create(array('other' => array('reason' => $logtext)));
    $event->trigger();

  } elseif ($loglevel <= $curLogLevel) {
    // Log all levels <= to set level
    $event = \auth_url\event\user_login_failed::create(array('other' => array('reason' => $logtext)));
    $event->trigger();
  }
}


/*
 * Call URL $data
*
* @param String $uri The url to post to
* @param multi $data The data to post
* 
* @return array $result In case of te retrieve, the data requested
*
*/
function postURL($uri, $data) {
  $postdata = '';
  $ch = null;
  $result = null;

  try {
    $ch = curl_init($uri);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);

    // optional?
    // curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data"));
    $postdata = $data;

    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  $postdata);

    $timeout = 60;
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

    $startTime = microtime(true);
    $startDateTime = time();

    $result = curl_exec($ch);

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($result, 0, $header_size);
    $body = substr($result, $header_size);

    if (!empty($body)) {
      $result = $body;
    }

    $errorno = curl_errno($ch);
    $error = curl_error($ch);
    $cinfo = curl_getinfo($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($errorno != 0) {
      $result = null;
      $error = curl_error($ch);

    } else {
      $endTime = microtime(true);
      $endDateTime = time();
      $totalTime = $endTime - $startTime;

      $message = sprintf('start:%s end:%s time:%08.2fs uri: %s data: %s responsecode: %s', date('c', $startDateTime), date('c', $endDateTime), $totalTime, $uri, $postdata, $http_code);
      auth_url_log($message, DEBUG_NORMAL);
      
    }
  } catch (Exception $e) {
    // silent

  }
  if (isset($ch)) {
    curl_close($ch);
  }
  return $result;
}

