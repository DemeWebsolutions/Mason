# Mason Blocks

**Custom Gutenberg blocks for the Mason theme**

Part of Stone Mason Core - a Blocksy-like enhancement system for WordPress.

## Overview

Mason Blocks is a companion plugin for the Mason theme that provides custom Gutenberg blocks optimized for Apple-style WooCommerce sites.

## Features

- **8 Custom Blocks**: Hero Section, Feature Grid, Product Spotlight, Sticky Buy Bar, Specs Table, Section Divider, and Product Cards
- **Performance Optimized**: Server-side rendering for optimal speed
- **WooCommerce Integration**: Deep integration with WooCommerce Blocks
- **Accessibility**: WCAG 2.1 AA compliant markup
- **Semantic HTML**: Clean, standards-based output
- **Apple-Inspired Design**: Clean aesthetics matching Apple.com

## Installation

1. Upload the `mason-blocks` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. The blocks will be available in the Mason block category

## Requirements

- WordPress 6.4+
- PHP 8.0+
- Mason theme (recommended)
- WooCommerce 8.0+ (for product-related blocks)

## Blocks Included

### Hero Section
Product headline with imagery and customizable CTA button.

### Feature Grid
2-3 column feature highlights with icon/emoji support.

### Product Spotlight
WooCommerce product focus block with flexible image layouts.

### Sticky Buy Bar
Floating add-to-cart bar that appears on scroll.

### Specs Table
Technical specifications display with striped rows option.

### Section Divider
Visual separation with multiple styles (line, space, dots).

### Product Card (React)
Interactive WooCommerce product display with schema.org markup.

## Development

### Building Blocks

```bash
npm install
npm run build
```

### Watch Mode

```bash
npm run start
```

## Styling

All blocks are styled via `/assets/css/blocks.css` which is automatically enqueued when the plugin is active.

## Compatibility

- Works with Mason theme
- Compatible with Twenty Twenty-Five
- WooCommerce Blocks integration
- No shortcode dependencies
- Zero vendor lock-in

## Support

For support and updates:
- Website: https://demewebsolutions.com
- Documentation: See Mason theme documentation

## License

Proprietary - © DemeWebsolutions.com

---

**Part of the Mason ecosystem**
