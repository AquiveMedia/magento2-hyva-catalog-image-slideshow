<?php

namespace AquiveMedia\CatalogImageSlideshow\Block\Product;

use AquiveMedia\CatalogImageSlideshow\Api\Config\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\Image as OriginalImage;
use Magento\Catalog\Helper\ImageFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;

class Image extends OriginalImage
{
    protected const ORIGINAL_TEMPLATE_PATH = 'product/list/image.phtml';
    protected const AQUIVEMEDIA_TEMPLATE_PATH = 'AquiveMedia_CatalogImageSlideshow::product/list/image.phtml';

    public function __construct(
        Context                     $context,
        protected ConfigInterface   $config,
        protected ProductRepository $productRepository,
        protected ImageFactory      $imageFactory,
        array                       $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function slideShowEnabled(): bool
    {
        return $this->config->isEnabled();
    }

    /**
     * @throws NoSuchEntityException
     */
    public function setTemplate($template): Image
    {
        if (
            $this->slideShowEnabled()
            && $this->getProduct() !== null
            && str_contains($template, Image::ORIGINAL_TEMPLATE_PATH)
        ) {
            $template = Image::AQUIVEMEDIA_TEMPLATE_PATH;
        }

        return parent::setTemplate($template);
    }

    /**
     * @return ProductInterface|mixed|null
     * @throws NoSuchEntityException
     */
    public function getProduct()
    {
        try {
            return $this->productRepository->getById($this->getProductId());
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getGalleryUrls(): array
    {
        $product = $this->getProduct();
        if (!$product) {
            return [];
        }
        $galleryImages = $product->getMediaGalleryImages() ?: [];

        if (!$galleryImages->getSize()) {
            return [];
        }

        $imageHelper = $this->imageFactory->create();

        return array_filter(array_map(function ($image) use ($product, $imageHelper) {
            return $imageHelper
                ->init($product, 'category_page_grid')
                ->setImageFile($image->getFile())
                ->getUrl();
        }, $galleryImages->getItems()));
    }
}
