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

use moodle_url;
use MoodleQuickForm;

defined('MOODLE_INTERNAL') || die();

/**
 * Class CaptchaHelper
 *
 * Provides utility functions for handling captcha functionality such as rendering
 * the captcha, validating it, and integrating it with forms.
 */
class CaptchaHelper
{
    /**
     * Check if captcha is enabled.
     *
     * @return bool True if captcha is enabled, false otherwise.
     */
    public static function isCaptchaEnabled(): bool
    {
        return (bool) CaptchaConfigHelper::getParam('enable');
    }

    /**
     * Get the input name for the captcha.
     *
     * @return string The input name for the captcha.
     */
    public static function getCaptchaInputName(): string
    {
        return CaptchaConfigHelper::getParam('input_name', 'captcha_code');
    }

    /**
     * Get the error message to display when the captcha validation fails.
     *
     * @return string The error message for invalid captcha.
     */
    public static function getErrorMessage(): string
    {
        return get_string('captcha_is_no_valid', 'local_captcha');
    }

    /**
     * Generate the HTML for the captcha.
     *
     * @return string The HTML for the captcha.
     * @global object $OUTPUT The global output renderer.
     */
    public static function getCaptchaHtml(): string
    {
        global $OUTPUT;

        return $OUTPUT->render_from_template('local_captcha/captcha_html', [
            'captcha_url' => new moodle_url('/local/captcha/captcha.php', ['t' => microtime(true)]),
            'captcha_base_url' => new moodle_url('/local/captcha/captcha.php'),
            'captcha_input_name' => self::getCaptchaInputName(),
        ]);
    }

    /**
     * Generate the HTML for the captcha.
     *
     * @return string The HTML for the captcha.
     * @global object $OUTPUT The global output renderer.
     */
    public static function getCaptchaFullHtml(): string
    {
        global $OUTPUT;

        return $OUTPUT->render_from_template('local_captcha/captcha_full_html', [
            'captcha_url' => new moodle_url('/local/captcha/captcha.php', ['t' => microtime(true)]),
            'captcha_base_url' => new moodle_url('/local/captcha/captcha.php'),
            'captcha_input_name' => self::getCaptchaInputName(),
        ]);
    }

    /**
     * Add captcha elements to a given form.
     *
     * @param MoodleQuickForm $form The form object to add the captcha elements to.
     */
    public static function addCaptchaElementToForm(MoodleQuickForm $form)
    {
        $captchaElementName = self::getCaptchaInputName();

        // Add captcha input elements to the form
        $form->addElement('html', '<div class="form-group fitem captcha">');
        $form->addElement('html', self::getCaptchaHtml());
        $form->addElement('text', $captchaElementName, get_string('captcha', 'local_captcha'), ['dir' => 'ltr']);
        $form->addElement('html', '</div>');

        // Add validation rules for the captcha
        $form->addRule($captchaElementName, get_string('required'), 'required');
        $form->setType($captchaElementName, PARAM_TEXT);
    }

    /**
     * Validate the provided captcha code.
     *
     * @param string|null $captchaValue The captcha code to validate.
     * @param array|string|null $errors Reference to an array where errors will be stored.
     * @return bool True if the captcha is valid, false otherwise.
     * @global object $SESSION The global session object.
     */
    public static function validateCaptcha(string $captchaValue = null, &$errors = null): bool
    {
        global $SESSION;
        $captchaName = self::getCaptchaInputName();

        if (empty($captchaValue)) {
            $captchaValue = optional_param($captchaName, null, PARAM_TEXT);
        }

        $captchaValue = self::convertPersianArabicNumeralsToEnglish($captchaValue);

        $isValid =
            isset($SESSION->{$captchaName}) && PhraseBuilder::comparePhrases($SESSION->{$captchaName}, $captchaValue);

        // Unset the captcha session variable after validation
        unset($SESSION->{$captchaName});

        if (!$isValid) {
            if (is_array($errors)) {
                $errors[self::getCaptchaInputName()] = self::getErrorMessage();
            } else {
                $errors = self::getErrorMessage();
            }
        }

        return $isValid;
    }

    /**
     * Convert Persian/Arabic numerals to English numerals.
     *
     * This function replaces Persian and Arabic numerals in a given string with their
     * corresponding English numerals.
     *
     * @param string $string The input string potentially containing Persian/Arabic numerals.
     * @return string The string with Persian/Arabic numerals converted to English numerals.
     */
    protected static function convertPersianArabicNumeralsToEnglish(string $string): string
    {
        // Define arrays of Persian and Arabic numerals
        $persianNumerals = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $arabicNumerals = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

        // Define the array of English numerals to replace with
        $englishNumerals = range(0, 9);

        // Replace Persian numerals with English numerals
        $string = str_replace($persianNumerals, $englishNumerals, $string);

        // Replace Arabic numerals with English numerals
        return str_replace($arabicNumerals, $englishNumerals, $string);
    }
}
