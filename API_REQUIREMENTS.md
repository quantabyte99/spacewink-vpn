# 🔑 PIXI VPN - API & REQUIREMENTS ANALYSIS

## ⚠️ हाँ, Extra API की जरूरत है!

यह VPN app **सिर्फ एक client app** है। इसे काम करने के लिए **Backend API और VPN Servers** की जरूरत है।

---

## 🎯 3 Main Components की जरूरत है:

### 1️⃣ **Backend API (Laravel Admin Panel)** ✅
   - **Location:** `/root/android_projects/pixivpn/source-code/admin/`
   - **Status:** ✅ Already included in project
   - **Purpose:** User management, server management, subscriptions
   
### 2️⃣ **VPN Servers** ❌
   - **Status:** ❌ NOT Included - आपको खुद setup करनी होगी
   - **Types:** OpenVPN, V2Ray, WireGuard servers
   
### 3️⃣ **Domain/Hosting** ❌
   - **Status:** ❌ NOT Included
   - **Purpose:** Admin panel host करने के लिए

---

## 📡 Backend API Details

### Current Configuration
```dart
// File: lib/utils/app_strings.dart
static const String baseUrl = "https://vpn-admin.pixiumlab.com";
```

⚠️ **यह demo URL है!** आपको change करना होगा अपनी URL से।

### API Endpoints (Total: 20+)

#### 🔐 Authentication APIs
```
POST /api/auth/user/login          - User login
POST /api/auth/user/register       - User registration
POST /api/user/forgot-password     - Password reset
POST /api/user/reset-password      - Password reset confirmation
```

#### 🌐 VPN Server APIs
```
GET /api/openvpn/list              - Get OpenVPN servers
GET /api/v2ray/list                - Get V2Ray servers
GET /api/wireguard/list            - Get WireGuard servers
```

#### 👤 User Management APIs
```
GET /api/user/show-profile         - User profile
GET /api/user/status               - User status check
GET /api/user/subscription         - Subscription details
POST /api/user/subscription/cancel - Cancel subscription
```

#### 🔌 Connection APIs
```
POST /api/server-connect           - Connect to server
POST /api/server-disconnect        - Disconnect from server
POST /api/vpn/generate             - Generate WireGuard config
POST /api/vpn/remove-client        - Remove WireGuard client
```

#### ⚙️ App Settings APIs
```
GET /api/app-setting               - App settings
GET /api/general-setting           - General settings
GET /api/popup-setting             - Update popup settings
GET /api/contact-setting           - Contact information
GET /api/admob-setting             - AdMob configuration
GET /api/helpcenter/search         - Help center
POST /api/user/chat                - Chat support
```

---

## 🖥️ Backend Setup Requirements

### Admin Panel (Laravel)

#### 1. Server Requirements
```
✅ PHP 8.1+
✅ MySQL/MariaDB 10.x
✅ Composer
✅ Web Server (Nginx/Apache)
✅ SSL Certificate (for HTTPS)
```

#### 2. Installation Steps

```bash
cd /root/android_projects/pixivpn/source-code/admin

# Install PHP dependencies
composer install

# Setup environment
cp .env.example .env
nano .env  # Edit database & app settings

# Generate app key
php artisan key:generate

# Create database
mysql -u root -p
CREATE DATABASE pixivpn;
exit;

# Import database
mysql -u root -p pixivpn < database.sql

# Run migrations (if needed)
php artisan migrate

# Set permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Start development server (testing only)
php artisan serve --host=0.0.0.0 --port=8000

# Production: Configure Nginx/Apache
```

#### 3. Environment Configuration (.env)
```env
APP_NAME="Pixi VPN"
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pixivpn
DB_USERNAME=root
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_FROM_ADDRESS=noreply@yourdomain.com
```

#### 4. Admin Credentials (Default)
```
Email: admin@gmail.com
Password: Check database.sql or reset
```

---

## 🌐 VPN Server Setup

### आपको VPN servers setup करनी होंगी:

### Option 1: OpenVPN Server

