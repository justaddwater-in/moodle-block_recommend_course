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

use renderable;
use renderer_base;
use templatable;
/**
 * Renderable/templatable class to present history table rows.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class history_table implements renderable, templatable {
    /**
     * Array of database records to display in the history table.
     *
     * Each record is expected to contain:
     *  - sender_firstname
     *  - sender_lastname
     *  - receiver_firstname
     *  - receiver_lastname
     *  - course_fullname
     *  - course_id
     *  - created_on
     *
     * @var array
     */
    protected $records;

    /**
     * Constructor.
     *
     * @param array $records Array of stdClass DB records for the history table.
     */
    public function __construct($records) {
        $this->records = $records;
    }

    /**
     * Export data for the mustache template.
     *
     * @param renderer_base $output The renderer (not used here but included for API compatibility).
     * @return array The data structure consumable by a mustache template.
     */
    public function export_for_template(renderer_base $output) {
        $rows = [];

        foreach ($this->records as $rec) {
            $rows[] = [
                'sender'     => $rec->sender_firstname . ' ' . $rec->sender_lastname,
                'receiver'   => $rec->receiver_firstname . ' ' . $rec->receiver_lastname,
                'coursename' => $rec->course_fullname,
                'courseurl'  => (new \moodle_url('/course/view.php', ['id' => $rec->course_id]))->out(false),
                'date'       => userdate(strtotime($rec->created_on), '%a, %d %b %Y, %H:%M'),
            ];
        }

        return [
            'rows' => $rows,
        ];
    }
}
