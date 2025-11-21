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
 * Course recommendation statistics page for block_recommend_course plugin.
 *
 * This page displays statistics for the most and least recommended courses.
 * It fetches data from the database and presents it in a structured format.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
global $DB, $USER, $PAGE, $OUTPUT;

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/recommend_course/stats_table.php'));

if (!has_capability('block/recommend_course:viewstats', $context)) {
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('nopermission', 'block_recommend_course'), 'error');
    echo $OUTPUT->single_button(
        new moodle_url('/my/'),
        get_string('back_dashboard', 'block_recommend_course'),
        'get'
    );
    echo $OUTPUT->footer();
    exit;
}

$pluginname = get_string('pluginname', 'block_recommend_course');
$title = get_string('course_recommendations_stats', 'block_recommend_course');
$PAGE->set_title($pluginname . ' : ' . $title);
$PAGE->set_heading($pluginname);
$PAGE->set_pagelayout('standard');
$PAGE->requires->css('/blocks/recommend_course/css/style.css');

// Use joins so we also fetch course fullname.
$topsql = "SELECT r.course_id, COUNT(*) AS recommendation_count, c.fullname AS course_fullname
              FROM {block_recommend_course_rds} r
              JOIN {course} c ON c.id = r.course_id
          GROUP BY r.course_id, c.fullname
          ORDER BY recommendation_count DESC
             LIMIT 5";
$top = $DB->get_records_sql($topsql);

$bottomsql = "SELECT r.course_id, COUNT(*) AS recommendation_count, c.fullname AS course_fullname
                 FROM {block_recommend_course_rds} r
                 JOIN {course} c ON c.id = r.course_id
             GROUP BY r.course_id, c.fullname
             ORDER BY recommendation_count ASC
                LIMIT 5";
$bottom = $DB->get_records_sql($bottomsql);

echo $OUTPUT->header();
$navigation = new \block_recommend_course\output\manage_nav(basename($PAGE->url->get_path()));
echo $OUTPUT->render_from_template('block_recommend_course/manage_nav', $navigation->export_for_template($OUTPUT));


$renderable = new \block_recommend_course\output\stats($top, $bottom);
echo $OUTPUT->render($renderable);

echo $OUTPUT->footer();
