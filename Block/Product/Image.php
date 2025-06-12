<?php

namespace AquiveMedia\CatalogImageSlideshow\Block\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Psr\Log\LoggerInterface;

class Image extends \Magento\Catalog\Block\Product\Image
{
    const XML_PATH_SLIDESHOW_ENABLED = 'catalog/image_slideshow/enable';

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var ProductRepository
     */
    protected $_productRepository;

    /**
     * @var LoggerInterface
     */
    protected $_logger;

    /**
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param ProductRepository $productRepository
     * @param LoggerInterface $logger
     * @param array $data
     */
    public function __construct(
        Context              $context,
        ScopeConfigInterface $scopeConfig,
        ProductRepository    $productRepository,
        LoggerInterface      $logger,
        array                $data = []
    ){
        $this->_scopeConfig = $scopeConfig;
        $this->_productRepository = $productRepository;
        $this->_logger = $logger;
        parent::__construct($context, $data);
    }

    /**
     * @return bool
     */
    public function slideShowEnabled(): bool
    {
        try {
            return $this->_scopeConfig->getValue(self::XML_PATH_SLIDESHOW_ENABLED);
        } catch (\Throwable $e) {
            $this->_logger->error('Error getting slideshow enabled config: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * @param $template
     * @return Image
     */
    public function setTemplate($template)
    {
        if ($this->slideShowEnabled()) {
            // Check if the template is the default product image template (This is the path for Hyva Themes)
            if ($this->getProduct() !== null){
                if (str_contains($template, 'product/list/image.phtml')) {
                    $template = 'AquiveMedia_CatalogImageSlideshow::product/list/image.phtml';
                }
            }
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
            $productId = $this->getProductId();
            $product = $this->_productRepository->getById($productId);
            return $product;
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }
}
