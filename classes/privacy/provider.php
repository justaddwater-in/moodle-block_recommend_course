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
 * Recommend a course Moodle block plugin
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_recommend_course\privacy;

use core_privacy\local\metadata\collection;
use core_privacy\local\request\contextlist;
use core_privacy\local\request\approved_contextlist;
use core_privacy\local\request\approved_userlist;
use core_privacy\local\request\userlist;
use core_privacy\local\request\writer;

/**
 * Privacy API implementation for block_recommend_course.
 *
 * Stores recommendations in table: {block_recommend_course_rds}
 * Fields relevant to users: sender_id, receiver_id.
 */
class provider implements \core_privacy\local\metadata\provider, \core_privacy\local\request\core_userlist_provider, \core_privacy\local\request\core_user_data_provider {
    /**
     * Declare metadata about stored personal data.
     *
     * @param collection $collection
     * @return collection
     */
    public static function get_metadata(collection $collection): collection {
        // Describe the DB table and fields we store.
        $collection->add_database_table(
            'block_recommend_course_rds',
            [
                'sender_id'    => 'privacy:metadata:block_recommend_course_rds:sender_id',
                'receiver_id'  => 'privacy:metadata:block_recommend_course_rds:receiver_id',
                'course_id'    => 'privacy:metadata:block_recommend_course_rds:course_id',
                'created_on'   => 'privacy:metadata:block_recommend_course_rds:created_on',
            ],
            'privacy:metadata:block_recommend_course_rds'
        );

        return $collection;
    }

    /**
     * Get contexts that contain user information for the specified user.
     *
     * This plugin stores data at system-level (site-wide recommendations),
     * so we return the system context when there are rows for the user.
     *
     * @param int $userid
     * @return contextlist
     */
    public static function get_contexts_for_userid($userid): contextlist {
        global $DB;

        $contextlist = new contextlist();

        // If user is sender or receiver, then add system context.
        $sql = "SELECT 1
                  FROM {block_recommend_course_rds}
                 WHERE sender_id = :uid OR receiver_id = :uid
                LIMIT 1";
        $params = ['uid' => $userid];

        if ($DB->record_exists_sql($sql, $params)) {
            $contextlist->add_context(\context_system::instance());
        }

        return $contextlist;
    }

    /**
     * Get a list of users who have data in the context.
     *
     * Required for admin tools that show which users have data within a context.
     *
     * @param userlist $userlist
     * @return void
     */
    public static function get_users_in_context(userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();
        // We only store in system context.
        if ($context->contextlevel !== CONTEXT_SYSTEM) {
            return;
        }

        // Find distinct users who are sender or receiver.
        $sql = "SELECT DISTINCT u.id
                  FROM {user} u
                  JOIN {block_recommend_course_rds} r
                    ON (r.sender_id = u.id OR r.receiver_id = u.id)";
        $records = $DB->get_records_sql($sql);

        foreach ($records as $rec) {
            $userlist->add_user($rec->id);
        }
    }

    /**
     * Export all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist
     * @return void
     */
    public static function export_user_data(approved_contextlist $contextlist) {
        global $DB;

        // We only operate for system context here.
        $contexts = $contextlist->get_contexts();
        foreach ($contexts as $context) {
            if ($context->contextlevel !== CONTEXT_SYSTEM) {
                continue;
            }

            // Get the userid we are exporting for.
            $userid = $contextlist->get_user();

            // Export recommendations where the user is sender.
            $sent = $DB->get_records('block_recommend_course_rds', ['sender_id' => $userid]);
            $sentdata = [];
            foreach ($sent as $r) {
                $sentdata[] = [
                    'id' => $r->id,
                    'to' => $r->receiver_id,
                    'courseid' => $r->course_id,
                    'created_on' => $r->created_on,
                    'role' => 'sender',
                ];
            }

            if (!empty($sentdata)) {
                writer::export_data(
                    $context,
                    'block_recommend_course',
                    'recommendations_sent',
                    $sentdata
                );
            }

            // Export recommendations where the user is receiver.
            $received = $DB->get_records('block_recommend_course_rds', ['receiver_id' => $userid]);
            $receiveddata = [];
            foreach ($received as $r) {
                $receiveddata[] = [
                    'id' => $r->id,
                    'from' => $r->sender_id,
                    'courseid' => $r->course_id,
                    'created_on' => $r->created_on,
                    'role' => 'receiver',
                ];
            }

            if (!empty($receiveddata)) {
                writer::export_data(
                    $context,
                    'block_recommend_course',
                    'recommendations_received',
                    $receiveddata
                );
            }

            // If you have any files related to recommendations, export them using writer::export_area_files().
        }
    }

    /**
     * Delete all user data for the specified user, in the specified contexts.
     *
     * @param approved_contextlist $contextlist
     * @return void
     */
    public static function delete_data_for_user(approved_contextlist $contextlist) {
        global $DB;

        $contexts = $contextlist->get_contexts();
        foreach ($contexts as $context) {
            if ($context->contextlevel !== CONTEXT_SYSTEM) {
                continue;
            }

            $userid = $contextlist->get_user();

            // Delete rows where the user is sender or receiver.
            $DB->delete_records('block_recommend_course_rds', ['sender_id' => $userid]);
            $DB->delete_records('block_recommend_course_rds', ['receiver_id' => $userid]);

            // If you stored files per-user, you must delete them as well with file_storage.
        }
    }

    /**
     * Delete all user data for all users in the specified context.
     *
     * Used for wiping data in a context (for site removal, etc.)
     *
     * @param \context $context
     * @return void
     */
    public static function delete_data_for_all_users_in_context(\context $context) {
        global $DB;

        if ($context->contextlevel !== CONTEXT_SYSTEM) {
            return;
        }

        $DB->delete_records('block_recommend_course_rds', []);
    }

    /**
     * Delete multiple users in a single context (batch).
     *
     * @param approved_userlist $userlist
     * @return void
     */
    public static function delete_data_for_users(approved_userlist $userlist) {
        global $DB;

        $context = $userlist->get_context();
        if ($context->contextlevel !== CONTEXT_SYSTEM) {
            return;
        }

        $userids = $userlist->get_userids();
        if (empty($userids)) {
            return;
        }

        [$insql, $inparams] = $DB->get_in_or_equal($userids, SQL_PARAMS_NAMED);
        $DB->delete_records_select('block_recommend_course_rds', "sender_id $insql", $inparams);
        $DB->delete_records_select('block_recommend_course_rds', "receiver_id $insql", $inparams);
    }
}
