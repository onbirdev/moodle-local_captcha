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

use local_captcha\CaptchaBuilder;
use local_captcha\CaptchaConfigHelper;
use local_captcha\CaptchaHelper;
use local_captcha\PhraseBuilder;

require __DIR__ . '/../../config.php';

global $SESSION;

// Build the captcha phrase using the configured length and character set
$phraseBuilder = new PhraseBuilder(CaptchaConfigHelper::getLength(), CaptchaConfigHelper::getCharset());

// Create a new CaptchaBuilder instance with the generated phrase
$captcha = new CaptchaBuilder(null, $phraseBuilder);

// Retrieve the captcha input name and store the phrase in the session
$captchaName = CaptchaHelper::getCaptchaInputName();
$SESSION->{$captchaName} = $captcha->getPhrase();

// Set the content type header to output an image in JPEG format
header('Content-type: image/jpeg');

// Build and output the captcha image with configured dimensions and quality
$captcha
    ->build(CaptchaConfigHelper::getWidth(), CaptchaConfigHelper::getHeight(), CaptchaConfigHelper::getFont())
    ->output(CaptchaConfigHelper::getQuality());
