# Hyvä Catalog Image Slideshow

A Magento 2 module that adds an interactive image slideshow to product listings on category pages. Built specifically for Hyvä themes.

![Magento](https://img.shields.io/badge/Magento-2.4+-orange)
![Hyvä](https://img.shields.io/badge/Hyvä-^1.2.3-blue)
![PHP](https://img.shields.io/badge/PHP-8.1+-blue)

## Features

- **Interactive Slideshow** - Hover over product images to browse gallery
- **Performance Optimized** - Lazy loading with viewport detection
- **Visual Indicators** - Dots show current image and total count
- **Admin Configuration** - Enable/disable via Magento admin
- **Hyvä themes only** - Built with Alpine.js and Tailwind CSS for Hyvä

## Demo

![Slideshow Demo](./docs/assets/demo.gif)

### Features in Action
When products have multiple gallery images, users can:
- Hover horizontally across the image to switch between photos
- See visual indicators showing which image is active
- Experience instant image switching with preloaded content

## Installation

### Via Composer

```bash
composer require aquivemedia/module-hyva-catalog-image-slideshow
bin/magento setup:upgrade
bin/magento cache:clean
```

### Manual Installation

1. Download and extract to `app/code/AquiveMedia/CatalogImageSlideshow/`
2. Run installation commands:

```bash
bin/magento module:enable AquiveMedia_CatalogImageSlideshow
bin/magento setup:upgrade
bin/magento cache:clean
```

## Configuration

1. Navigate to **Admin Panel → Stores → Configuration**
2. Go to **Catalog → Category Image Slideshow**
3. Set **Enable Module** to "Yes"
4. Save configuration

## Requirements

- **Magento**: 2.4.0 or higher
- **Hyvä Theme**: 1.2.3 or higher
- **PHP**: 8.1 or higher

## How It Works

### Technical Implementation

- **Server-side**: PHP processes product gallery images using Magento's image helper
- **Client-side**: Alpine.js handles interactions and viewport-based lazy loading
- **Styling**: Tailwind CSS provides responsive design
- **Performance**: Images preload when entering viewport, cached for instant switching

## Suggestions for improvements?

This is a first version. When you have suggestions for improvements open a Github issue.

## Contributing is more then welcome

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request


## Support

For support, please submit a Github issue

---

**Made with ❤️**

