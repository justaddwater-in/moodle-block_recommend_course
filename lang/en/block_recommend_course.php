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
 * Language file for block_recommend_course plugin.
 *
 * This page displays statistics for the most and least recommended courses.
 * It fetches data from the database and presents it in a structured format.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['blocktitle'] = 'Recent Recommendations';
$string['button'] = 'Recommend a course';
$string['pluginname'] = 'Recommend a course';
$string['pluginname:addinstance'] = 'Add a new recommend a course block';
$string['pluginname:myaddinstance'] = 'Add a new recommend a course block';

$string['title'] = 'Recommend a course';

$string['historytitle'] = 'Recommendation history';

$string['show_all'] = 'Show All Recommendations';
$string['description'] = 'A block to recommend courses to users';
$string['select_course'] = 'Select course';
$string['select_users'] = 'Select users';
$string['noselection_string'] = 'Search users from below';
$string['submit'] = 'Submit';

$string['add_success'] = 'Recommendation has been successfully submitted.';
$string['add_error'] = 'Invalid data. Please select at least one user and course.';

$string['email_subject'] = 'You have a new course recommendation.';
$string['email_open'] = 'You have received a course recommendation on ';
$string['details_below'] = 'Please find details below';
$string['course'] = 'Course';
$string['recommeded_by'] = 'Recommended by';
$string['by'] = 'By:';
$string['view_course'] = 'View Course';
$string['recommendation_history'] = 'View history';
$string['all_recommendation'] = 'All Recommendations';
$string['back_dashboard'] = 'Back to dashboard';

// Privacy text.
$string['privacy:metadata'] = 'The recommend a course block does not store any personal information and works based on user ID.';

$string['nopermission'] = 'You do not have permission to view this page.';
$string['recommendedto'] = 'Recommended to';
$string['recommendeddate'] = 'Recommended on';
$string['nocoursesfound'] = 'No recommended courses found.';

$string['mostrecommended'] = 'Most Popular';
$string['leastrecommended'] = 'Least Popular';
$string['notopcourses'] = 'No recommended courses found.';
$string['nobottomcourses'] = 'No recommendations received yet.';
$string['serialno'] = 'Rank';
$string['totalrecommendations'] = 'Times recommended';
$string['unknowncourse'] = 'Unknown course';
$string['course_recommendations_stats'] = 'Stats';

$string['recommend_course:addinstance'] = 'Add a new recommend a course block';
$string['recommendation_subject'] = 'A course has been recommended to you';
$string['recommendation_message'] = '{$a->user} has recommended the course "{$a->course}" to you.';
$string['recommendation_small']   = 'You have a new course recommendation';

$string['recommend_course:addinstance'] = 'Add a new Recommend a Course block';
$string['recommend_course:myaddinstance'] = 'Add a new Recommend a Course block to the Dashboard';
$string['recommend_course:viewstats'] = 'View course recommendation statistics';

$string['privacy:metadata:recommend_course_recommends'] = 'Stores course recommendations made by users.';
$string['privacy:metadata:recommend_course_recommends:sender_id'] = 'User id of the person who recommended the course.';
$string['privacy:metadata:recommend_course_recommends:receiver_id'] = 'User id of the user who received the recommendation.';
$string['privacy:metadata:recommend_course_recommends:course_id'] = 'Course id that was recommended.';
$string['privacy:metadata:recommend_course_recommends:created_on'] = 'When the recommendation was created.';
