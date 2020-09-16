<?php

declare(strict_types=1);

namespace Shopsys\ReadModelBundle\Brand;

use Shopsys\FrameworkBundle\Component\Router\FriendlyUrl\FriendlyUrlFacade;
use Shopsys\FrameworkBundle\Model\Product\ProductFacade;

class BrandViewFacade implements BrandViewFacadeInterface
{
    /**
     * @var \Shopsys\FrameworkBundle\Model\Product\ProductFacade
     */
    protected $productFacade;

    /**
     * @var \Shopsys\ReadModelBundle\Brand\BrandViewFactory
     */
    protected $brandViewFactory;

    /**
     * @var \Shopsys\FrameworkBundle\Component\Router\FriendlyUrl\FriendlyUrlFacade
     */
    protected $friendlyUrlFacade;

    /**
     * @param \Shopsys\FrameworkBundle\Model\Product\ProductFacade $productFacade
     * @param \Shopsys\ReadModelBundle\Brand\BrandViewFactory $brandViewFactory
     * @param \Shopsys\FrameworkBundle\Component\Router\FriendlyUrl\FriendlyUrlFacade $friendlyUrlFacade
     */
    public function __construct(
        ProductFacade $productFacade,
        BrandViewFactory $brandViewFactory,
        FriendlyUrlFacade $friendlyUrlFacade
    ) {
        $this->productFacade = $productFacade;
        $this->friendlyUrlFacade = $friendlyUrlFacade;
        $this->brandViewFactory = $brandViewFactory;
    }

    /**
     * @param int $productId
     * @return \Shopsys\ReadModelBundle\Brand\BrandView|null
     */
    public function findByProductId(int $productId): ?BrandView
    {
        $product = $this->productFacade->getById($productId);

        $brand = $product->getBrand();

        if ($brand === null) {
            return null;
        }

        return $this->brandViewFactory->createFromBrand(
            $brand,
            $this->friendlyUrlFacade->getAbsoluteUrlByRouteNameAndEntityIdOnCurrentDomain('front_brand_detail', $brand->getId())
        );
    }
}
