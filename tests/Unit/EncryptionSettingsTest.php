<?php
/**
 * Hype Sri Lanka (https://hypesl.org).
 *
 * @link https://github.com/artslabcreatives/invoiceninja source repository
 *
 * @copyright Copyright (c) 2021. Hype Sri Lanka LLC (https://hypesl.org)
 *
 * @license https://opensource.org/licenses/AAL
 */
namespace Tests\Unit;

use Tests\TestCase;

/**
 * @test
 */
class EncryptionSettingsTest extends TestCase
{
    public function setUp() :void
    {
        parent::setUp();

        $this->settings = '{"publishable_key":"publish","23_apiKey":"client","enable_ach":"1","enable_sofort":"1","enable_apple_pay":"1","enable_alipay":"1"}';
    }

    public function testDecryption()
    {
        $this->settings = encrypt($this->settings);

        $this->assertEquals('publish', $this->getConfigField('publishable_key'));
        $this->assertEquals('client', $this->getConfigField('23_apiKey'));
        $this->assertEquals(1, $this->getConfigField('enable_ach'));
        $this->assertEquals(1, $this->getConfigField('enable_sofort'));
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return json_decode(decrypt($this->settings));
    }

    /**
     * @param $field
     *
     * @return mixed
     */
    public function getConfigField($field)
    {
        return object_get($this->getConfig(), $field, false);
    }
}
