GETPAID LANDING PAGE ASSETS

QUICK START
Copy the images/ folder into your website public/ folder. Paths will start with /images/.
Filename dimensions are pixel dimensions. SVG dimensions are their viewBox size and scale without pixelation.
Use WebP for product images when possible; matching PNGs are included.

FOLDERS
branding/ — Primary saffron-green logo, alternate emerald logo, square symbol, favicon PNGs and ICO.
product/ — Dashboard mockup (1536x1024 wide rectangle), transparent checkout hero (1254x1254 square canvas), scalable direct-payment flow graphic and webhook card.
payment-apps/ — Web-sourced brand icons from official Google Play listings. Amazon Pay is its website favicon (native 32x32); do not enlarge it. WhatsApp is its general app icon, not a separate Pay logo.
features/ — Six original scalable SVG feature icons.
reference/ — Full-page design reference only. Build real HTML sections rather than displaying this entire image as a website.

WHERE TO PLACE THE IMAGES
Header/footer: getpaid-logo-saffron-green-transparent. It includes transparent padding; use about 150–180px image width and adjust to suit your header.
Hero right column: getpaid-checkout-qr-success-hero-transparent-square. Desktop display width about 420–560px. On mobile use width:100%; height:auto.
Supported apps row: payment-apps icons, display about 28–40px each with text labels. Amazon Pay at 32px or less.
Main product section: getpaid-dashboard-demo-wide-rectangle. Display about 760–1100px wide; retain its 3:2 aspect ratio.
Beside dashboard: getpaid-direct-to-bank-payment-flow-wide.
Developer section: getpaid-signed-webhook-delivery-card-wide. Use real HTML code blocks if you want selectable code.
Feature cards: corresponding SVG icons, 24–32px display size.
Browser favicon: getpaid-favicon-multisize.ico or getpaid-favicon_32x32.png.
Apple touch icon: getpaid-favicon_180x180.png.

HTML EXAMPLE
<img src="/images/product/getpaid-dashboard-demo-wide-rectangle_1536x1024.webp" width="1536" height="1024" loading="lazy" alt="Illustrative getpaid dashboard with sample orders and payment statuses">

IMAGE CSS
img { max-width: 100%; height: auto; }
Product images should use object-fit: contain; avoid cropping useful interface details.
The checkout is above the fold: do not lazy-load it. Lazy-load dashboard and other lower images.

IMPORTANT ASSET DETAILS
Dashboard and checkout are AI-generated illustrative UI, not screenshots of a working product. Dashboard data is sample data. The QR graphic is a nonfunctional visual example and must not be used to collect payment. Preserve the demo labels.
The generated UI logo is an approximation; use the supplied standalone logo as the real website logo.
The dashboard chart is decorative sample UI and not a source of financial data.
WebP files are optimized raster versions; logo PNGs are raster artwork, not true vector files.
SVG payment flow, webhook card and feature icons are original code-drawn artwork.
Official third-party artwork remains owned by each brand. Source URLs are provided in payment-app-icon-sources.json. Display app compatibility only where your checkout actually supports it.
Do not use the reference mockup as authoritative pricing or feature copy; keep your actual plan details from your site.

PROVENANCE
Generated: standalone getpaid logos, symbol, dashboard mockup, checkout mockup and full-page design reference.
Web: payment app icons; official listings/web source URLs provided.
Original SVG: payment flow, webhook card, six feature icons.
