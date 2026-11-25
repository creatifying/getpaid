<p align="center">
  <img src="public/images/logo.png" alt="GetPaid Logo" width="320"/>
</p>

<h3 align="center">Zero-Commission, Self-Hosted UPI Payment Infrastructure</h3>

<p align="center">
  Accept UPI payments directly into your own bank account with dynamic QR codes, instant verification, automated webhooks, and zero intermediary transaction fees.
</p>

<p align="center">
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12"/></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+"/></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-4.0-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS 4"/></a>
  <a href="https://mysql.com"><img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL"/></a>
  <img src="https://img.shields.io/badge/cPanel-Ready-FF6C2C?style=for-the-badge&logo=cpanel&logoColor=white" alt="cPanel Ready"/>
  <a href="LICENSE"><img src="https://img.shields.io/badge/License-MIT-16A34A?style=for-the-badge" alt="MIT License"/></a>
</p>

<p align="center">
  <a href="#-key-features">Key Features</a> •
  <a href="#-supported-upi-apps">Supported Apps</a> •
  <a href="#-architecture">Architecture</a> •
  <a href="#-quick-start">Quick Start</a> •
  <a href="#-cpanel--shared-hosting-deployment">cPanel Guide</a> •
  <a href="#-api-reference">API Reference</a> •
  <a href="#-webhook-specification">Webhooks</a> •
  <a href="#-contributing">Contributing</a>
</p>

---

## ⚡ Why GetPaid?

Traditional payment aggregators (Razorpay, Cashfree, Paytm PG) charge **1.8% to 2.5% + GST** on every transaction and impose **T+2 / T+3 holding periods** before funds arrive in your account. 

**GetPaid** gives you complete ownership over your payments infrastructure:
- **0% Gateway Commission:** Money transfers directly from customer to your bank account via UPI rails.
- **Instant Settlement:** Direct credit into your bank account with ₹0 middleman escrow.
- **Customer Trust:** Branded checkout hosted on your own domain with real UPI app deep links.
- **Enterprise Reliability:** Distributed verification lease recovery, signed webhook outbox, and automatic UPI account rotation.

---

## 🚀 Key Features

| Capability | Description |
|---|---|
| **Dynamic UPI QR** | Generates standard NPCI-compliant dynamic QR codes containing precise order amount and reference. |
| **Instant Deep Linking** | Mobile customers tap direct intent buttons to pay seamlessly in Google Pay, PhonePe, Paytm, CRED, etc. |
| **Multi-Account Rotation** | Rotate payments across multiple UPI VPAs / accounts with daily volume limits and smart fallbacks. |
| **Automated Verification** | Real-time payment verification engine with automatic lease locks, process inspection, and UTR validation. |
| **Signed Webhooks** | HMAC-SHA256 authenticated webhook events with guaranteed at-least-once outbox delivery & retries. |
| **cPanel 1-Click Ready** | Zero-dependency deployment: ships with pre-bundled `vendor/` and compiled Vite assets for shared hosting. |
| **Developer First** | Clean REST API with bearer token authentication, sandbox mode, and comprehensive interactive documentation. |
| **Self-Hosted Privacy** | No customer data leaves your server; full audit logs and historical transaction inspection. |

---

## 📱 Supported UPI Apps

GetPaid provides 1-tap mobile deep linking and desktop QR scanning for all major NPCI UPI ecosystem apps:

| App | Identifier | Deep Link Scheme |
|---|---|---|
| **Google Pay** | `gpay` | `gpay://upi/pay` |
| **PhonePe** | `phonepe` | `phonepe://upi/pay` |
| **Paytm** | `paytm` | `paytmmp://pay` |
| **BHIM UPI** | `bhim` | `bhim://upi/pay` |
| **CRED** | `cred` | `credpay://upi/pay` |
| **Amazon Pay** | `amazon-pay` | `amazonpay://upi/pay` |
| **WhatsApp Pay** | `whatsapp` | `whatsapp://upi/pay` |
| **Navi UPI** | `navi` | `navi://upi/pay` |
| **Super.money** | `super-money` | `supermoney://upi/pay` |

