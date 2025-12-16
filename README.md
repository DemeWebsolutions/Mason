# Stone Mason - Block-First WordPress System

**Stone Mason (Mason Core Builder)** is a proprietary, block-first hybrid WordPress system by [DemeWebsolutions.com](https://demewebsolutions.com) for Apple-style WooCommerce sites.

## 🎯 Overview

Stone Mason is built for high-performance e-commerce experiences with:

- ✅ **TT5-compatible child theme** - Extends Twenty Twenty-Five
- ✅ **Centralized theme.json** - Full-site editing configuration
- ✅ **Native Gutenberg only** - No page builders or shortcodes
- ✅ **Custom PHP/React blocks** - Modular, reusable components
- ✅ **WooCommerce Blocks** - Modern e-commerce without legacy code
- ✅ **Clean semantic HTML** - Accessibility-first markup
- ✅ **Minimal scripts** - Performance-optimized JavaScript
- ✅ **Optional GSAP** - Professional animations when needed
- ✅ **95+ Lighthouse scores** - Strict performance rules
- ✅ **Zero vendor lock-in** - Standards-based, portable code

## 📋 Requirements

- **WordPress**: 6.4 or higher
- **PHP**: 8.0 or higher
- **Node.js**: 18.0 or higher (for block development)
- **npm**: 9.0 or higher
- **Parent Theme**: Twenty Twenty-Five (twentytwentyfive)
- **WooCommerce**: 8.0+ (optional, but recommended)

## 🚀 Quick Start

### Installation

1. **Install Parent Theme**
   ```bash
   # Install Twenty Twenty-Five through WordPress admin
   # Or download from wordpress.org/themes/twentytwentyfive
   ```

2. **Install Stone Mason**
   ```bash
   cd wp-content/themes
   git clone https://github.com/DemeWebsolutions/Mason.git stone-mason
   cd stone-mason
   ```

3. **Install Dependencies**
   ```bash
   npm install
   ```

4. **Build Blocks**
   ```bash
   npm run build
   ```

5. **Activate Theme**
   - Go to WordPress Admin → Appearance → Themes
   - Activate "Stone Mason"

### Development Mode

For active block development:

```bash
npm run start
```

This watches for changes and rebuilds blocks automatically.

## 📁 Directory Structure

```
stone-mason/
├── assets/              # Static assets
│   ├── css/            # Additional stylesheets
│   └── js/             # JavaScript files
│       └── main.js     # Main theme script
├── blocks/             # Custom blocks
│   ├── php/            # PHP-rendered blocks
│   │   ├── hero-section/
│   │   └── product-card/
│   ├── src/            # React block source
│   │   └── product-card/
│   └── build/          # Compiled blocks (gitignored)
├── inc/                # PHP includes
│   ├── block-patterns.php
│   ├── performance.php
│   └── woocommerce.php
├── languages/          # Translation files
├── patterns/           # Block patterns
├── parts/              # Template parts
├── templates/          # Block templates
├── functions.php       # Theme functions
├── style.css           # Theme stylesheet
├── theme.json          # Theme configuration
├── package.json        # Node dependencies
└── README.md          # This file
```

## 🧱 Custom Blocks

### PHP Blocks

**Hero Section** (`stone-mason/hero-section`)
- Server-rendered hero banner
- Customizable heading, subheading, and CTA
- Full alignment support

### React Blocks

**Product Card** (`stone-mason/product-card`)
- WooCommerce product display
- Apple-inspired design
- Semantic HTML with schema markup
- Performance-optimized

### Creating New Blocks

1. **React Blocks**:
   ```bash
   # Create new block directory
   mkdir -p blocks/src/my-block
   
   # Add block files
   # - block.json (block metadata)
   # - index.js (React component)
   # - style.css (frontend styles)
   # - editor.css (editor styles)
   
   # Update webpack.config.js entry points
   # Run build
   npm run build
   ```

2. **PHP Blocks**:
   ```php
   // Create in blocks/php/my-block/block.php
   // Use register_block_type() with render_callback
   // Include in functions.php
   ```

## 🎨 Theme Configuration

### theme.json

Centralized configuration for:
- Color palette (Apple-inspired)
- Typography (system fonts)
- Spacing scale
- Layout settings
- Block-specific settings

### Customization

Edit `theme.json` for global changes:

```json
{
  "settings": {
    "color": {
      "palette": [
        {
          "slug": "primary",
          "color": "#0071e3",
          "name": "Primary"
        }
      ]
    }
  }
}
```

## 🛍️ WooCommerce Integration

Stone Mason is optimized for WooCommerce with:

- **WooCommerce Blocks** - Modern block-based shop pages
- **Optimized Performance** - Selective script loading
- **Custom Product Displays** - Apple-style product cards
- **Semantic Markup** - SEO-friendly product schema
- **Accessibility** - WCAG 2.1 AA compliant

### WooCommerce Setup

1. Install WooCommerce plugin
2. Run WooCommerce setup wizard
3. Stone Mason automatically enables WooCommerce Blocks support
4. Use block editor to build shop pages

## ⚡ Performance Features

### Built-in Optimizations

- **Minimal Scripts**: Only essential JavaScript loaded
- **Deferred Loading**: Scripts loaded with `defer` strategy
- **Lazy Loading**: Images and iframes lazy-loaded
- **Critical CSS**: Inline critical CSS for above-fold content
- **Font Optimization**: System font stack (zero web font overhead)
- **Resource Hints**: DNS prefetch and preconnect
- **Clean Head**: Removed unnecessary WordPress meta tags
- **Optimized WooCommerce**: Disabled unnecessary WooCommerce scripts

### Optional GSAP

Enable GSAP animations:

```php
// In functions.php or child theme
add_filter( 'stone_mason_load_gsap', '__return_true' );
```

### Performance Checklist

- [ ] Use WebP/AVIF images
- [ ] Implement caching (plugin or server-level)
- [ ] Use CDN for static assets
- [ ] Enable Gzip/Brotli compression
- [ ] Minify CSS/JS in production
- [ ] Optimize database queries
- [ ] Monitor Core Web Vitals

## 🎯 Target: 95+ Lighthouse Score

Stone Mason is built to achieve:

- **Performance**: 95+
- **Accessibility**: 100
- **Best Practices**: 100
- **SEO**: 100

### Tips for Best Scores

1. **Images**: Use next-gen formats with proper dimensions
2. **Caching**: Implement browser and server caching
3. **CDN**: Serve static assets from CDN
4. **Lazy Load**: Let blocks handle lazy loading
5. **Minimize Plugins**: Fewer plugins = better performance

## 🔐 Security

- PHP 8.0+ for modern security features
- Sanitized inputs and escaped outputs
- No inline JavaScript (CSP-friendly)
- Version numbers removed from assets
- Follows WordPress coding standards

## ♿ Accessibility

- Semantic HTML5 markup
- ARIA labels where appropriate
- Keyboard navigation support
- Screen reader friendly
- Focus management
- Skip links for navigation
- Color contrast compliance

## 🌍 Translation Ready

Stone Mason is translation-ready:

```bash
# Generate POT file
wp i18n make-pot . languages/stone-mason.pot

# Add translations in languages/ directory
# - stone-mason-es_ES.po
# - stone-mason-fr_FR.po
```

## 🛠️ Development

### NPM Scripts

```bash
npm run build        # Build for production
npm run start        # Development mode (watch)
npm run lint:js      # Lint JavaScript
npm run lint:css     # Lint CSS
npm run format       # Format code
npm run packages-update  # Update WordPress packages
```

### Coding Standards

- **PHP**: WordPress Coding Standards
- **JavaScript**: WordPress JavaScript Standards (ESLint)
- **CSS**: WordPress CSS Standards (Stylelint)

## 📝 Block Patterns

Pre-built patterns available:

- **Hero Section**: Full-width hero banner
- **Product Showcase**: Product feature section
- **Feature Grid**: Three-column feature display

Access in Block Editor → Patterns → Stone Mason

## 🎨 Design Philosophy

Stone Mason follows Apple's design principles:

- **Simplicity**: Clean, uncluttered interfaces
- **Clarity**: Clear typography and hierarchy
- **Depth**: Subtle shadows and elevation
- **Motion**: Purposeful, smooth animations
- **Delight**: Thoughtful interactions

## 📊 Browser Support

- **Modern Browsers**: Chrome, Firefox, Safari, Edge (latest 2 versions)
- **Mobile**: iOS Safari 12+, Chrome Android
- **Progressive Enhancement**: Core functionality works without JavaScript

## 🤝 Support

For support and updates:

- **Website**: [DemeWebsolutions.com](https://demewebsolutions.com)
- **Issues**: GitHub Issues (for bugs and feature requests)
- **Documentation**: This README and inline code comments

## 📄 License

Proprietary - © DemeWebsolutions.com

This theme is proprietary software. All rights reserved.

## 🎉 Credits

- **Framework**: WordPress & Gutenberg
- **Parent Theme**: Twenty Twenty-Five
- **E-commerce**: WooCommerce
- **Build Tools**: @wordpress/scripts
- **Animation**: GSAP (optional)

## 🔄 Changelog

### 1.0.0 (2025-12-16)
- Initial release
- TT5-compatible child theme
- Custom PHP and React blocks
- WooCommerce Blocks integration
- Performance optimizations
- Block patterns library
- Centralized theme.json
- Accessibility compliance
- Zero vendor lock-in architecture

---

**Built with ❤️ by DemeWebsolutions.com**
