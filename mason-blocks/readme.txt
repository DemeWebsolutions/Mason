=== Mason Blocks ===
Contributors: demewebsolutions
Tags: blocks, gutenberg, woocommerce, apple, performance
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 1.0.0
License: Proprietary
License URI: https://demewebsolutions.com/license

Custom Gutenberg blocks for the Mason theme with Apple-inspired design and WooCommerce integration.

== Description ==

Mason Blocks is a companion plugin for the Mason theme that provides 8 custom Gutenberg blocks optimized for Apple-style WooCommerce sites.

= Features =

* 8 Custom Blocks for complete site building
* Apple-inspired design system
* Deep WooCommerce integration
* Server-side rendering for performance
* WCAG 2.1 AA accessible markup
* Semantic HTML5 output
* Responsive design
* Zero vendor lock-in

= Included Blocks =

1. **Hero Section** - Product headline with imagery and CTA
2. **Feature Grid** - 2-3 column feature highlights
3. **Product Spotlight** - WooCommerce product focus display
4. **Sticky Buy Bar** - Floating add-to-cart bar
5. **Specs Table** - Technical specifications display
6. **Section Divider** - Visual section separation
7. **Product Card (PHP)** - Server-rendered product display
8. **Product Card (React)** - Interactive product display

= Requirements =

* WordPress 6.4+
* PHP 8.0+
* Mason theme (recommended)
* WooCommerce 8.0+ (for product blocks)

= Performance =

All blocks are optimized for performance with:
* Server-side rendering
* Lazy loading support
* Minimal JavaScript
* Efficient CSS
* 95+ Lighthouse score target

== Installation ==

1. Upload the `mason-blocks` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Blocks will appear in the 'Mason' category in the block inserter

== Frequently Asked Questions ==

= Does this work without the Mason theme? =

Yes, Mason Blocks works with any WordPress theme, but it's optimized for the Mason theme.

= Do I need WooCommerce? =

WooCommerce is only required for product-related blocks (Product Spotlight, Sticky Buy Bar, Product Card). Other blocks work without it.

= Is this compatible with Gutenberg? =

Yes, Mason Blocks uses the native WordPress Block Editor (Gutenberg) and is fully compatible.

= Can I customize the blocks? =

Yes, each block includes customization options in the block settings panel.

== Screenshots ==

1. Hero Section block in action
2. Feature Grid with 3 columns
3. Product Spotlight layout
4. Sticky Buy Bar on scroll
5. Specs Table display
6. Block inserter showing Mason category

== Changelog ==

= 1.0.0 =
* Initial release
* 8 custom blocks
* Complete WooCommerce integration
* Performance optimizations
* Accessibility features

== Upgrade Notice ==

= 1.0.0 =
Initial release of Mason Blocks plugin.

== Developer Notes ==

= Building Blocks =

```bash
npm install
npm run build
```

= Watch Mode =

```bash
npm run start
```

= Block Structure =

All blocks are located in `/blocks/` directory:
* PHP blocks: `/blocks/{block-name}/block.php`
* React blocks: `/blocks/src/{block-name}/`

== Credits ==

* Developed by DemeWebsolutions.com
* Part of the Mason ecosystem
* Built with @wordpress/scripts

== Support ==

For support and documentation, visit https://demewebsolutions.com
