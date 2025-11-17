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
 * External services definition for block_recommend_course.
 *
 * @package    block_recommend_course
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'block_recommend_course_course_search' => [
        'classname' => 'block_recommend_course\external\course_search',
        'methodname' => 'execute',
        'description' => 'Search for courses',
        'type' => 'read',
        'ajax' => true,
        'loginrequired' => true,
    ],
    'block_recommend_course_user_search' => [
        'classname' => 'block_recommend_course\external\user_search',
        'methodname' => 'execute',
        'description' => 'Search for users',
        'type' => 'read',
        'ajax' => true,
        'loginrequired' => true,
    ],
];
