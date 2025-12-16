# Security Policy

## Supported Versions

Stone Mason follows semantic versioning. Security updates are provided for the following versions:

| Version | Supported          |
| ------- | ------------------ |
| 1.0.x   | :white_check_mark: |
| < 1.0   | :x:                |

## Reporting a Vulnerability

We take the security of Stone Mason seriously. If you discover a security vulnerability, please follow these steps:

### 1. DO NOT Disclose Publicly

Please do not create public GitHub issues for security vulnerabilities.

### 2. Report Privately

Send details to: **security@demewebsolutions.com**

Include:
- Description of the vulnerability
- Steps to reproduce
- Potential impact
- Suggested fix (if any)

### 3. Response Timeline

- **24 hours**: Initial acknowledgment
- **72 hours**: Preliminary assessment
- **7 days**: Detailed response with timeline

### 4. Coordinated Disclosure

We follow responsible disclosure:
- We'll work with you to understand the issue
- We'll develop and test a fix
- We'll release a security patch
- We'll credit you (unless you prefer to remain anonymous)

## Security Best Practices

### WordPress Installation

```php
// wp-config.php security settings

// Disable file editing from dashboard
define('DISALLOW_FILE_EDIT', true);

// Use secure authentication keys
// Generate at: https://api.wordpress.org/secret-key/1.1/salt/

// Force SSL for admin
define('FORCE_SSL_ADMIN', true);

// Disable XML-RPC if not needed
add_filter('xmlrpc_enabled', '__return_false');
```

### File Permissions

```bash
# Recommended file permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;

# wp-config.php
chmod 600 wp-config.php
```

### Server Configuration

**Apache (.htaccess)**
```apache
# Disable directory browsing
Options -Indexes

# Protect wp-config.php
<files wp-config.php>
  order allow,deny
  deny from all
</files>

# Protect .htaccess
<files .htaccess>
  order allow,deny
  deny from all
</files>

# Disable PHP execution in uploads
<Directory "/wp-content/uploads/">
  <Files "*.php">
    deny from all
  </Files>
</Directory>
```

**Nginx**
```nginx
# Protect sensitive files
location ~ /\. {
  deny all;
  access_log off;
  log_not_found off;
}

# Disable PHP in uploads
location ~* /(?:uploads|files)/.*\.php$ {
  deny all;
}

# Security headers
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header Referrer-Policy "no-referrer-when-downgrade" always;
add_header Content-Security-Policy "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval';" always;
```

## Built-in Security Features

### 1. Input Sanitization

```php
// All user inputs are sanitized
$product_id = absint( $_POST['product_id'] );
$user_email = sanitize_email( $_POST['email'] );
$user_text = sanitize_text_field( $_POST['text'] );
```

### 2. Output Escaping

```php
// All outputs are escaped
echo esc_html( $user_data );
echo esc_url( $link );
echo esc_attr( $attribute );
```

### 3. Nonce Verification

```php
// Forms use WordPress nonces
wp_nonce_field( 'stone_mason_action', 'stone_mason_nonce' );

// Verification
if ( ! wp_verify_nonce( $_POST['stone_mason_nonce'], 'stone_mason_action' ) ) {
  die( 'Security check failed' );
}
```

### 4. Capability Checks

```php
// User permission verification
if ( ! current_user_can( 'manage_options' ) ) {
  wp_die( 'Unauthorized access' );
}
```

### 5. SQL Injection Prevention

```php
// Use $wpdb->prepare() for queries
global $wpdb;
$results = $wpdb->get_results( 
  $wpdb->prepare( 
    "SELECT * FROM {$wpdb->posts} WHERE ID = %d", 
    $post_id 
  ) 
);
```

### 6. XSS Prevention

```php
// Escape output based on context
echo wp_kses_post( $content );  // For post content
echo wp_kses( $html, $allowed_tags );  // Custom allowed tags
```

### 7. CSRF Protection

```php
// All forms include nonces
check_admin_referer( 'stone_mason_action' );
```

## Security Checklist

### Development

- [ ] All inputs sanitized
- [ ] All outputs escaped
- [ ] Nonces used for forms
- [ ] Capability checks in place
- [ ] No direct file access allowed
- [ ] Prepared SQL statements
- [ ] No hardcoded credentials
- [ ] Secure random generation
- [ ] Error messages don't leak info
- [ ] Third-party libraries up-to-date

### Deployment

- [ ] HTTPS enabled (SSL/TLS)
- [ ] Strong passwords enforced
- [ ] Two-factor authentication
- [ ] Regular backups
- [ ] Security plugins installed
- [ ] WordPress core updated
- [ ] Plugins updated
- [ ] Themes updated
- [ ] PHP version current
- [ ] Database credentials secure