---

## 🏗️ Architecture

```
               [ Customer Browser / Mobile ]
                             │
                  (Checkout / Deep Link)
                             ▼
 ┌─────────────────────────────────────────────────────────┐
 │                   GetPaid Core Engine                   │
 │                                                         │
 │  ┌─────────────────┐  ┌──────────────────────────────┐  │
 │  │ Public Webhook  │  │  Dynamic UPI QR Generator    │  │
 │  │ & Checkout UI   │  │  (NPCI UPI URI Specification)│  │
 │  └────────┬────────┘  └──────────────┬───────────────┘  │
 │           │                          │                  │
 │           ▼                          ▼                  │
 │  ┌──────────────────────────────────────────────────┐   │
 │  │      Account Rotation & Daily Volume Engine      │   │
 │  └────────────────────────┬─────────────────────────┘   │
 │                           │                             │
 │  ┌────────────────────────┴─────────────────────────┐   │
 │  │        Verification Engine & Lease Guard         │   │
 │  │   (Paytm Business, PhonePe PG, Manual UTR)       │   │
 │  └────────────────────────┬─────────────────────────┘   │
 │                           │                             │
 │  ┌────────────────────────┴─────────────────────────┐   │
 │  │      Webhook Outbox & Dispatcher (HMAC-SHA256)   │   │
 │  └──────────────────────────────────────────────────┘   │
 └───────────────────────────┬─────────────────────────────┘
                             │
                             ▼
                 [ Merchant Webhook Server ]
```

---

## 🛠️ Quick Start (Local Development)

### Prerequisites
- **PHP** 8.2 or higher (with `pdo_mysql`, `curl`, `mbstring`, `openssl`, `bcmath`, `gd`)
- **Composer** 2.x
- **Node.js** 18+ & **npm** (for asset compilation)
- **MySQL** 8.0+ or **SQLite** (for quick local testing)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/creatifying/getpaid.git
   cd getpaid
   ```

2. **Install PHP and Node dependencies:**
   ```bash
   composer install
   npm install
   ```

3. **Set up environment:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database in `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=getpaid_db
   DB_USERNAME=root
   DB_PASSWORD=your_password
   ```

5. **Run Migrations & Seed:**
   ```bash
   php artisan migrate
   ```

6. **Build Frontend Assets:**
   ```bash
   npm run build
   ```

7. **Start Development Server:**
   ```bash
   php artisan serve
   ```
   Visit `http://127.0.0.1:8000` to access the application.

---

## 🌐 cPanel / Shared Hosting Deployment

GetPaid is engineered specifically to run out-of-the-box on cPanel, Plesk, LiteSpeed, and shared Linux hosting without requiring SSH or Composer on the server.

