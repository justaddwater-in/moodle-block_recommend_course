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
 * Class containing data for the available courses block.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_recommend_course\output;
defined('MOODLE_INTERNAL') || die();

use renderable;
use renderer_base;
use templatable;
use core_completion\progress;
use core_course_renderer;
use moodle_url;
use context_system;


require_once($CFG->libdir . '/completionlib.php');
/**
 * Main renderable for the recommend course block.
 *
 * Provides data required by the mustache template to render the block
 * either in the sidebar (compact) or the center/content area (expanded).
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class main implements renderable, templatable {
    /**
     * Whether the block is in a sidebar region.
     *
     * @var bool
     */
    private $issidebar;

    /**
     * Constructor.
     *
     * @param bool $issidebar True when block is in a sidebar region.
     */
    public function __construct(bool $issidebar) {
        $this->issidebar = $issidebar;
    }

    /**
     * Export data for the mustache template.
     *
     * @param renderer_base $output The renderer (unused here but kept for signature compatibility).
     * @return array Data to be consumed by the mustache template.
     */
    public function export_for_template(renderer_base $output) {
        global $USER, $DB;

        $context = \context_system::instance();
        $canviewhistory = has_capability('block/recommend_course:viewstats', $context);

        $issidebar = $this->issidebar;
        $limit = $issidebar ? 1 : 4;

        // Fetch recommendations for this user.
        $sql = "SELECT rec.id AS rec_id, rec.sender_id,
                       sender.firstname, sender.lastname,
                       rec.receiver_id, rec.created_on,
                       c.id AS courseid, c.fullname, c.shortname,
                       c.category, c.enddate, c.visible
                  FROM {block_recommend_course_rds} rec
                  JOIN {course} c ON rec.course_id = c.id
                  JOIN {user} sender ON sender.id = rec.sender_id
                 WHERE rec.receiver_id = :userid
              ORDER BY rec.created_on DESC";
        $records = $DB->get_records_sql($sql, ['userid' => $USER->id], 0, $limit);

        $recommendedview = new recommended_view($records);
        $recommendedcourses = $recommendedview->export_for_template($output);

        return [
            'userid' => $USER->id,
            'pagingbar' => [
                'next' => true,
                'previous' => true,
            ],
            'recommended' => $recommendedcourses,
            'viewlist' => false,
            'viewcard' => true,
            'allurl' => (new \moodle_url('/blocks/recommend_course/all.php'))->out(false),
            'recommendurl' => (new \moodle_url('/blocks/recommend_course/recommend_course.php'))->out(false),
            'historyurl' => (new \moodle_url('/blocks/recommend_course/history.php'))->out(false),
            'canviewhistory' => $canviewhistory,
        ];
    }
}
