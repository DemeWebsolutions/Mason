# Stone Mason Accessibility Guide

## 🎯 WCAG 2.1 AA Compliance

Stone Mason is built with accessibility as a core principle, targeting **WCAG 2.1 Level AA** compliance.

## Key Accessibility Features

### ✅ Semantic HTML

Stone Mason uses proper HTML5 semantic elements:

```html
<!-- Good: Semantic structure -->
<article>
  <header>
    <h1>Product Title</h1>
  </header>
  <section>
    <p>Description</p>
  </section>
  <footer>
    <button>Add to Cart</button>
  </footer>
</article>

<!-- Bad: Non-semantic structure -->
<div class="product">
  <div class="header">
    <div class="title">Product Title</div>
  </div>
</div>
```

### ✅ ARIA Labels

Proper ARIA attributes for enhanced screen reader support:

```html
<!-- Navigation -->
<nav aria-label="Main Navigation">
  <ul role="list">
    <li role="listitem">
      <a href="/" aria-current="page">Home</a>
    </li>
  </ul>
</nav>

<!-- Buttons -->
<button 
  aria-label="Add Product to Cart"
  aria-describedby="product-title"
>
  Add to Cart
</button>

<!-- Form Fields -->
<label for="email">
  Email Address
  <span aria-label="required">*</span>
</label>
<input 
  type="email" 
  id="email" 
  aria-required="true"
  aria-invalid="false"
>
```

### ✅ Keyboard Navigation

All interactive elements are keyboard accessible:

```css
/* Visible focus indicators */
a:focus,
button:focus,
input:focus {
  outline: 2px solid #0071e3;
  outline-offset: 2px;
}

/* Focus within */
.product-card:focus-within {
  box-shadow: 0 0 0 3px rgba(0, 113, 227, 0.3);
}
```

**Keyboard Shortcuts:**
- `Tab` - Navigate forward
- `Shift + Tab` - Navigate backward
- `Enter` - Activate buttons/links
- `Space` - Activate buttons/checkboxes
- `Esc` - Close modals/dropdowns
- Arrow keys - Navigate lists/menus

### ✅ Screen Reader Support

Screen reader-only text for important context:

```html
<!-- Hidden text for screen readers -->
<span class="screen-reader-text">
  Price: $99.99
</span>

<!-- Skip links -->
<a href="#main-content" class="screen-reader-text">
  Skip to main content
</a>
```

```css
.screen-reader-text {
  clip: rect(1px, 1px, 1px, 1px);
  clip-path: inset(50%);
  height: 1px;
  width: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  word-wrap: normal !important;
}

.screen-reader-text:focus {
  background-color: #f1f1f1;
  border-radius: 3px;
  box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.6);
  clip: auto !important;
  clip-path: none;
  color: #21759b;
  display: block;
  font-size: 0.875rem;
  font-weight: 700;
  height: auto;
  left: 5px;
  line-height: normal;
  padding: 15px 23px 14px;
  text-decoration: none;
  top: 5px;
  width: auto;
  z-index: 100000;
}
```

### ✅ Color Contrast

All text meets WCAG AA contrast requirements (4.5:1 for normal text, 3:1 for large text):

