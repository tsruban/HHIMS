# Security Policy

## Table of Contents

- [Supported Versions](#supported-versions)
- [Reporting a Vulnerability](#reporting-a-vulnerability)
- [Response Timeline](#response-timeline)
- [Known Security Limitations](#known-security-limitations)
- [Security Hardening Guide](#security-hardening-guide)
  - [Credentials and Secrets](#credentials-and-secrets)
  - [Session Security](#session-security)
  - [CSRF Protection](#csrf-protection)
  - [XSS Filtering](#xss-filtering)
  - [HTTPS and Transport Security](#https-and-transport-security)
  - [File System Permissions](#file-system-permissions)
  - [Database Security](#database-security)
  - [Error Reporting](#error-reporting)
- [Healthcare Data Obligations](#healthcare-data-obligations)
- [Security Checklist for Production Deployment](#security-checklist-for-production-deployment)

---

## Supported Versions

Security fixes are applied to the current main branch only. No backport releases are issued.

| Version | Supported |
|---|---|
| Latest (main branch) | Yes |
| Older tagged releases | No |

---

## Reporting a Vulnerability

HHIMS handles sensitive patient health information. Responsible disclosure of security vulnerabilities is strongly encouraged.

**Do not open a public GitHub issue for security vulnerabilities.**

To report a vulnerability, contact the maintainer directly:

- **Email:** TSRuban@mdsfoss.org
- **Subject line:** `[HHIMS Security] Brief description of issue`

Include in your report:

- A clear description of the vulnerability
- Steps to reproduce the issue
- The potential impact (data exposure, authentication bypass, etc.)
- Your suggested remediation, if any

All reports will be acknowledged within **72 hours**.

---

## Response Timeline

| Stage | Target Time |
|---|---|
| Acknowledgement of report | 72 hours |
| Initial assessment and severity classification | 7 days |
| Patch development for confirmed vulnerabilities | 30 days (critical), 90 days (moderate/low) |
| Public disclosure | After patch is released |

If a confirmed vulnerability is not patched within the stated timeline, the reporter is free to disclose publicly after notifying the maintainer.

---

## Known Security Limitations

HHIMS is a legacy codebase originally developed for PHP 5.x in a controlled hospital intranet environment. The following security limitations exist in the current codebase and must be understood before deploying to any network.

### SQL Injection

- Many model methods construct SQL queries via string interpolation rather than parameterised queries or prepared statements.
- The codebase relies on `mysql_real_escape_string()` (now shimmed via `mysqli_real_escape_string()`) for input sanitisation, which is not equivalent to parameterised queries.
- **Risk:** High if the application is exposed to the public internet without a web application firewall.
- **Mitigation:** Deploy behind a WAF; restrict database user privileges; never expose the application directly to untrusted networks.

### Password Hashing

- User passwords are stored as **MD5 hashes** without salt.
- MD5 is cryptographically broken and unsuitable for password storage.
- **Risk:** If the `user` table is compromised, passwords can be recovered rapidly via rainbow table lookups.
- **Mitigation:** Migrate password hashing to `password_hash()` / `PASSWORD_BCRYPT` and replace the login verification to use `password_verify()`.

### CSRF Protection

- Cross-Site Request Forgery protection is **disabled** in `application/config/config.php`:
  ```php
  $config['csrf_protection'] = FALSE;
  ```
- **Risk:** Authenticated users can be tricked into submitting state-changing requests from a third-party page.
- **Mitigation:** Enable CSRF protection (see [CSRF Protection](#csrf-protection) below).

### XSS Filtering

- Global XSS input filtering is **disabled**:
  ```php
  $config['global_xss_filtering'] = FALSE;
  ```
- Individual form fields use CodeIgniter's `xss_clean` validation rule, but coverage is not universal.
- **Risk:** Stored XSS is possible if an attacker can write unsanitised input to the database.
- **Mitigation:** Enable global XSS filtering or audit all input paths for `xss_clean`.

### Session Cookie Security

- Session cookies are **not encrypted** and **not restricted to HTTPS**:
  ```php
  $config['sess_encrypt_cookie'] = FALSE;
  $config['cookie_secure']       = FALSE;
  $config['sess_match_ip']       = FALSE;
  ```
- **Risk:** Session tokens can be intercepted on unencrypted networks, and session fixation/hijacking is easier without IP binding.
- **Mitigation:** Enable cookie encryption, set `cookie_secure = TRUE`, and enforce HTTPS.

### Weak Encryption Key

- The default encryption key is set to a trivially guessable value:
  ```php
  $config['encryption_key'] = 'hhims';
  ```
- This key is used to sign session cookies.
- **Risk:** Session tokens can be forged if the key is known.
- **Mitigation:** Replace with a cryptographically random string of at least 32 characters before deploying.

### Insecure Direct Object References

- Many URLs accept a numeric primary key directly in the path (e.g., `index.php/patient/view/123`).
- Access control at the record level depends entirely on role checks at the controller level. If a controller omits a `checkLogin()` or permission check, records may be accessible without authentication.
- **Mitigation:** Audit all controller methods for `checkLogin()` and permission calls.

### File Upload Validation

- File uploads in `attach/` and `attach/diagram/` are restricted to `gif|jpg|png` by configuration, but server-side MIME type verification should be confirmed.
- Uploaded files are stored with encrypted names but within the web root.
- **Mitigation:** Confirm MIME type validation is enforced; consider moving the `attach/` directory outside the web root and serving files through a controller.

---

## Security Hardening Guide

### Credentials and Secrets

Replace the default encryption key with a strong random value before going live.

In `application/config/config.php`:

```php
// Generate with: php -r "echo bin2hex(random_bytes(32));"
$config['encryption_key'] = 'YOUR_64_CHARACTER_RANDOM_HEX_STRING';
```

Change the default `demo` account password immediately after installation via the user management interface.

### Session Security

Harden session settings in `application/config/config.php`:

```php
$config['sess_expiration']      = 1800;   // 30 minutes
$config['sess_expire_on_close'] = TRUE;
$config['sess_encrypt_cookie']  = TRUE;
$config['sess_use_database']    = TRUE;   // Store sessions in DB, not cookie
$config['sess_match_ip']        = TRUE;
$config['sess_match_useragent'] = TRUE;
$config['cookie_secure']        = TRUE;   // Requires HTTPS
$config['cookie_httponly']      = TRUE;
```

To use database-backed sessions, create the session table:

```sql
CREATE TABLE IF NOT EXISTS `ci_sessions` (
    session_id      VARCHAR(40)  NOT NULL DEFAULT '0',
    ip_address      VARCHAR(45)  NOT NULL DEFAULT '0',
    user_agent      VARCHAR(120) NOT NULL,
    last_activity   INT(10) UNSIGNED NOT NULL DEFAULT 0,
    user_data       TEXT NOT NULL,
    PRIMARY KEY (session_id),
    KEY `last_activity_idx` (`last_activity`)
);
```

### CSRF Protection

Enable CSRF protection in `application/config/config.php`:

```php
$config['csrf_protection']  = TRUE;
$config['csrf_token_name']  = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire']      = 1800;
```

All HTML forms must include the CSRF token field. With CodeIgniter's Form helper:

```php
echo form_open('module/action');  // Automatically injects CSRF token
```

### XSS Filtering

Enable global XSS input filtering in `application/config/config.php`:

```php
$config['global_xss_filtering'] = TRUE;
```

Alternatively, ensure every form field definition in `application/forms/` includes `xss_clean` in its `rules` array.

### HTTPS and Transport Security

HHIMS must be served over HTTPS in any environment where patient data is transmitted. Configure your web server accordingly and add the following to your Apache virtual host or `.htaccess`:

```apache
# Redirect all HTTP to HTTPS
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# HTTP Strict Transport Security (1 year)
Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains"

# Prevent MIME sniffing
Header always set X-Content-Type-Options "nosniff"

# Clickjacking protection
Header always set X-Frame-Options "SAMEORIGIN"

# XSS protection header (legacy browsers)
Header always set X-XSS-Protection "1; mode=block"
```

### File System Permissions

```bash
# Web server should own application files
sudo chown -R www-data:www-data /var/www/hhims

# Restrict all files to owner read/write, group read
sudo find /var/www/hhims -type f -exec chmod 640 {} \;
sudo find /var/www/hhims -type d -exec chmod 750 {} \;

# Writable directories (logs and uploads only)
sudo chmod 770 /var/www/hhims/application/logs
sudo chmod 770 /var/www/hhims/attach

# Protect sensitive configuration files from web access
sudo chmod 600 /var/www/hhims/application/config/database.php
sudo chmod 600 /var/www/hhims/mdsfoss.key
```

Deny direct web access to sensitive directories via `.htaccess` or Apache configuration:

```apache
# Deny access to application source code
<Directory /var/www/hhims/application>
    Require all denied
</Directory>

<Directory /var/www/hhims/system>
    Require all denied
</Directory>

# Deny access to log files
<Directory /var/www/hhims/application/logs>
    Require all denied
</Directory>
```

### Database Security

Create a dedicated database user with the minimum required privileges. Do not use the MySQL `root` account for the application.

```sql
CREATE USER 'hhims_app'@'localhost' IDENTIFIED BY 'strong_random_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON hhims.* TO 'hhims_app'@'localhost';
FLUSH PRIVILEGES;
```

Additional recommendations:

- Enable MySQL binary logging for audit purposes
- Schedule regular encrypted database backups stored off the server
- Restrict MySQL to `localhost` only (`bind-address = 127.0.0.1` in `my.cnf`)

### Error Reporting

Never display PHP errors to end users in production. Set the environment in `index.php`:

```php
define('ENVIRONMENT', 'production');
```

Enable file-based error logging rather than display:

```php
// application/config/config.php
$config['log_threshold'] = 1;  // Log errors only
```

Ensure the `application/logs/` directory is writable but not web-accessible.

---

## Healthcare Data Obligations

HHIMS stores personally identifiable health information (PHI). Deployers are responsible for compliance with applicable data protection legislation in their jurisdiction. This includes but is not limited to:

| Jurisdiction | Applicable Standard |
|---|---|
| European Union | General Data Protection Regulation (GDPR) |
| United States | Health Insurance Portability and Accountability Act (HIPAA) |
| Sri Lanka | Personal Data Protection Act No. 9 of 2022 |
| India | Digital Personal Data Protection Act 2023 |
| Australia | Privacy Act 1988 / Australian Privacy Principles |

Regardless of jurisdiction, the following practices apply:

- Patient data must never be stored on publicly accessible servers without encryption at rest
- Access logs must be retained and reviewed regularly
- Data access must be limited to staff with a legitimate clinical need
- Patient records must not be used for purposes beyond direct care without consent
- A documented data retention and deletion policy must be maintained
- Breaches involving patient data must be reported to the relevant authority within the timeframe required by applicable law

---

## Security Checklist for Production Deployment

Complete all items before going live.

**Authentication and Access**

- [ ] Default `demo` account password changed or account disabled
- [ ] All user accounts created with the principle of least privilege
- [ ] Strong, unique passwords enforced for all accounts
- [ ] Session expiration set to 30 minutes or less

**Cryptography**

- [ ] `encryption_key` replaced with a cryptographically random 32+ byte value
- [ ] Session cookie encryption enabled (`sess_encrypt_cookie = TRUE`)
- [ ] Password hashing migrated from MD5 to `password_hash()` with bcrypt

**Transport Security**

- [ ] HTTPS enforced for all traffic
- [ ] HTTP to HTTPS redirect configured
- [ ] `cookie_secure = TRUE` set in config
- [ ] HSTS header enabled on the web server

**Input Handling**

- [ ] CSRF protection enabled
- [ ] Global XSS filtering enabled or all form fields audited for `xss_clean`
- [ ] File upload MIME type validation confirmed

**Infrastructure**

- [ ] Application not exposed directly to the public internet (deploy behind a WAF or VPN)
- [ ] Database accessible from `localhost` only
- [ ] Dedicated least-privilege database user configured
- [ ] `application/`, `system/`, and `logs/` directories blocked from web access
- [ ] PHP `display_errors` set to `Off` in `php.ini`
- [ ] Environment set to `production` in `index.php`
- [ ] Error logging enabled to file only

**Sensitive Files**

- [ ] `application/config/database.php` excluded from version control
- [ ] `mdsfoss.key` excluded from version control
- [ ] `attach/` directory excluded from version control
- [ ] `application/logs/` directory excluded from version control

**Operational**

- [ ] Automated database backup scheduled and tested
- [ ] Backup storage is off-server and encrypted
- [ ] Security patch process documented for the team
- [ ] Incident response contact list documented

---

*For questions about this policy, contact the project maintainer at TSRuban@mdsfoss.org.*
