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
 * Interface for the PhraseBuilder
 *
 * @author Gregwar <g.passault@gmail.com>
 */
interface PhraseBuilderInterface
{
    /**
     * Generates  random phrase of given length with given charset
     */
    public function build();

    /**
     * "Niceize" a code
     */
    public function niceize($str);
}
