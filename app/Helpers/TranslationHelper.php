<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka (https://hypesl.org)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

/**
 * Returns a custom translation string
 * falls back on defaults if no string exists.
 *
 * //Cache::forever($custom_company_translated_string, 'mogly');
 *
 * @param string translation string key
 * @param array $replace
 * @param null $locale
 * @return string
 */
function ctrans(string $string, $replace = [], $locale = null) : string
{
    return trans($string, $replace, $locale);
}
