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

namespace App\DataMapper\Billing;


class WebhookConfiguration
{
    /**
     * @var string
     */
    public $return_url = '';

    /**
     * @var string
     */
    public $post_purchase_url = '';

    /**
     * @var array
     */
    public $post_purchase_headers = [];

    /**
     * @var string
     */
    public $post_purchase_body =  '';

    /**
     * @var string
     */ 
    public $post_purchase_rest_method = 'POST';

    /**
     * @var array
     */
    public static $casts = [
        'return_url' => 'string',
        'post_purchase_url' => 'string',
        'post_purchase_rest_method' => 'string',
        'post_purchase_headers' => 'array',
        'post_purchase_body' => 'object',
    ];
}
