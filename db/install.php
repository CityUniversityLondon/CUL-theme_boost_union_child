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
 * Sets up boost union settings in the parent theme
 *
 * @package    theme_boost_union_child
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


/**
 * Post install config setup
 *
 * @return bool
 */
function xmldb_theme_boost_union_child_install() {
    global $CFG, $DB;
    
    // Don't send course welcome messages, see ISSUE 12277 for more info..
    set_config('sendcoursewelcomemessage', 0, 'enrol_manual');

    // Set default course format for new courses to 'topics' aka Custom Sections.
    set_config('format', 'topics', 'moodlecourse');

    // Convert exsting culcourse format courses to use topics format.
    $count = $DB->count_records('course', array('format' => 'culcourse'));
    if ($count) {
        $DB->set_field('course', 'format', 'topics', array('format' => 'culcourse'));
    }

    // Update theme settings in parent and child theme.
    $parenttheme = 'theme_boost_union';    
    $no = 'no';
    $yes = 'yes';

    set_config('brandcolor', '#D61726', $parenttheme);
    set_config('loginbackgroundimageposition', 'center center', $parenttheme);
    set_config('loginlocalloginenable', $no, $parenttheme);
    set_config('loginidpshowintro', $no, $parenttheme);
    set_config('courselistingpresentation', 'list', $parenttheme);
    set_config('categorylistingpresentation', 'boxlist', $parenttheme);
    set_config('shownavbarstarredcourses', $yes, $parenttheme);
    set_config('scrollspy', $yes, $parenttheme);
    set_config('unaddableblocks', 'navigation,settings,section_links', $parenttheme);
    set_config('courseheaderimageenabled', $yes, $parenttheme);
    set_config('hidenodesprimarynavigation', 'home', $parenttheme);
    set_config('showhintcoursehidden', $yes, $parenttheme);
    set_config('showhintforumnotifications', $yes, $parenttheme);
    set_config('footersuppressstandardfooter_tool_mobile', $yes, $parenttheme);
    set_config('footnote', '<p class="d-flex flex-row justify-content-center mt-2"><a class="px-2"
href="https://blogs.city.ac.uk/accessibility/moodle-vle/" target="_blank"
rel="noopener">Accessibility</a> <a class="px-2"
href="https://moodle4.city.ac.uk/admin/tool/policy/view.php?policyid=2">Privacy</a>
<a class="px-2"
href="https://moodle4.city.ac.uk/admin/tool/policy/view.php?policyid=1">Cookies</a>
</p>', $parenttheme);


    $filerecord = new stdClass;
    $filerecord->contextid = context_system::instance()->id;
    $filerecord->userid    = get_admin()->id;
    $filerecord->filepath  = '/';
    $filerecord->itemid    = 0;
    $filerecord->component = $parenttheme;

    $fs = get_file_storage();

    if (!get_config($parenttheme, 'logo')) {
        $logo = clone $filerecord;
        $logo->filearea  = 'logo';
        $logo->filename = 'logo.svg';
        $fs->create_file_from_pathname($logo,
            $CFG->dirroot . '/theme/boost_union_child/pix/' . $logo->filename);
        set_config('logo', '/' . $logo->filename, $parenttheme);
    }

    if (!get_config($parenttheme, 'logocompact')) {
        $logocompact = clone $filerecord;
        $logocompact->filearea  = 'logocompact';
        $logocompact->filename = 'logocompact.svg';
        $fs->create_file_from_pathname($logocompact,
            $CFG->dirroot . '/theme/boost_union_child/pix/' . $logocompact->filename);
        set_config('logocompact', '/' . $logocompact->filename, $parenttheme);
    }

    if (!get_config($parenttheme, 'loginbackgroundimage')) {
        $loginbackgroundimage = clone $filerecord;
        $loginbackgroundimage->filearea  = 'loginbackgroundimage';
        $loginbackgroundimage->filename = 'loginbackgroundimage.jpg';
        $fs->create_file_from_pathname($loginbackgroundimage,
            $CFG->dirroot . '/theme/boost_union_child/pix/' . $loginbackgroundimage->filename);
        set_config('loginbackgroundimage', '/' . $loginbackgroundimage->filename, $parenttheme);
    }

    $childtheme = 'theme_boost_union_child';    
    set_config('customfield', 'academicyear', $childtheme);
    set_config('includeaccyearsfrom', '24', $childtheme);
    set_config('includeaccyearsto', '26', $childtheme);
    set_config('monthtoswitchyearfilter', 'August', $childtheme);
    set_config('institutions', 'BBBSCH,LLILAW', $childtheme);

    // Update default filerecord to $childthame.
    $filerecord->component = $childtheme;

    if (!get_config($childtheme, 'bbbsch')) {
        $bbbsch = clone $filerecord;
        $bbbsch->filearea  = 'bbbsch';
        $bbbsch->filename = 'bbbsch.png';
        $fs->create_file_from_pathname($bbbsch,
            $CFG->dirroot . '/theme/boost_union_child/pix/' . $bbbsch->filename);
        set_config('bbsch', '/' . $bbbsch->filename, $childtheme);
    }

    if (!get_config($childtheme, 'llilaw')) {
        $llilaw = clone $filerecord;
        $llilaw->filearea  = 'llilaw';
        $llilaw->filename = 'llilaw.png';
        $fs->create_file_from_pathname($llilaw,
            $CFG->dirroot . '/theme/boost_union_child/pix/' . $llilaw->filename);
        set_config('llilaw', $llilaw->filename, $childtheme);
    }

    return true;
}


