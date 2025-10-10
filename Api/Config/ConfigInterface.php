<?php
declare(strict_types=1);

namespace AquiveMedia\CatalogImageSlideshow\Api\Config;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface
{
    public const CATALOG_IMAGE_SLIDESHOW_ENABLED_PATH = 'catalog/image_slideshow/enable';

    public function isEnabled(): bool;
}