### 1. Upload
Extract the pre-bundled release ZIP directly into your `public_html/` folder (or your subdomain's Document Root).

### 2. Configure Environment (`.env`)
Copy `.env.example` to `.env` and fill in your MySQL credentials:
```env
APP_NAME="GetPaid"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
ASSET_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cpanel_dbname
DB_USERNAME=cpanel_dbuser
DB_PASSWORD=cpanel_dbpassword
```

### 3. Initialize & Install
- **Via Web Installer:** Visit `https://your-domain.com/install.php` in your browser. The visual setup wizard validates PHP extensions, database credentials, runs migrations, and prompts you to create the initial admin user.
- **Via SSH (Optional):**
  ```bash
  php artisan key:generate --force
  php artisan migrate --force
  php artisan config:cache && php artisan route:cache && php artisan view:cache
  ```

### 4. Background Cron Job
Add a cron job in your hosting control panel to run every minute:
```bash
* * * * * /usr/local/bin/php /home/username/public_html/artisan schedule:run >> /dev/null 2>&1
```

---

## 📡 API Reference

All requests to the REST API must include your secret API Key in the `Authorization` header:

```http
Authorization: Bearer YOUR_API_KEY
Content-Type: application/json
Accept: application/json
```

### 1. Create Order

```http
POST /api/v1/orders
```

**Payload:**
```json
{
  "order_id": "ORD_982341",
  "amount": 499.00,
  "customer_name": "Rohan Sharma",
  "customer_email": "rohan@example.com",
  "customer_mobile": "9876543210",
  "redirect_url": "https://yoursite.com/checkout/callback",
  "callback_url": "https://yoursite.com/api/webhook/getpaid",
  "description": "Pro Subscription - 1 Month"
}
```

**Response (201 Created):**
```json
{
  "status": "success",
  "data": {
    "order_id": "ORD_982341",
    "gateway_reference": "GP_8f7b2c9e",
    "amount": 499.00,
    "payment_url": "https://your-domain.com/pay/GP_8f7b2c9e",
    "upi_intent": "upi://pay?pa=merchant@upi&pn=GetPaid&am=499.00&tr=GP_8f7b2c9e&tn=ORD_982341",
    "status": "pending",
    "expires_at": "2026-11-14T01:10:00Z"
  }
}
```

---

### 2. Check Order Status

```http
GET /api/v1/orders/ORD_982341
```

**Response (200 OK):**
```json
{
  "status": "success",
  "data": {
    "order_id": "ORD_982341",
    "amount": 499.00,
    "status": "completed",
    "utr": "432109876543",
    "paid_at": "2026-11-14T00:55:12Z",
    "payment_account": "Primary HDFC UPI"
  }
}
```

---

## 🔒 Webhook Specification

When an order payment is confirmed, GetPaid immediately posts an HMAC-SHA256 signed JSON payload to your configured `callback_url`.

### Webhook Headers
```http
POST /api/webhook/getpaid HTTP/1.1
Host: yoursite.com
Content-Type: application/json
X-GetPaid-Signature: 6e9b4fa2... (hex HMAC signature)
X-GetPaid-Timestamp: 1788987935
```

### Payload Structure
```json
{
  "event": "order.completed",
  "timestamp": 1788987935,
  "data": {
    "order_id": "ORD_982341",
    "gateway_reference": "GP_8f7b2c9e",
    "amount": 499.00,
    "status": "completed",
    "utr": "432109876543",
    "paid_at": "2026-11-14T00:55:12Z"
  }
}
```

### Signature Verification (PHP Example)
```php
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_GETPAID_SIGNATURE'] ?? '';
$secret = 'your_webhook_signing_secret';

$expectedSignature = hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expectedSignature, $signature)) {
    http_response_code(401);
    exit('Invalid signature');
}

// Process valid payment event
$event = json_decode($payload, true);
```

---

## 🛡️ Security Hardening

- **Front Controller Jail:** The root `.htaccess` strictly forbids public access to `.env`, `vendor/`, `database/`, `storage/`, and application code.
- **Lease Lock Identity:** Multi-worker deployments use atomic database locks to prevent duplicate order verification race conditions.
- **Timing Attack Mitigation:** Secret tokens and webhook signatures are compared using constant-time string comparisons (`hash_equals`).
- **Encrypted Sessions:** Session storage is encrypted with AES-256-GCM at rest when `SESSION_ENCRYPT=true`.

---

## 👥 Contributing

Contributions, bug reports, and pull requests are welcome!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

Distributed under the **MIT License**. See [`LICENSE`](LICENSE) for more information.

---

<p align="center">
  Crafted with ❤️ by <a href="https://github.com/creatifying"><strong>Creatifying</strong></a>
</p>

<p align="center">
  If GetPaid made it easier to accept your first UPI payment, you can <a href="https://buymeacoffee.com/creatifying"><strong>buy me a coffee ☕</strong></a>.
</p>