**Default Palette:**
- Primary (#0071e3) on white: 4.58:1 ✅
- Black (#000000) on white: 21:1 ✅
- Secondary (#86868b) on white: 4.54:1 ✅

**Testing Tools:**
- Chrome DevTools Accessibility Panel
- WebAIM Contrast Checker
- Lighthouse Accessibility Audit

### ✅ Form Accessibility

```html
<!-- Accessible form structure -->
<form aria-label="Product Search">
  <div class="form-field">
    <label for="search-input">
      Search Products
      <span class="required" aria-label="required">*</span>
    </label>
    <input 
      type="search" 
      id="search-input"
      name="s"
      aria-required="true"
      aria-describedby="search-help"
      autocomplete="off"
    >
    <p id="search-help" class="help-text">
      Enter product name or SKU
    </p>
  </div>
  
  <!-- Error state -->
  <div class="form-field" aria-invalid="true">
    <label for="email">Email</label>
    <input 
      type="email" 
      id="email"
      aria-invalid="true"
      aria-describedby="email-error"
    >
    <p id="email-error" class="error-text" role="alert">
      Please enter a valid email address
    </p>
  </div>
  
  <button type="submit">
    <span aria-hidden="true">🔍</span>
    <span>Search</span>
  </button>
</form>
```

### ✅ Image Accessibility

```html
<!-- Decorative images -->
<img src="decorative.jpg" alt="" role="presentation">

<!-- Informative images -->
<img 
  src="product.jpg" 
  alt="Blue cotton t-shirt with round neck"
  width="800"
  height="800"
>

<!-- Complex images -->
<figure>
  <img 
    src="chart.jpg" 
    alt="Sales chart"
    aria-describedby="chart-description"
  >
  <figcaption id="chart-description">
    Bar chart showing sales increased 25% in Q4
  </figcaption>
</figure>

<!-- Background images with content -->
<div 
  style="background-image: url(hero.jpg);"
  role="img"
  aria-label="Mountain landscape at sunset"
>
  <h1>Welcome to Stone Mason</h1>
</div>
```

### ✅ WooCommerce Accessibility

```html
<!-- Product card -->
<article 
  class="mason-product-card" 
  itemscope 
  itemtype="http://schema.org/Product"
>
  <h3 itemprop="name">
    <a href="/product/example">Product Name</a>
  </h3>
  
  <div 
    class="price" 
    itemprop="offers" 
    itemscope 
    itemtype="http://schema.org/Offer"
  >
    <span class="screen-reader-text">Price:</span>
    <meta itemprop="price" content="99.99">
    <meta itemprop="priceCurrency" content="USD">
    $99.99
  </div>
  
  <button 
    type="button"
    aria-label="Add Product Name to cart"
  >
    <span aria-hidden="true">🛒</span>
    Add to Cart
  </button>
</article>

<!-- Cart quantity -->
<div class="quantity">
  <label for="quantity">Quantity</label>
  <button 
    type="button" 
    aria-label="Decrease quantity"
  >
    −
  </button>
  <input 
    type="number" 
    id="quantity"
    value="1"
    min="1"
    aria-label="Product quantity"
  >
  <button 
    type="button" 
    aria-label="Increase quantity"
  >
    +
  </button>
</div>
```

## Testing Checklist

### Manual Testing

- [ ] **Keyboard Navigation**
  - Tab through all interactive elements
  - Verify visible focus indicators
  - Test all keyboard shortcuts
  - Ensure logical tab order

- [ ] **Screen Reader Testing**
  - NVDA (Windows - Free)
  - JAWS (Windows - Commercial)
  - VoiceOver (macOS/iOS - Built-in)
  - TalkBack (Android - Built-in)

- [ ] **Zoom & Text Resize**
  - Test at 200% browser zoom
  - Test with text-only zoom
  - Verify no horizontal scrolling
  - Check line length (45-75 characters)

- [ ] **Color & Contrast**
  - Test with grayscale mode
  - Verify contrast ratios
  - Check color-blind simulation
  - Ensure information isn't color-only

### Automated Testing Tools

#### Browser Extensions

**axe DevTools** (Recommended)
```bash
# Install Chrome extension
# Run audit on any page
# Fix reported issues
```

**WAVE**
```bash
# Install extension or visit wave.webaim.org
# Analyze page accessibility
# Review errors and warnings
```

**Lighthouse**
```bash
npx lighthouse https://your-site.com --only-categories=accessibility
```

#### Command Line

```bash
# Pa11y
npx pa11y https://your-site.com

# aXe-core CLI
npx axe https://your-site.com
```

### Common Issues & Fixes

#### Issue: Missing Alt Text

**Problem:**
```html
<img src="product.jpg">
```

**Solution:**
```html
<img src="product.jpg" alt="Blue cotton t-shirt">
```

#### Issue: Low Contrast

**Problem:**
```css
color: #999; /* on white background - 2.85:1 ❌ */
```

**Solution:**
```css
color: #767676; /* on white background - 4.54:1 ✅ */
```

#### Issue: Non-Semantic Markup

**Problem:**
```html
<div onclick="handleClick()">Click me</div>
```

**Solution:**
```html
<button type="button" onclick="handleClick()">Click me</button>
```

#### Issue: Missing Form Labels

**Problem:**
```html
<input type="text" placeholder="Email">
```

**Solution:**
```html
<label for="email">Email</label>
<input type="text" id="email" placeholder="you@example.com">
```

## Accessibility Resources

### Official Guidelines

- [WCAG 2.1](https://www.w3.org/WAI/WCAG21/quickref/)
- [WordPress Accessibility](https://make.wordpress.org/accessibility/)
- [WooCommerce Accessibility](https://woocommerce.com/document/accessibility/)

### Testing Tools

- [axe DevTools](https://www.deque.com/axe/devtools/)
- [WAVE](https://wave.webaim.org/)
- [Lighthouse](https://developers.google.com/web/tools/lighthouse)
- [Pa11y](https://pa11y.org/)

### Design Resources

- [WebAIM Contrast Checker](https://webaim.org/resources/contrastchecker/)
- [Color Oracle](https://colororacle.org/) - Color blindness simulator
- [Who Can Use](https://whocanuse.com/) - Contrast calculator

### Learning

- [WebAIM Articles](https://webaim.org/articles/)
- [A11y Project](https://www.a11yproject.com/)
- [Inclusive Components](https://inclusive-components.design/)

## Best Practices

1. **Start Accessible**
   - Build with accessibility from the beginning
   - Don't retrofit accessibility later
   - Use semantic HTML by default

2. **Test Early & Often**
   - Test during development
   - Use automated tools
   - Perform manual testing
   - Test with real users

3. **Progressive Enhancement**
   - Core functionality works without JS
   - Enhance with JavaScript
   - Graceful degradation
   - No-JS fallbacks

4. **Inclusive Design**
   - Design for diverse abilities
   - Consider different contexts
   - Think beyond disabilities
   - Universal usability

5. **Continuous Improvement**
   - Monitor accessibility issues
   - Stay updated on guidelines
   - Gather user feedback
   - Regular audits

## Accessibility Statement

Stone Mason is committed to ensuring digital accessibility for people with disabilities. We continually improve the user experience for everyone and apply the relevant accessibility standards.

### Conformance Status

Stone Mason aims to conform to WCAG 2.1 Level AA standards.

### Feedback

We welcome your feedback on the accessibility of Stone Mason. Please contact us if you encounter accessibility barriers:

- Email: accessibility@demewebsolutions.com
- Report issues on GitHub

We try to respond to feedback within 2 business days.

---

**Accessibility is not a feature, it's a fundamental right! ♿**
