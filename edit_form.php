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
 * Block edit form class for the block_iagora plugin.
 *
 * @package   block_iagora
 * @copyright 2024, Datum Academy <dev@datum.academy>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/**
 * Class block_iagora_edit_form extending block_edit_form.
 *
 * This form class allows configuration of specific settings for the iagora block,
 * including the iframe URL.
 */
class block_iagora_edit_form extends block_edit_form {

    /**
     * Specific definition of the form elements.
     *
     * @param MoodleQuickForm $mform The Moodle form to be configured.
     */
    protected function specific_definition($mform) {
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        // Iframe URL.
        $mform->addElement('text', 'config_iframeurl', get_string('iframeurl', 'block_iagora'));
        $mform->setType('config_iframeurl', PARAM_URL);
        $mform->addHelpButton('config_iframeurl', 'iframeurl', 'block_iagora');
        $mform->setDefault('config_iframeurl', '');
        $mform->addElement('static', 'iframeurl_desc', '', get_string('iframeurl_desc', 'block_iagora'));

    }

}
