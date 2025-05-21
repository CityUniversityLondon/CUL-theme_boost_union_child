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
 * Overridden theme boost core renderer.
 *
 * @package    theme_boost_union_child
 * @copyright 2022 City University - https://www.city.ac.uk/
 * @author Delvon Forrester delvon.forrester@esparanza.co.uk}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace theme_boost_union_child\output;

class core_renderer extends \theme_boost_union\output\core_renderer {

    public function render_from_template($templatename, $context): string {
        if ($templatename === 'core/full_header') {
            $context->gradebook_disclaimer = $this->gradebook_disclaimer();
        }

        return parent::render_from_template($templatename, $context);
    }

    /**
     * Checks if page requires gradebook discalimer.
     *
     * @return bool true if page requires discalimer.
     */
    public function gradebook_disclaimer() {
        $gradebookids = array(
            'page-grade-report-user-index',
            'page-grade-report-culuser-index',
            'page-grade-report-overview-index',
            //'page-course-user'
        );

        if (in_array($this->page->bodyid, $gradebookids)) {
            return true;
        }

        return false;
    }


    /**
     * Get the institution logo url for certain students.
     *
     * @return string
     */
    public function get_compact_logo_url($maxwidth = 300, $maxheight = 300) {
        global $DB, $USER;
        $inst = strtolower($DB->get_field('user', 'institution', ['id' => $USER->id]));
        $theme = \theme_config::load('boost_union_child');
        if ($inst && isset($theme->settings->$inst) && $theme->settings->$inst) {
            return $theme->setting_file_url($inst, $inst);
        }
        return parent::get_compact_logo_url($maxwidth, $maxheight);
    }
}
