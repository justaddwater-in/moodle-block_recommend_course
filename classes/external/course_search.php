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
 * Course search external service for autocomplete.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_recommend_course\external;

defined('MOODLE_INTERNAL') || die();

global $CFG;
// Load legacy externallib so this works across Moodle 4.1 and newer.
require_once($CFG->libdir . '/externallib.php');

/**
 * External service for searching courses.
 */
class course_search extends \external_api {
    /**
     * Returns description of method parameters.
     *
     * @return \external_function_parameters
     */
    public static function execute_parameters() {
        return new \external_function_parameters([
            'query' => new \external_value(PARAM_TEXT, 'The search query', VALUE_DEFAULT, ''),
        ]);
    }

    /**
     * Search for courses.
     *
     * @param string $query The search query
     * @return array
     */
    public static function execute($query = '') {
        global $DB;

        $params = self::validate_parameters(self::execute_parameters(), [
            'query' => $query,
        ]);

        // Set context for format_string() and capability checks if needed.
        $context = \context_system::instance();
        self::validate_context($context);

        $query = trim($params['query']);

        // Build SQL query.
        $sql = "SELECT id, fullname
                FROM {course}
                WHERE visible = 1 AND id != 1";

        $sqlparams = [];

        if ($query !== '') {
            $sql .= " AND " . $DB->sql_like('fullname', ':query', false);
            $sqlparams['query'] = '%' . $DB->sql_like_escape($query) . '%';
        }

        $sql .= " ORDER BY fullname ASC";

        // Limit results for performance.
        $courses = $DB->get_records_sql($sql, $sqlparams, 0, 100);

        $results = [];
        foreach ($courses as $course) {
            $results[] = [
                'value' => (int)$course->id,
                'label' => format_string($course->fullname, true, $context),
            ];
        }

        return $results;
    }

    /**
     * Returns description of method result value.
     *
     * @return \external_multiple_structure
     */
    public static function execute_returns() {
        return new \external_multiple_structure(
            new \external_single_structure([
                'value' => new \external_value(PARAM_INT, 'Course ID'),
                'label' => new \external_value(PARAM_TEXT, 'Course name'),
            ])
        );
    }
}