#### Requirements
```
- Ubuntu 20.04/22.04 VPS
- 1 GB RAM minimum
- Public IP address
- Root access
```

#### Quick Setup
```bash
# Install OpenVPN
wget https://git.io/vpn -O openvpn-install.sh
chmod +x openvpn-install.sh
sudo ./openvpn-install.sh

# Generate client configs
# Upload .ovpn files to admin panel
```

#### Cost: $4-10/month per server

---

### Option 2: V2Ray Server

#### Requirements
```
- Ubuntu 20.04+ VPS
- 512 MB RAM minimum
- Port 443 available
```

#### Quick Setup
```bash
# Install V2Ray
bash <(curl -L https://raw.githubusercontent.com/v2fly/fhs-install-v2ray/master/install-release.sh)

# Configure V2Ray
nano /usr/local/etc/v2ray/config.json

# Start service
systemctl start v2ray
systemctl enable v2ray
```

#### Cost: $5-15/month per server

---

### Option 3: WireGuard Server

#### Requirements
```
- Ubuntu 20.04+ VPS
- Kernel 5.6+ (WireGuard support)
- 512 MB RAM minimum
```

#### Quick Setup
```bash
# Install WireGuard
apt update
apt install wireguard

# Generate keys
wg genkey | tee privatekey | wg pubkey > publickey

# Configure
nano /etc/wireguard/wg0.conf

# Start
wg-quick up wg0
systemctl enable wg-quick@wg0
```

#### Cost: $4-12/month per server

---

## 💰 Total Cost Estimate

### Minimum Setup
```
Backend Hosting:     $5-10/month  (Shared hosting)
VPN Server (1):      $5-10/month  (Basic VPS)
Domain:              $10-15/year
SSL Certificate:     FREE (Let's Encrypt)
──────────────────────────────────
TOTAL:              ~$10-20/month + $10/year domain
```

### Recommended Setup
```
Backend Hosting:     $20-30/month  (VPS)
VPN Servers (3):     $15-30/month  (Multiple locations)
Domain:              $10-15/year
CDN (optional):      $0-10/month
──────────────────────────────────
TOTAL:              ~$35-70/month + $10/year domain
```

### Premium Setup
```
Backend Hosting:     $50-100/month  (Dedicated)
VPN Servers (10+):   $50-200/month  (Global coverage)
Domain:              $10-50/year
CDN:                 $20-50/month
──────────────────────────────────
TOTAL:              ~$120-350/month
```

---

## 🆓 Free Testing Options

### Free VPN Servers (for testing only)

#### 1. VPNBook (OpenVPN)
- Website: https://www.vpnbook.com/
- Free .ovpn configs
- Limited for testing

#### 2. FreeOpenVPN
- Website: https://freeopenvpn.org/
- Free configs available
- Good for development

#### 3. Create Your Own (Free Tier)
```
Oracle Cloud:      FREE tier (2 VPS forever)
Google Cloud:      $300 free credit
AWS:               12 months free tier
DigitalOcean:      $200 credit (with referral)
Vultr:             $100-250 credit (new users)
```

---

## 🔧 App Configuration Changes

### 1. Change Base URL

**File:** `lib/utils/app_strings.dart`
```dart
// Change this line:
static const String baseUrl = "https://vpn-admin.pixiumlab.com";

// To your domain:
static const String baseUrl = "https://your-domain.com";
```

### 2. Package Name Change

```bash
cd /root/android_projects/pixivpn/source-code/app/pixi_vpn
export PATH="$PATH:/root/flutter/bin"

# Change package name
flutter pub run change_app_package_name:main com.yourcompany.vpn
```

### 3. App Name & Logo

**File:** `pubspec.yaml` - Update app name
**Files to replace:**
- `android/app/src/main/res/mipmap-*/ic_launcher.png`
- `assets/images/logo.png`

---

## 📊 Database Tables (Admin Panel)

