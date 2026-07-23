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
 * User search external service for autocomplete.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_recommend_course\external;

defined('MOODLE_INTERNAL') || die();

global $CFG;
// Ensure legacy externallib is loaded so this works on Moodle 4.1 and newer.
require_once($CFG->libdir . '/externallib.php');

// Use fully-qualified global external classes (backwards-compatible).
// Note: Do NOT 'use core_external\external_api' here if you want 4.1 compatibility.

/**
 * External service for searching cohorts.
 */
class cohort_search extends \external_api {
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
     * Search for users.
     *
     * @param string $query The search query
     * @return array
     */
    public static function execute($query = '') {
        global $DB, $USER;

        $params = self::validate_parameters(self::execute_parameters(), ['query' => $query]);

        // Set context for external service (system-level).
        $context = \context_system::instance();
        self::validate_context($context);

        $query = trim($params['query']);

        // Search cohorts.
        $sql = "SELECT id, name
                FROM {cohort}
                WHERE 1 = 1";

        $sqlparams = [];

        if ($query !== '') {
            $sql .= " AND " . $DB->sql_like('name', ':query', false);
            $sqlparams['query'] = '%' . $DB->sql_like_escape($query) . '%';
        }

        $sql .= " ORDER BY name ASC";

        $cohorts = $DB->get_records_sql($sql, $sqlparams, 0, 100);

        $results = [];

        foreach ($cohorts as $cohort) {
            $results[] = [
                'value' => (int)$cohort->id,
                'label' => $cohort->name,
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
                'value' => new \external_value(PARAM_INT, 'User ID'),
                'label' => new \external_value(PARAM_TEXT, 'User display name'),
            ])
        );
    }
}
