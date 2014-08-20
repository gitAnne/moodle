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
 * Url enrolment sync tests
 *
 * @package    enrol_url
 * @category   phpunit
 * @copyright  2014 UP Learning, 2011 Petr Skoda {@link http://skodak.org}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class enrol_database_testcase extends advanced_testcase {
    protected static $courses = array();
    protected static $users = array();
    protected static $roles = array();

    /** @var string Original error log */
    protected $oldlog;

    protected function init_enrol_database() {
        global $DB, $CFG;

        $dbman = $DB->get_manager();
    }

    protected function cleanup_enrol_database() {
        global $DB;

        $dbman = $DB->get_manager();
    }

    protected function reset_enrol_database() {
        global $DB;

    }

    protected function assertIsEnrolled($userindex, $courseindex, $status=null, $rolename = null) {
        global $DB;
    }

    protected function assertHasRoleAssignment($userindex, $courseindex, $rolename = null) {
        global $DB;
    }

    protected function assertIsNotEnrolled($userindex, $courseindex) {
        global $DB;
    }

    public function test_sync_user_enrolments() {
        global $DB;
    }

    /**
     * @depends test_sync_user_enrolments
     */
    public function test_sync_users() {
        global $DB;

        $this->resetAfterTest(false);
        $this->preventResetByRollback();
        $this->reset_enrol_database();

        $plugin = enrol_get_plugin('database');

        $trace = new null_progress_trace();

        // Test basic enrol sync for one user after login.

        // Test sync of one course only.

        $this->reset_enrol_database();

    }

    /**
     * @depends test_sync_users
     */
    public function test_sync_courses() {
        global $DB;

        $this->resetAfterTest(true);
        $this->preventResetByRollback();
        $this->reset_enrol_database();

        $plugin = enrol_get_plugin('url');

        $trace = new null_progress_trace();

        // Final cleanup - remove extra tables, fixtures and caches.
        $this->cleanup_enrol_database();
    }
}
