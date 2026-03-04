<?php
declare(strict_types=1);

namespace AquiveMedia\CatalogImageSlideshow\Plugin\Block\Product;

use AquiveMedia\CatalogImageSlideshow\Block\Product\Image;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\AbstractProduct;

class AbstractProductPlugin
{
    /**
     * @param AbstractProduct $subject
     * @param mixed $result
     * @param ProductInterface $product
     * @return mixed
     */
    public function afterGetImage(AbstractProduct $subject, $result, $product)
    {
        if ($result instanceof Image) {
            $result->setData('product_object', $product);
        }
        return $result;
    }
}
