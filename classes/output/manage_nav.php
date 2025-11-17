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
 * Renderable class for displaying navigation bar.
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

/**
 * Manage navigation renderable for block_recommend_course.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class manage_nav implements renderable, templatable {
    /** @var string Current script basename (e.g. 'history.php') */
    protected $currentpage;

    /**
     * Constructor.
     *
     * @param string $currentpage basename of the current script (optional).
     */
    public function __construct(string $currentpage = '') {
        $this->currentpage = $currentpage;
    }

    /**
     * Export data for Mustache template.
     *
     * @param renderer_base $output
     * @return array
     */
    public function export_for_template(renderer_base $output) {
        // Build URLs.
        $historyurl = (new \moodle_url('/blocks/recommend_course/history.php'))->out(false);
        $statsurl   = (new \moodle_url('/blocks/recommend_course/stats_table.php'))->out(false);

        // Determine active state.
        $current = $this->currentpage ?: basename($_SERVER['PHP_SELF'] ?? '');
        $historyactive = ($current === 'history.php');
        $statsactive   = ($current === 'stats_table.php');

        return [
            'tabs' => [
                [
                    'id' => 'history',
                    'url' => $historyurl,
                    'label' => get_string('historytitle', 'block_recommend_course'),
                    'active' => $historyactive,
                ],
                [
                    'id' => 'stats',
                    'url' => $statsurl,
                    'label' => get_string('course_recommendations_stats', 'block_recommend_course'),
                    'active' => $statsactive,
                ],
            ],
        ];
    }
}
