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
 * Recommend a course page for the block_recommend_course plugin.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once("../../config.php");
require_once('recommendcourse_form.php');
global $DB, $USER;
require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/recommend_course/recommend_course.php');
$title = get_string('title', 'block_recommend_course');
$mform = new recommendcourse_form();

  // Form processing and displaying is done here.
if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot);
} else if ($fromform = $mform->get_data()) {
    // Adding data to db.
    if ((!empty($fromform->users) || !empty($fromform->cohorts)) && !empty($fromform->courses)) {
            // Get settings once.
        $sendnotification = get_config('block_recommend_course', 'send_notification');
        $sendemail = get_config('block_recommend_course', 'send_email');
        $emailbody = get_config('block_recommend_course', 'email_body');
        $emailsubject = get_config('block_recommend_course', 'email_subject');
        // Build the final list of users.
        $users = [];

        // Individually selected users.
        if (!empty($fromform->users)) {
            foreach ($fromform->users as $userid) {
                $users[$userid] = $userid;
            }
        }

        // Users from selected cohorts.
        if (!empty($fromform->cohorts)) {
            foreach ($fromform->cohorts as $cohortid) {

                $members = $DB->get_records(
                    'cohort_members',
                    ['cohortid' => $cohortid],
                    '',
                    'userid'
                );

                foreach ($members as $member) {
                    $users[$member->userid] = $member->userid;
                }
            }
        }

        $users = array_values($users);
        // Get course name.
        //$course = $DB->get_record('course', ['id' => $fromform->course], '*', MUST_EXIST);
        foreach ($fromform->courses as $courseid) {

            // Get course information.
            $course = $DB->get_record(
                'course',
                ['id' => $courseid],
                '*',
                MUST_EXIST
        );

            foreach ($users as $receiver) {

                $temp = new stdClass();
                $temp->sender_id = $USER->id;
                $temp->receiver_id = $receiver;
                $temp->course_id = $courseid;
                $temp->created_on = date('Y-m-d H:i:s');

                $DB->insert_record(
                    'block_recommend_course_rds',
                    $temp
                );


                // Get receiver user object.
                $recommendee = $DB->get_record(
                    'user',
                    ['id' => $receiver],
                    '*',
                    MUST_EXIST
                );


                // Prepare message with placeholders.
                $message = str_replace(
                    ['[course_name]', '[recommended_by]'],
                    [$course->fullname, fullname($USER)],
                    $emailbody
                );

                $subject = str_replace(
                    ['[course_name]', '[recommended_by]'],
                    [$course->fullname, fullname($USER)],
                    $emailsubject
                );


                $eventdata = new \core\message\message();

                $eventdata->component = 'block_recommend_course';
                $eventdata->userfrom = $USER;
                $eventdata->userto = $recommendee;
                $eventdata->subject = $subject;
                $eventdata->fullmessage = strip_tags($message);
                $eventdata->fullmessageformat = FORMAT_PLAIN;
                $eventdata->fullmessagehtml = $message;
                $eventdata->notification = 1;


                if ($sendemail && $sendnotification) {
                    $eventdata->name = 'recommendation_both';
                } else if ($sendnotification) {
                    $eventdata->name = 'recommendation_popup';
                } else if ($sendemail) {
                    $eventdata->name = 'recommendation_email';
                }

                message_send($eventdata);
            }
        }
        $redirecturl = "$CFG->wwwroot/blocks/recommend_course/recommend_course.php";
        redirect(
            $redirecturl,
            get_string('add_success', 'block_recommend_course'),
            null,
            \core\output\notification::NOTIFY_SUCCESS
        );
    } else {
        redirect(
            "$CFG->wwwroot/blocks/recommend_course/recommend_course.php",
            get_string('add_error', 'block_recommend_course'),
            null,
            \core\output\notification::NOTIFY_ERROR
        );
    }
} else {
    $PAGE->set_pagelayout('incourse');
    $PAGE->set_title($title);
    $PAGE->set_heading($title);
    $PAGE->set_cacheable(false);


    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}
