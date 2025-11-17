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
 * Renderable class for displaying recommended stats.
 *
 * This file defines the {@see \block_recommend_course\output\stats}
 * class, which prepares data for rendering the list of recommended stats for admin
 * in the block_recommend_course plugin.
 *
 * @package    block_recommend_course
 * @category   output
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
namespace block_recommend_course\output;

use renderable;
use renderer_base;
use templatable;
use moodle_url;

/**
 * Prepares statistics data for display.
 *
 * This class accepts two result sets (top and bottom recommended courses)
 * and formats them for consumption by a mustache template.
 *
 * @package    block_recommend_course
 */
class stats implements renderable, templatable {
    /**
     * Top recommended courses result set (array/stdClass list).
     *
     * @var array
     */
    protected $topcourses;

    /**
     * Bottom recommended courses result set (array/stdClass list).
     *
     * @var array
     */
    protected $bottomcourses;

    /**
     * Constructor.
     *
     * @param array $top    Top recommended courses (rows with course_id, course_fullname, recommendation_count).
     * @param array $bottom Bottom recommended courses (rows with course_id, course_fullname, recommendation_count).
     */
    public function __construct($top, $bottom) {
        $this->topcourses = $top;
        $this->bottomcourses = $bottom;
    }

    /**
     * Export data for the mustache template.
     *
     * @param renderer_base $output Renderer instance (unused but kept for API compatibility).
     * @return array Data structure ready for templating.
     */
    public function export_for_template(renderer_base $output) {
        $format = function ($courses) {
            $rows = [];
            foreach ($courses as $c) {
                $courseurl = new \moodle_url('/course/view.php', ['id' => $c->course_id]);
                $rows[] = [
                    'coursename' => $c->course_fullname ?? get_string('unknowncourse', 'block_recommend_course'),
                    'courseurl'  => $courseurl->out(false),
                    'count'      => $c->recommendation_count,
                ];
            }
            return $rows;
        };

        $toprows = $format($this->topcourses);
        $bottomrows = $format($this->bottomcourses);

        return [
            'hastop'     => !empty($toprows),
            'toprows'    => $toprows,
            'hasbottom'  => !empty($bottomrows),
            'bottomrows' => $bottomrows,
        ];
    }
}
