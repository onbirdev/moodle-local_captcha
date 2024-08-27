<?php

/**
 * @package    local_captcha
 * @brief      Captcha plugin for Moodle.
 * @category   Moodle, Captcha
 *
 * @author     MohammadReza PourMohammad <onbirdev@gmail.com>
 * @copyright  2024 MohammadReza PourMohammad
 * @link       https://onbir.dev
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Ensure the file is being accessed within Moodle
defined('MOODLE_INTERNAL') || die();

// Check if the admin settings tree is being accessed
if ($ADMIN->fulltree || $hassiteconfig) {
    // Create a new settings page for the captcha plugin
    $settings = new admin_settingpage('local_captcha', get_string('settings', 'local_captcha'));

    // Add the settings page to the 'localplugins' category
    $ADMIN->add('localplugins', $settings);

    // Enable or disable captcha setting
    $settings->add(
        new admin_setting_configcheckbox('local_captcha/enable', get_string('enable', 'local_captcha'), '', true),
    );

    // Captcha input name setting
    $settings->add(
        new admin_setting_configtext(
            'local_captcha/input_name',
            get_string('input_name', 'local_captcha'),
            '',
            'captcha_code',
        ),
    );

    // Minimum length of the generated captcha code setting
    $settings->add(
        new admin_setting_configselect('local_captcha/min_length', get_string('min_length', 'local_captcha'), '', 4, [
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
        ]),
    );

    // Maximum length of the generated captcha code setting
    $settings->add(
        new admin_setting_configselect('local_captcha/max_length', get_string('max_length', 'local_captcha'), '', 5, [
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8,
        ]),
    );

    // Enable or disable the use of digits in the captcha setting
    $settings->add(
        new admin_setting_configcheckbox('local_captcha/digits', get_string('digits', 'local_captcha'), '', true),
    );

    // Enable or disable the use of uppercase letters in the captcha setting
    $settings->add(
        new admin_setting_configcheckbox('local_captcha/upper', get_string('upper', 'local_captcha'), '', true),
    );

    // Enable or disable the use of lowercase letters in the captcha setting
    $settings->add(
        new admin_setting_configcheckbox('local_captcha/lower', get_string('lower', 'local_captcha'), '', true),
    );

    // Select the font for the captcha text setting
    $settings->add(
        new admin_setting_configselect('local_captcha/font', get_string('font', 'local_captcha'), '', '', [
            '' => get_string('default', 'local_captcha'),
            'persian' => get_string('persian', 'local_captcha'),
        ]),
    );

    // Minimum quality of the captcha image setting
    $settings->add(
        new admin_setting_configtext(
            'local_captcha/min_quality',
            get_string('min_quality', 'local_captcha'),
            '',
            10,
            PARAM_INT,
        ),
    );

    // Maximum quality of the captcha image setting
    $settings->add(
        new admin_setting_configtext(
            'local_captcha/max_quality',
            get_string('max_quality', 'local_captcha'),
            '',
            60,
            PARAM_INT,
        ),
    );

    // Height of the captcha image setting
    $settings->add(
        new admin_setting_configtext('local_captcha/height', get_string('height', 'local_captcha'), '', 50, PARAM_INT),
    );

    // Width of the captcha image setting
    $settings->add(
        new admin_setting_configtext('local_captcha/width', get_string('width', 'local_captcha'), '', 150, PARAM_INT),
    );
}
