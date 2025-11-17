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
 * User selector module for autocomplete.
 *
 * @module     block_recommend_course/form-user-selector
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['core/ajax'], function(Ajax) {
    'use strict';

    return {
        transport: function(selector, query, success, failure) {
            var promise;

            promise = Ajax.call([{
                methodname: 'block_recommend_course_user_search',
                args: {
                    query: query
                }
            }]);

            promise[0].then(function(results) {
                success(results);
                return;
            }).catch(failure);
        },

        processResults: function(selector, results) {
            return results;
        }
    };
});
