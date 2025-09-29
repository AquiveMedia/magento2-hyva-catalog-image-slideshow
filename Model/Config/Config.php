<?php
declare(strict_types=1);

namespace AquiveMedia\CatalogImageSlideshow\Model\Config;

use AquiveMedia\CatalogImageSlideshow\Api\Config\ConfigInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class Config implements ConfigInterface
{
    public function __construct(
        protected ScopeConfigInterface $scopeConfig,
        protected LoggerInterface      $logger
    ) {
    }

    public function isEnabled(): bool
    {
        try {
            return $this->scopeConfig->getValue(ConfigInterface::CATALOG_IMAGE_SLIDESHOW_ENABLED_PATH);
        } catch (Throwable $e) {
            $this->logger->error('Error getting slideshow enabled config: ' . $e->getMessage());
            return false;
        }

    }
}