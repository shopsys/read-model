<?php

declare(strict_types=1);

namespace Shopsys\ReadModelBundle\Product\Action;

use Shopsys\FrameworkBundle\Model\Product\Product;

/**
 * @experimental
 */
class ProductActionViewFactory
{
    /**
     * @param \Shopsys\FrameworkBundle\Model\Product\Product $product
     * @param string $absoluteUrl
     * @return \Shopsys\ReadModelBundle\Product\Action\ProductActionView
     */
    public function createFromProduct(Product $product, string $absoluteUrl): ProductActionView
    {
        return new ProductActionView(
            $product->getId(),
            $product->getCalculatedSellingDenied(),
            $product->isMainVariant(),
            $absoluteUrl
        );
    }

    /**
     * @param array $productArray
     * @return \Shopsys\ReadModelBundle\Product\Action\ProductActionView
     */
    public function createFromArray(array $productArray): ProductActionView
    {
        return new ProductActionView(
            $productArray['id'],
            $productArray['calculated_selling_denied'],
            $productArray['is_main_variant'],
            $productArray['detail_url']
        );
    }
}
