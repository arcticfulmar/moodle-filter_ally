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
 * Test case for privacy implementation.
 *
 * @package   filter_ally
 * @copyright Copyright (c) 2018 Open LMS (https://www.openlms.net)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

use core_privacy\local\metadata\collection;
use core_privacy\local\metadata\types\external_location;
use core_privacy\tests\provider_testcase;
use filter_ally\privacy\provider;

defined('MOODLE_INTERNAL') || die();

/**
 * Test case for privacy implementation.
 *
 * @package   filter_ally
 * @copyright Copyright (c) 2018 Open LMS (https://www.openlms.net)
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_ally_privacy_provider_testcase extends provider_testcase {
    /**
     * Test for provider::get_metadata().
     */
    public function test_get_metadata() {
        $collection     = provider::get_metadata(new collection('filter_ally'));
        $itemcollection = $collection->get_collection();
        $this->assertCount(1, $itemcollection);

        /** @var external_location $item */
        $item = reset($itemcollection);
        $this->assertEquals('jwt', $item->get_name());

        $privacyfields = $item->get_privacy_fields();
        $this->assertCount(4, $privacyfields);
        $this->assertArrayHasKey('userid', $privacyfields);
        $this->assertArrayHasKey('courseid', $privacyfields);
        $this->assertArrayHasKey('locale', $privacyfields);
        $this->assertArrayHasKey('roles', $privacyfields);

        $this->assertEquals('privacy:metadata:jwt:externalpurpose', $item->get_summary());
    }
}