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
namespace Tests\Feature\PdfMaker;

use App\Services\PdfMaker\Designs\Utilities\DesignHelpers;

class ExampleDesign
{
    use DesignHelpers;

    public $client;

    public $entity;

    public $context;

    public function html()
    {
        return file_get_contents(
            base_path('tests/Feature/PdfMaker/example-design.html')
        );
    }
}
