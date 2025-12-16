# Stone Mason Development Guide

## Getting Started with Block Development

### Prerequisites

1. **Local WordPress Development Environment**
   - Local by Flywheel
   - XAMPP/MAMP
   - Docker (wordpress:latest)

2. **Node.js & npm**
   ```bash
   node --version  # Should be 18+
   npm --version   # Should be 9+
   ```

3. **Code Editor**
   - VS Code (recommended)
   - PHPStorm
   - Sublime Text

### Setting Up Development

```bash
# Clone the repository
cd wp-content/themes
git clone https://github.com/DemeWebsolutions/Mason.git stone-mason
cd stone-mason

# Install dependencies
npm install

# Start development mode
npm run start
```

## Creating Custom Blocks

### React Block Example

```javascript
// blocks/src/my-block/index.js
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps } from '@wordpress/block-editor';

registerBlockType('stone-mason/my-block', {
    edit: () => {
        const blockProps = useBlockProps();
        return <div {...blockProps}>My Block</div>;
    },
    save: () => {
        const blockProps = useBlockProps.save();
        return <div {...blockProps}>My Block</div>;
    }
});
```

### PHP Block Example

```php
// blocks/php/my-block/block.php
register_block_type('stone-mason/my-block', array(
    'render_callback' => function($attributes) {
        return '<div class="my-block">Content</div>';
    }
));
```

## Performance Best Practices

### Image Optimization

```php
// Always specify image sizes
wp_get_attachment_image($id, 'mason-product-large');

// Use lazy loading
<img loading="lazy" src="..." alt="...">

// Add fetchpriority for hero images
<img fetchpriority="high" src="..." alt="...">
```

### Script Loading

```php
// Defer non-critical scripts
wp_enqueue_script('my-script', $url, array(), '1.0', array(
    'strategy' => 'defer',
    'in_footer' => true
));

// Conditional loading
if (is_product()) {
    wp_enqueue_script('product-viewer');
}
```

### CSS Optimization

```css
/* Use CSS variables from theme.json */
color: var(--wp--preset--color--primary);
padding: var(--wp--preset--spacing--40);

/* Minimize specificity */
.mason-card { } /* Good */
.mason-component .inner .wrapper .card { } /* Bad */
```

## WooCommerce Development

### Custom Product Template

```php
// templates/single-product.html
<!-- wp:template-part {"slug":"header"} /-->

<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">
    <!-- Product content -->
</div>
<!-- /wp:group -->

<!-- wp:template-part {"slug":"footer"} /-->
```

### Product Query Block

```html
<!-- wp:query {"queryId":1,"query":{"postType":"product"}} -->
<div class="wp-block-query">
    <!-- wp:post-template -->
        <!-- wp:stone-mason/product-card /-->
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->
```

## Testing

### Browser Testing

Test in:
- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile Safari (iOS)
- Chrome Mobile (Android)

### Performance Testing

```bash
# Lighthouse CLI
npx lighthouse https://your-site.test --view

# PageSpeed Insights
# Visit: https://pagespeed.web.dev/

# WebPageTest
# Visit: https://www.webpagetest.org/
```

### Accessibility Testing

```bash
# aXe DevTools
# Install browser extension

# Wave
# Visit: https://wave.webaim.org/
```

## Debugging

### Enable WP_DEBUG

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
```

### Browser DevTools

```javascript
// Debug block editor
wp.data.select('core/block-editor').getBlocks();

// Debug WooCommerce
console.log(wc_cart_fragments_params);
```

## Deployment

### Production Build

```bash
# Build optimized assets
npm run build

# Remove development files
rm -rf node_modules
rm -rf blocks/src
rm package.json
rm webpack.config.js
```

### Production Checklist

- [ ] Build blocks with `npm run build`
- [ ] Remove `node_modules/`
- [ ] Enable caching
- [ ] Minify assets
- [ ] Optimize images
- [ ] Test all forms
- [ ] Check mobile responsiveness
- [ ] Run Lighthouse audit
- [ ] Test checkout flow (WooCommerce)
- [ ] Verify SSL certificate
- [ ] Set up monitoring

## Troubleshooting

### Blocks Not Showing

1. Check WordPress version (6.4+)
2. Verify parent theme is active (Twenty Twenty-Five)
3. Clear WordPress cache
4. Rebuild blocks: `npm run build`

### JavaScript Errors

1. Check browser console
2. Verify script dependencies
3. Clear browser cache
4. Check WP_DEBUG log

### Styling Issues

1. Clear CSS cache
2. Regenerate theme.json
3. Check CSS specificity
4. Verify block wrapper classes

## Resources

### WordPress

- [Block Editor Handbook](https://developer.wordpress.org/block-editor/)
- [Theme Handbook](https://developer.wordpress.org/themes/)
- [Coding Standards](https://developer.wordpress.org/coding-standards/)

### WooCommerce

- [WooCommerce Docs](https://woocommerce.com/documentation/)
- [WooCommerce Blocks](https://github.com/woocommerce/woocommerce-blocks)

### Tools

- [@wordpress/scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [GSAP Docs](https://greensock.com/docs/)

## Contributing

When contributing:

1. Follow WordPress coding standards
2. Write semantic HTML
3. Ensure accessibility (WCAG 2.1 AA)
4. Test in multiple browsers
5. Document your code
6. Keep performance in mind
7. Write clean, readable code

---

**Happy Coding! 🚀**
