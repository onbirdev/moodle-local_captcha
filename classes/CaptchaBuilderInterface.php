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

namespace local_captcha;

defined('MOODLE_INTERNAL') || die();

/**
 * A Captcha builder
 */
interface CaptchaBuilderInterface
{
    /**
     * Builds the code
     */
    public function build($width, $height, $font, $fingerprint);

    /**
     * Saves the code to a file
     */
    public function save($filename, $quality);

    /**
     * Gets the image contents
     */
    public function get($quality);

    /**
     * Outputs the image
     */
    public function output($quality);
}
