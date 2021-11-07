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

use App\Jobs\Util\UploadFile;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Tests\MockAccountData;
use Tests\TestCase;

/**
 * @test
 * @covers  App\Jobs\Util\UploadFile
 */
class UploadFileTest extends TestCase
{
    use MockAccountData;
    use DatabaseTransactions;

    public function setUp() :void
    {
        parent::setUp();

        $this->makeTestData();

        $this->withoutMiddleware(
            ThrottleRequests::class
        );
    }

    public function testFileUploadWorks()
    {
        $image = UploadedFile::fake()->image('avatar.jpg');

        $document = UploadFile::dispatchNow(
            $image,
            UploadFile::IMAGE,
            $this->invoice->user,
            $this->invoice->company,
            $this->invoice
        );

        $this->assertNotNull($document);
    }
}
