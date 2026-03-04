<?php

namespace AquiveMedia\CatalogImageSlideshow\Block\Product;

use AquiveMedia\CatalogImageSlideshow\Api\Config\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Block\Product\Image as OriginalImage;
use Magento\Catalog\Helper\ImageFactory;
use Magento\Catalog\Model\Product\Gallery\ReadHandler as GalleryReadHandler;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;

class Image extends OriginalImage
{
    protected const string ORIGINAL_TEMPLATE_PATH = 'product/list/image.phtml';
    protected const string AQUIVEMEDIA_TEMPLATE_PATH = 'AquiveMedia_CatalogImageSlideshow::product/list/image.phtml';

    /**
     * @param Context $context
     * @param ConfigInterface $config
     * @param ProductRepository $productRepository
     * @param ImageFactory $imageFactory
     * @param GalleryReadHandler $galleryReadHandler
     * @param array $data
     */
    public function __construct(
        Context                      $context,
        protected ConfigInterface    $config,
        protected ProductRepository  $productRepository,
        protected ImageFactory       $imageFactory,
        protected GalleryReadHandler $galleryReadHandler,
        array                        $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function slideShowEnabled(): bool
    {
        return $this->config->isEnabled();
    }

    /**
     * @param string $template
     * @return Image
     */
    public function setTemplate($template): Image
    {
        if (
            $this->slideShowEnabled()
            && $this->getProductId()
            && str_contains($template, Image::ORIGINAL_TEMPLATE_PATH)
        ) {
            $template = Image::AQUIVEMEDIA_TEMPLATE_PATH;
        }

        return parent::setTemplate($template);
    }

    /**
     * @return ProductInterface|null
     */
    public function getProduct()
    {
        $product = $this->getData('product_object');
        if ($product instanceof ProductInterface) {
            if (!$product->hasData('media_gallery')) {
                $this->galleryReadHandler->execute($product);
            }
            return $product;
        }

        try {
            $productId = $this->getProductId();
            if ($productId) {
                return $this->productRepository->getById($productId);
            }
        } catch (NoSuchEntityException $e) {
            return null;
        }

        return null;
    }

    /**
     * @return array
     */
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

        return array_values(
            array_filter(
                array_map(function ($image) use ($product, $imageHelper) {
                    return $imageHelper
                        ->init($product, 'category_page_grid')
                        ->setImageFile($image->getFile())
                        ->getUrl();
                }, $galleryImages->getItems())
            )
        );
    }
}
