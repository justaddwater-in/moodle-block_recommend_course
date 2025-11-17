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
 * JS File : block_recommend_course plugin.
 *
 * @module     block_recommend_course/init_datatable
 * @copyright  2025 Justaddwater <contact@justaddwater.in>
 * @author     Himanshu Saini
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define(['jquery'], function($) {
    'use strict';

    return {
        DTinit: function(selector, options) {
            // Dynamically load the DataTables library
            require(['js/datatables.min.js'], function() {
                // Initialize the DataTable when DOM is ready
                $(document).ready(function() {
                    if ($.fn.DataTable) {
                        $(selector).DataTable(options);
                    }
                });
            });
        }
    };
});
