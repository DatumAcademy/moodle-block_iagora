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
 * Block definition class for the block_iagora plugin.
 *
 * @package   block_iagora
 * @copyright 2024, Datum Academy <dev@datum.academy>
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Store configuration data for the iagora block.
 */
class block_iagora extends block_base {

    /**
     * Initialize the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_iagora');
    }

    /**
     * Get the block content.
     *
     * @return string The block HTML.
     */
    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';
        $copilotendpointurl = isset($this->config->copilotendpointurl) ? $this->config->copilotendpointurl : '';

        if (empty($copilotendpointurl)) {
            $this->content->text = get_string('nocopilotendpointurl', 'block_iagora');
        } else {
            $this->content->text = $this->generate_chat_content($copilotendpointurl);
        }
        return $this->content;

    }

    /**
     * Generate the HTML content for the chat block.
     *
     * @param string $copilotendpointurl The URL to be used in the iframe.
     * @return string The generated HTML content for the chat.
     */
    private function generate_chat_content($copilotendpointurl) {
        global $OUTPUT;
        // Generate a unique identifier for the chat container.
        $chatid = uniqid('iagora_chat_');
        $context = [
            'chatId' => $chatid,
            'tokenEndpointURL' => $copilotendpointurl,
        ];
        return $OUTPUT->render_from_template('block_iagora/chat', $context);
    }

    /**
     * Define in which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() {
        return ['all' => true];
    }

    /**
     * Allow the block to be configured.
     *
     * @return bool
     */
    public function instance_allow_config() {
        return true;
    }

    /**
     * Save instance configuration.
     *
     * @param stdClass $data The configuration data.
     * @param bool $nolongerused Indicates if $data is no longer used.
     * @return bool True if data was saved successfully, false otherwise.
     */
    public function instance_config_save($data, $nolongerused = false) {
        if (isset($data->copilotendpointurl)) {
            $data->copilotendpointurl = clean_param($data->copilotendpointurl, PARAM_URL);
        }
        return parent::instance_config_save($data, $nolongerused);
    }
}
