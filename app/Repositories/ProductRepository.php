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

namespace App\Repositories;

use App\Models\Product;
use App\Utils\Traits\SavesDocuments;

class ProductRepository extends BaseRepository
{
    use SavesDocuments;

    /**
     * @param array $data
     * @param Product $product
     * @return Product|null
     */
    public function save(array $data, Product $product) : ?Product
    {
        $product->fill($data);
        $product->save();

        if (array_key_exists('documents', $data)) {
            $this->saveDocuments($data['documents'], $product);
        }

        return $product;
    }
}
