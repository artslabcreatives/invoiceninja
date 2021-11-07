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

namespace App\Events\Product;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Queue\SerializesModels;

/**
 * Class ProductWasRestored.
 */
class ProductWasRestored
{
    use SerializesModels;

    /**
     * @var Product
     */
    public $invoice;

    public $company;

    public $event_vars;

    public $fromDeleted;
    /**
     * Create a new event instance.
     *
     * @param Product $invoice
     * @param Company $company
     * @param array $event_vars
     */
    public function __construct(Product $product, $fromDeleted, Company $company, array $event_vars)
    {
        $this->product = $product;
        $this->fromDeleted = $fromDeleted;
        $this->company = $company;
        $this->event_vars = $event_vars;
    }
}
