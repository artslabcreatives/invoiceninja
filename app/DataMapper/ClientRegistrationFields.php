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

namespace App\DataMapper;

class ClientRegistrationFields
{

    public static function generate()
    {
        $data = 
        [
            [
                'key' => 'first_name',
                'required' => true
            ],
            [
                'key' => 'last_name',
                'required' => true
            ],
            [
                'key' => 'email',
                'required' => true
            ],
            [
                'key' => 'phone',
                'required' => false
            ],
            [
                'key' => 'password',
                'required' => true
            ], 
            [
                'key' => 'name',
                'required' => false
            ],
            [
                'key' => 'website',
                'required' => false
            ],
            [
                'key' => 'address1',
                'required' => false
            ],
            [
                'key' => 'address2',
                'required' => false
            ],
            [
                'key' => 'city',
                'required' => false
            ],
            [
                'key' => 'state',
                'required' => false
            ],
            [
                'key' => 'postal_code',
                'required' => false
            ],            
            [
                'key' => 'country_id',
                'required' => false
            ],            
            [
                'key' => 'custom_value1',
                'required' => false
            ],            
            [
                'key' => 'custom_value2',
                'required' => false
            ],
            [
                'key' => 'custom_value3',
                'required' => false
            ],            
            [
                'key' => 'custom_value4',
                'required' => false
            ],                       
            [
                'key' => 'public_notes',
                'required' => false
            ],   
            [
                'key' => 'vat_number',
                'required' => false
            ],          
        ];

        return $data;
    }
}