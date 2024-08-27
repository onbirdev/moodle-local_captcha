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
 * Class CaptchaConfigHelper
 *
 * Helper class for configuring and generating captcha parameters in Moodle.
 */
class CaptchaConfigHelper
{
    public const DIGITS = '1234567890';
    public const CHARS_LOWER = 'abcdefghijklmnpqrstuvwxyz';
    public const CHARS_UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    public const FONTS = [
        'captcha0.ttf',
        'captcha1.ttf',
        'captcha2.ttf',
        'captcha3.ttf',
        'captcha4.ttf',
        'captcha5.ttf',
    ];
    public const FONTS_PERSIAN = ['sahel.ttf', 'shabnam.ttf', 'vazirmatn.ttf'];
    public const DEFAULT_LENGTH = 6;
    public const DEFAULT_QUALITY = 40;
    public const DEFAULT_HEIGHT = 50;
    public const DEFAULT_WIDTH = 140;
    public const MIN_HEIGHT = 20;
    public const MIN_WIDTH = 80;
    public const MAX_HEIGHT = 100;
    public const MAX_WIDTH = 300;
    public const INPUT_NAME = 'captcha_code';

    /**
     * Retrieve a configuration parameter with a default fallback.
     *
     * @param string $name The name of the configuration parameter.
     * @param mixed $default The default value if the parameter is not set.
     * @return mixed The value of the configuration parameter or the default value.
     */
    public static function getParam($name, $default = null)
    {
        $param = get_config('local_captcha', $name);
        return $param ?: $default;
    }

    /**
     * Get the input name for the captcha.
     *
     * @return string The input name for the captcha.
     */
    public static function getInputName(): string
    {
        $inputName = self::getParam('input_name');

        if (empty($inputName)) {
            $inputName = self::INPUT_NAME;
        }

        return $inputName;
    }

    /**
     * Get the length of the captcha code.
     *
     * @return int The length of the captcha code.
     */
    public static function getLength(): int
    {
        $min = (int) self::getParam('min_length');
        $max = (int) self::getParam('max_length');

        if (!$min || !$max) {
            return self::DEFAULT_LENGTH;
        }

        if ($max <= $min) {
            return $min;
        }

        return rand($min, $max);
    }

    /**
     * Get the character set for the captcha code.
     *
     * @return string The character set for the captcha code.
     */
    public static function getCharset(): string
    {
        $includeDigits = (bool) self::getParam('digits');
        $includeLower = (bool) self::getParam('lower');
        $includeUpper = (bool) self::getParam('upper');

        $charset = '';

        if ($includeDigits) {
            $charset .= self::DIGITS;
        }
        if ($includeLower) {
            $charset .= self::CHARS_LOWER;
        }
        if ($includeUpper) {
            $charset .= self::CHARS_UPPER;
        }

        if (empty($charset)) {
            $charset = self::CHARS_LOWER . self::DIGITS . self::CHARS_UPPER;
        }

        return $charset;
    }

    /**
     * Get the font for the captcha text.
     *
     * @return string The path to the font file.
     * @global object $CFG The global configuration object.
     */
    public static function getFont(): string
    {
        global $CFG;

        $font = self::getParam('font');
        $fontName = self::FONTS[array_rand(self::FONTS)];

        if ($font == 'persian') {
            $fontName = self::FONTS_PERSIAN[array_rand(self::FONTS_PERSIAN)];
        }

        return $CFG->dirroot . '/local/captcha/fonts/' . $fontName;
    }

    /**
     * Get the quality of the captcha image.
     *
     * @return int The quality of the captcha image.
     */
    public static function getQuality(): int
    {
        $min = (int) self::getParam('min_quality');
        $max = (int) self::getParam('max_quality');

        if (!$min || !$max) {
            return self::DEFAULT_QUALITY;
        }

        if ($max <= $min) {
            return $min;
        }

        return rand($min, $max);
    }

    /**
     * Get the height of the captcha image.
     *
     * @return int The height of the captcha image.
     */
    public static function getHeight(): int
    {
        $height = (int) self::getParam('height');

        if (!$height || $height > self::MAX_HEIGHT || $height < self::MIN_HEIGHT) {
            return self::DEFAULT_HEIGHT;
        }

        return $height;
    }

    /**
     * Get the width of the captcha image.
     *
     * @return int The width of the captcha image.
     */
    public static function getWidth(): int
    {
        $width = (int) self::getParam('width');

        if (!$width || $width > self::MAX_WIDTH || $width < self::MIN_WIDTH) {
            return self::DEFAULT_WIDTH;
        }

        return $width;
    }
}
