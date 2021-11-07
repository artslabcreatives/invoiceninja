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

namespace App\Utils\HostedPDF;

use GuzzleHttp\RequestOptions;

class NinjaPdf
{

    private $url = 'https://pdf.invoicing.co/api/';

    public function build($html)
    {

        $client =  new \GuzzleHttp\Client(['headers' => 
            [ 
            'X-Ninja-Token' => 'test_token_for_now',        
            ]
        ]);

        $response = $client->post($this->url,[
            RequestOptions::JSON => ['html' => $html]
        ]);

        return $response->getBody();
    }

}
