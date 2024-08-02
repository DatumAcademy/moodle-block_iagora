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
        $iframeurl = isset($this->config->iframeurl) ? $this->config->iframeurl : '';

        // if (empty($iframeurl)) {
        //     $this->content->text = get_string('noiframeurl', 'block_iagora');
        // } else {
        //     $this->content->text = '<iframe src="' . $iframeurl . '" width="100%" height="400px" frameborder="0"></iframe>';
        // }
        $this->content->text = $this->generate_chat_content($iframeurl);

        return $this->content;
    }

    /**
     * Define in which pages this block can be added.
     *
     * @param string $iframeurl The URL to be used in the iframe.
     * @return string The generated HTML content.
     */
    private function generate_chat_content($iframeurl) {
        global $PAGE, $OUTPUT;  die($iframeurl);

        // Load necessary styles and scripts
        $PAGE->requires->js(new moodle_url('https://cdn.botframework.com/botframework-webchat/latest/webchat.js'), true);
        $PAGE->requires->js_call_amd('block_iagora/iagora', 'init', [[
            'copiloturl' => $iframeurl
        ]]);

        // Generate a unique identifier for the chat container
        $chat_id = uniqid('iagora_chat_');

        // Chat button icon (using Moodle icons)
        $chat_icon = $OUTPUT->pix_icon('t/message', get_string('openchat', 'block_iagora'));

        $output = html_writer::div($chat_icon, 'iagora-chat-toggle', ['id' => 'iagora-toggle-' . $chat_id,'data-url' => 'iframe_url']);
        $output .= html_writer::div('', 'iagora-chat-container', ['id' => $chat_id]);

        // Add initialization script
        // $output .= html_writer::script("
        //     document.addEventListener('DOMContentLoaded', function() {
        //         initIagoraChat('{$chat_id}', " . json_encode($this->config) . ");
        //     });
        // ");

        return $output;
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
     * Save instance configuration.
     *
     * @param stdClass $data The configuration data.
     * @param bool $nolongerused Indicates if $data is no longer used.
     * @return bool True if data was saved successfully, false otherwise.
     */
    public function instance_config_save($data, $nolongerused = false) {
        if (isset($data->iframeurl)) {
            $data->iframeurl = clean_param($data->iframeurl, PARAM_URL);
        }
        return parent::instance_config_save($data, $nolongerused);
    }
}
