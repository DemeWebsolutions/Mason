# Stone Mason Performance Guide

## 🎯 Target: 95+ Lighthouse Score

Stone Mason is architected for exceptional performance. This guide helps you maintain and optimize your Lighthouse scores.

## Performance Architecture

### Built-in Optimizations

✅ **Minimal JavaScript**
- Only essential scripts loaded
- Deferred loading strategy
- Conditional script enqueueing
- No jQuery dependency

✅ **Optimized CSS**
- System font stack (zero web font overhead)
- Critical CSS inline
- Block-specific styling
- Minimal CSS specificity

✅ **Image Optimization**
- Lazy loading by default
- Proper image sizing
- fetchpriority for hero images
- WebP/AVIF support ready

✅ **Clean HTML**
- Semantic markup
- Minimal DOM nodes
- No unnecessary wrappers
- ARIA labels where needed

✅ **WooCommerce Optimization**
- Selective script loading
- Disabled cart fragments on non-shop pages
- Optimized product queries
- Block-based rendering

## Core Web Vitals

### Largest Contentful Paint (LCP)

**Target: < 2.5s**

Optimizations:
- Hero images use `fetchpriority="high"`
- System fonts eliminate FOUT
- Minimal render-blocking resources
- Image dimensions specified

```php
// Priority loading for hero images
add_filter('wp_get_attachment_image_attributes', function($attr) {
    static $first_image = true;
    if ($first_image && is_singular()) {
        $attr['fetchpriority'] = 'high';
        $first_image = false;
    }
    return $attr;
}, 10, 3);
```

### First Input Delay (FID)

**Target: < 100ms**

Optimizations:
- Scripts loaded with defer
- Minimal JavaScript execution
- No long tasks blocking main thread
- requestIdleCallback for non-critical tasks

### Cumulative Layout Shift (CLS)

**Target: < 0.1**

Optimizations:
- Image dimensions specified
- Font loading optimized
- No dynamic content injection
- Proper spacing reservations

```html
<!-- Good: Dimensions specified -->
<img src="image.jpg" width="800" height="600" alt="...">

<!-- Bad: No dimensions -->
<img src="image.jpg" alt="...">
```

## Optimization Checklist

### Images

- [ ] Use next-gen formats (WebP, AVIF)
- [ ] Specify width and height attributes
- [ ] Use appropriate image sizes
- [ ] Enable lazy loading
- [ ] Compress images (80-85% quality)
- [ ] Use CDN for image delivery

```bash
# Convert to WebP
for img in *.jpg; do
    cwebp -q 85 "$img" -o "${img%.jpg}.webp"
done
```

### Scripts

- [ ] Load scripts with defer
- [ ] Minify JavaScript in production
- [ ] Remove unused JavaScript
- [ ] Inline critical scripts
- [ ] Use module/nomodule pattern

```html
<!-- Modern browsers -->
<script type="module" src="modern.js"></script>

<!-- Legacy browsers -->
<script nomodule src="legacy.js"></script>
```

### CSS

- [ ] Inline critical CSS
- [ ] Load non-critical CSS async
- [ ] Minify CSS in production
- [ ] Remove unused CSS
- [ ] Use CSS containment

```html
<!-- Critical CSS inline -->
<style id="critical-css">
    /* Above-the-fold styles */
</style>

<!-- Non-critical async -->
<link rel="preload" href="styles.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
```

### Fonts

- [ ] Use system fonts (default)
- [ ] If custom fonts: use font-display: swap
- [ ] Preload custom fonts
- [ ] Subset fonts
- [ ] Use variable fonts

```css
/* System font stack (Stone Mason default) */
font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;

/* Custom fonts (if needed) */
@font-face {
    font-family: 'CustomFont';
    src: url('font.woff2') format('woff2');
    font-display: swap;
}
```

### Caching

- [ ] Enable browser caching
- [ ] Set proper cache headers
- [ ] Use service worker
- [ ] Implement edge caching (CDN)
- [ ] Cache WordPress queries

```apache
# .htaccess
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/webp "access plus 1 year"
    ExpiresByType text/css "access plus 1 year"
    ExpiresByType text/javascript "access plus 1 year"
</IfModule>
```

### Server

- [ ] Enable Gzip/Brotli compression
- [ ] Use HTTP/2 or HTTP/3
- [ ] Optimize server response time
- [ ] Use CDN for static assets
- [ ] Enable Redis/Memcached

```nginx
# nginx.conf
gzip on;
gzip_types text/css text/javascript application/javascript;
gzip_min_length 1000;
```

## WooCommerce Specific

### Product Pages

```php
// Disable unnecessary features
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

// Optimize product gallery
add_filter('woocommerce_gallery_thumbnail_size', function() {
    return 'mason-product-thumb';
});
```

### Cart Optimization

```php
// Disable cart fragments on non-shop pages
add_action('wp_enqueue_scripts', function() {
    if (!is_cart() && !is_checkout()) {
        wp_dequeue_script('wc-cart-fragments');
    }
}, 100);
```

### Checkout Optimization

- Use WooCommerce Blocks
- Minimize checkout fields
- Enable guest checkout
- Optimize payment gateway scripts
- Cache shipping calculations

## Monitoring Tools

### Lighthouse

```bash
# CLI
npx lighthouse https://your-site.com --view

# CI/CD Integration
npx lighthouse https://your-site.com --output=json --output-path=./lighthouse.json
```

### PageSpeed Insights

Visit: https://pagespeed.web.dev/

### WebPageTest

Visit: https://www.webpagetest.org/

### Chrome DevTools

1. Open DevTools (F12)
2. Performance tab
3. Record page load
4. Analyze metrics

## Common Issues & Solutions

### Issue: Large JavaScript Bundle

**Solution:**
- Code splitting
- Dynamic imports
- Tree shaking
- Remove unused dependencies

### Issue: Render-Blocking Resources

**Solution:**
- Inline critical CSS
- Defer non-critical JavaScript
- Preload key resources
- Use resource hints

### Issue: Large Images

**Solution:**
- Compress images
- Use responsive images
- Implement lazy loading
- Use next-gen formats

### Issue: Third-Party Scripts

**Solution:**
- Load asynchronously
- Use facade pattern
- Delay until interaction
- Self-host if possible

## Performance Budget

Set and monitor performance budgets:

```json
{
  "budgets": [
    {
      "resourceSizes": [
        { "resourceType": "script", "budget": 150 },
        { "resourceType": "image", "budget": 350 },
        { "resourceType": "stylesheet", "budget": 50 },
        { "resourceType": "total", "budget": 600 }
      ]
    }
  ]
}
```

## Best Practices

1. **Test on Real Devices**
   - Use real mobile devices
   - Test on slow 3G
   - Test on low-end devices

2. **Monitor Regularly**
   - Weekly Lighthouse audits
   - Track Core Web Vitals
   - Monitor field data (CrUX)

3. **Progressive Enhancement**
   - Core functionality without JS
   - Enhance with JavaScript
   - Graceful degradation

4. **Continuous Optimization**
   - Regular dependency updates
   - Remove unused code
   - Optimize new features
   - A/B test performance changes

## Resources

- [Web.dev Performance](https://web.dev/performance/)
- [Lighthouse Docs](https://developer.chrome.com/docs/lighthouse/)
- [WooCommerce Performance](https://woocommerce.com/document/woocommerce-performance/)
- [WordPress Performance](https://make.wordpress.org/core/handbook/testing/reporting-performance-bugs/)

---

**Remember: Performance is a feature, not a nice-to-have! 🚀**
