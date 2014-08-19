<?php

// Create redirect url to correct course and optional section
// This is needed because while logging in the # anchor ref is stripped and this is needed for the section reference

// We need to be logged in and we do need to load the basics
$conffile = dirname(dirname(dirname(__FILE__))) . "/config.php";
include($conffile);

require_login();
$username = optional_param('username', '', PARAM_RAW);
$password = optional_param('password', '', PARAM_RAW);

$courseid = optional_param('courseid', '', PARAM_RAW);
$sectionid = optional_param('sectionid', '', PARAM_RAW);

$newurl = $CFG->wwwroot . '/course/view.php?id=';
$newurl .= $courseid;
if (!empty($username)) {
  $newurl .= "&username={$username}";
  if (!empty($password)) {
    $newurl .= "&password={$password}";
  }
}
if ($sectionid >= 0) {
  $newurl .= '#section-' . $sectionid;
}
redirect($newurl);
// die(); // never reached