```sql
admins              - Admin users
users               - VPN app users
subscriptions       - User subscriptions
servers             - VPN servers list
  - openvpn_servers
  - v2ray_servers
  - wireguard_servers
bandwidths          - Bandwidth limits
connections         - Active connections
payments            - Payment records
app_settings        - App configuration
general_settings    - General settings
admob_settings      - Ad configuration
help_centers        - Help articles
contacts            - Contact info
```

---

## 🔐 Security Requirements

### SSL Certificate (Mandatory)
```bash
# Install Certbot
apt install certbot python3-certbot-nginx

# Get certificate
certbot --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal
certbot renew --dry-run
```

### Firewall Rules
```bash
# Allow necessary ports
ufw allow 80/tcp    # HTTP
ufw allow 443/tcp   # HTTPS
ufw allow 1194/udp  # OpenVPN
ufw allow 51820/udp # WireGuard
ufw enable
```

---

## 🚀 Complete Setup Checklist

### Backend Setup
- [ ] Get VPS/hosting (DigitalOcean, AWS, etc.)
- [ ] Get domain name
- [ ] Install Laravel admin panel
- [ ] Configure database
- [ ] Setup SSL certificate
- [ ] Test admin login
- [ ] Configure mail settings

### VPN Server Setup
- [ ] Get VPS for OpenVPN
- [ ] Get VPS for V2Ray
- [ ] Get VPS for WireGuard
- [ ] Install & configure servers
- [ ] Generate configs/keys
- [ ] Add servers to admin panel
- [ ] Test connections

### App Configuration
- [ ] Change baseUrl in code
- [ ] Change package name
- [ ] Update app name & logo
- [ ] Configure Firebase (optional)
- [ ] Setup AdMob (optional)
- [ ] Build & test APK

### Testing
- [ ] Test user registration
- [ ] Test login
- [ ] Test server connection
- [ ] Test all VPN protocols
- [ ] Test subscription flow
- [ ] Test payment (if enabled)

---

## 💡 Alternative Solutions

### If budget is tight:

#### Option 1: Use Existing VPN API Services
```
- NordVPN API (commercial)
- ProtonVPN API (paid)
- Custom VPN API providers
```

#### Option 2: Open Source Alternatives
```
- Use Outline VPN (free, self-hosted)
- Use Algo VPN (free, automated setup)
- Use Streisand (free, multiple protocols)
```

#### Option 3: Start with 1 Protocol
```
- Setup only OpenVPN first
- Later add V2Ray and WireGuard
- Reduce initial cost
```

---

## 📱 Testing Without Backend

### For initial testing:
1. Mock API responses in code
2. Use local JSON files
3. Hardcode test servers
4. Bypass authentication temporarily

**But for production: Full backend is REQUIRED!**

---

## 🎯 Summary

### ❓ API की जरूरत है?
**हाँ, पूरा backend system चाहिए!**

### 💰 कितना खर्च होगा?
**Minimum: $10-20/month**  
**Recommended: $35-70/month**

### 🆓 Free में test कर सकते हैं?
**हाँ!** Oracle/AWS free tier use करें

### ⏱️ Setup में कितना time?
**Backend: 2-4 hours**  
**VPN Servers: 1-2 hours each**  
**Total: 4-8 hours** (first time)

---

## 📞 Next Steps

1. **Decide budget** - free tier या paid hosting?
2. **Get domain** - Namecheap, GoDaddy ($10/year)
3. **Setup backend** - Follow admin setup guide
4. **Setup 1 VPN server** - Start with OpenVPN
5. **Configure app** - Change baseUrl
6. **Build APK** - Test connection
7. **Scale up** - Add more servers/protocols

---

**Generated:** January 5, 2026  
**Location:** `/root/android_projects/pixivpn/API_REQUIREMENTS.md`

---

🎯 **Bottom Line:**  
App अभी काम नहीं करेगी बिना backend के!  
आपको setup करनी होगी:
1. Laravel admin panel (backend API)
2. VPN servers (OpenVPN/V2Ray/WireGuard)
3. Domain + hosting

**Total investment:** $10-70/month (depending on scale)
