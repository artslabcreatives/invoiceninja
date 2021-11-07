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
namespace Tests\Integration;

use App\Models\Company;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 */
class ContainerTest extends TestCase
{
    use MockAccountData;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();

        app()->instance(Company::class, $this->company);
    }

    public function testBindingWorks()
    {
        $resolved_company = resolve(Company::class);

        $this->assertNotNull($resolved_company);

        $this->assertEquals($this->account->id, $resolved_company->account_id);
    }
}
