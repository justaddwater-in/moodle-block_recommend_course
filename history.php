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

 require_once('../../config.php');
 global $DB, $USER, $PAGE;

 require_login();
 $context = context_system::instance();
 $PAGE->set_context($context);
 $PAGE->set_url(new moodle_url('/blocks/recommend_course/history.php'));

if (!has_capability('block/recommend_course:viewstats', $context)) {
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('nopermission', 'block_recommend_course'), 'error');
    echo '<a href="' . new moodle_url('/my/') . '" class="btn btn-primary">' .
    get_string('back_dashboard', 'block_recommend_course') . '</a>';
    echo $OUTPUT->footer();
    exit;
}
 // Set up page parameters.
 $pluginname = get_string('pluginname', 'block_recommend_course');
 $title = get_string('historytitle', 'block_recommend_course');
 $PAGE->set_url(new moodle_url('/blocks/recommend_course/recommendations.php'));
 $PAGE->set_title($pluginname . ' : ' . $title);
 $PAGE->set_heading($pluginname);
 $PAGE->set_pagelayout('standard');

 // Include DataTables.
 $PAGE->requires->jquery();
 $PAGE->requires->css('/blocks/recommend_course/css/style.css');
 $PAGE->requires->css('/blocks/recommend_course/css/datatables.min.css');
 $PAGE->requires->js_call_amd('block_recommend_course/init_datatable', 'DTinit', ['#recommended-table', [
    'paging' => true,
    'searching' => true,
    'info' => true,
    'pageLength' => 25,
 ]]);
 $sql = "SELECT r.*,
               s.firstname AS sender_firstname, s.lastname AS sender_lastname,
               u.firstname AS receiver_firstname, u.lastname AS receiver_lastname,
               c.fullname AS course_fullname
          FROM {block_recommend_course_rds} r
          JOIN {user} s ON s.id = r.sender_id
          JOIN {user} u ON u.id = r.receiver_id
          JOIN {course} c ON c.id = r.course_id";

 $records = $DB->get_records_sql($sql);

 echo $OUTPUT->header();
 $navigation = new \block_recommend_course\output\manage_nav(basename($PAGE->url->get_path()));
 echo $OUTPUT->render_from_template('block_recommend_course/manage_nav', $navigation->export_for_template($OUTPUT));


 if ($records) {
     $table = new \block_recommend_course\output\history_table($records);
     echo $OUTPUT->render($table);
 } else {
     echo $OUTPUT->notification(get_string('nocoursesfound', 'block_recommend_course'), 'info');
 }
 echo $OUTPUT->footer();