### Server

- [ ] Firewall configured
- [ ] Brute force protection
- [ ] Rate limiting
- [ ] Secure file permissions
- [ ] Directory browsing disabled
- [ ] PHP errors hidden
- [ ] Security headers set
- [ ] XML-RPC disabled
- [ ] Unnecessary services disabled
- [ ] Regular security audits

## Common Vulnerabilities & Prevention

### 1. SQL Injection

**Prevention:**
```php
// Bad
$wpdb->query( "SELECT * FROM users WHERE email = '{$_POST['email']}'" );

// Good
$wpdb->get_results( 
  $wpdb->prepare( "SELECT * FROM users WHERE email = %s", $_POST['email'] ) 
);
```

### 2. Cross-Site Scripting (XSS)

**Prevention:**
```php
// Bad
echo $_POST['user_input'];

// Good
echo esc_html( $_POST['user_input'] );
```

### 3. Cross-Site Request Forgery (CSRF)

**Prevention:**
```php
// Form
wp_nonce_field( 'my_action', 'my_nonce' );

// Processing
if ( ! wp_verify_nonce( $_POST['my_nonce'], 'my_action' ) ) {
  die( 'Invalid request' );
}
```

### 4. File Upload Vulnerabilities

**Prevention:**
```php
// Validate file type
$allowed_types = array('image/jpeg', 'image/png', 'image/gif');
if ( ! in_array( $_FILES['file']['type'], $allowed_types ) ) {
  die( 'Invalid file type' );
}

// Validate file size
if ( $_FILES['file']['size'] > 5 * 1024 * 1024 ) {
  die( 'File too large' );
}

// Use WordPress upload handler
$upload = wp_handle_upload( $_FILES['file'], array('test_form' => false) );
```

### 5. Authentication Bypass

**Prevention:**
```php
// Always check user capabilities
if ( ! current_user_can( 'edit_posts' ) ) {
  wp_die( 'Unauthorized' );
}

// Use WordPress authentication
if ( ! is_user_logged_in() ) {
  auth_redirect();
}
```

## Security Headers

Stone Mason sets the following security headers:

```php
// Add to functions.php or server config
add_action( 'send_headers', function() {
  header( 'X-Frame-Options: SAMEORIGIN' );
  header( 'X-Content-Type-Options: nosniff' );
  header( 'X-XSS-Protection: 1; mode=block' );
  header( 'Referrer-Policy: strict-origin-when-cross-origin' );
});
```

## Third-Party Dependencies

### Node Packages

Regularly audit npm packages:

```bash
# Check for vulnerabilities
npm audit

# Fix vulnerabilities
npm audit fix

# Update packages
npm update
```

### WordPress Plugins

- Only use reputable plugins
- Keep plugins updated
- Remove unused plugins
- Regular security audits
- Monitor plugin vulnerabilities

## Security Tools

### Recommended WordPress Plugins

- **Wordfence Security** - Firewall and malware scanner
- **iThemes Security** - Comprehensive security suite
- **Sucuri Security** - Security auditing and monitoring
- **All In One WP Security** - User-friendly security

### Code Analysis

```bash
# PHP CodeSniffer
phpcs --standard=WordPress functions.php

# Security scan
# Use SonarQube, Snyk, or similar
```

### Monitoring

- Enable WordPress debug logging
- Monitor server logs
- Set up intrusion detection
- Regular security scans
- File integrity monitoring

## Incident Response

If a security breach occurs:

1. **Isolate** - Take site offline if necessary
2. **Assess** - Determine scope of breach
3. **Contain** - Stop the attack
4. **Eradicate** - Remove malware/vulnerabilities
5. **Recover** - Restore from clean backup
6. **Review** - Analyze what happened
7. **Improve** - Implement preventive measures

## Resources

### Official Resources

- [WordPress Security](https://wordpress.org/support/article/hardening-wordpress/)
- [WooCommerce Security](https://woocommerce.com/document/security/)
- [OWASP Top 10](https://owasp.org/www-project-top-ten/)

### Security Blogs

- [Wordfence Blog](https://www.wordfence.com/blog/)
- [Sucuri Blog](https://blog.sucuri.net/)
- [WPScan](https://wpscan.com/blog/)

### Vulnerability Databases

- [WPVulnDB](https://wpscan.com/wordpresses)
- [CVE Details](https://www.cvedetails.com/)
- [Exploit Database](https://www.exploit-db.com/)

## Contact

For security concerns:
- Email: security@demewebsolutions.com
- PGP Key: Available on request

---

**Security is everyone's responsibility. Stay vigilant! 🔒**
