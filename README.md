# 🚀 SpaceWink VPN

**Secure, Fast & Reliable VPN Application**

<p align="center">
  <img src="assets/images/logo.png" alt="SpaceWink VPN Logo" width="200"/>
</p>

## 📱 About SpaceWink VPN

SpaceWink VPN is a powerful, multi-protocol VPN application built with Flutter. It provides secure and anonymous internet access with support for multiple VPN protocols.

### ✨ Key Features

- 🔐 **Multiple VPN Protocols**
  - OpenVPN
  - V2Ray
  - WireGuard

- 🌍 **Global Server Network**
  - Multiple server locations
  - Fast connection speeds
  - Low latency

- 👤 **User-Friendly Interface**
  - Clean and modern UI
  - Easy server switching
  - One-tap connect

- 🛡️ **Privacy & Security**
  - Military-grade encryption
  - No logs policy
  - DNS leak protection
  - Kill switch support

- 💎 **Premium Features**
  - Subscription management
  - Unlimited bandwidth
  - 24/7 customer support
  - Multi-device support

---

## 🏗️ Tech Stack

### Frontend (Mobile App)
- **Framework:** Flutter 3.38.5
- **Language:** Dart 3.10.4
- **State Management:** GetX
- **UI:** Material Design with Google Fonts

### Backend (Admin Panel)
- **Framework:** Laravel 10
- **Database:** MySQL
- **Language:** PHP 8.1+

### VPN Protocols
- **OpenVPN:** Open-source VPN protocol
- **V2Ray:** Advanced proxy tool
- **WireGuard:** Modern, fast VPN protocol

---

## 📋 Requirements

### Mobile App Development
```
✅ Flutter SDK 3.38.5+
✅ Dart 3.10.4+
✅ Android SDK (API 23+)
✅ Android Studio / VS Code
```

### Backend Setup
```
✅ PHP 8.1+
✅ MySQL/MariaDB 10.x
✅ Composer
✅ Web Server (Nginx/Apache)
✅ SSL Certificate
```

### VPN Servers
```
✅ Ubuntu 20.04/22.04 VPS
✅ 1GB RAM minimum
✅ Public IP address
✅ Root access
```

---

## 🚀 Quick Start

### 1. Clone Repository
```bash
git clone https://github.com/YOUR_USERNAME/spacewink-vpn.git
cd spacewink-vpn
```

### 2. Setup Flutter App
```bash
cd source-code/app/spacewink_vpn

# Install dependencies
flutter pub get

# Run app
flutter run

# Build APK
flutter build apk --release
```

### 3. Setup Backend
```bash
cd source-code/admin

# Install dependencies
composer install

# Configure environment
cp .env.example .env
nano .env

# Generate key
php artisan key:generate

# Setup database
mysql -u root -p spacewink_vpn < database.sql

# Start server
php artisan serve
```

---

## 📁 Project Structure

```
spacewink-vpn/
├── source-code/
│   ├── app/
│   │   └── spacewink_vpn/        # Flutter mobile app
│   │       ├── android/           # Android platform
│   │       ├── ios/               # iOS platform
│   │       ├── lib/               # Dart source code
│   │       ├── assets/            # Images, fonts, configs
│   │       └── pubspec.yaml       # Flutter dependencies
│   │
│   ├── admin/                     # Laravel backend
│   │   ├── app/                   # Application logic
│   │   ├── database/              # Migrations & seeds
│   │   ├── public/                # Public assets
│   │   ├── routes/                # API routes
│   │   └── composer.json          # PHP dependencies
│   │
│   └── docs/                      # Documentation
│
├── README.md                      # This file
├── SETUP_GUIDE.md                 # Detailed setup instructions
└── API_REQUIREMENTS.md            # API documentation
```

---

## 🔧 Configuration

### Update API Endpoint

**File:** `lib/utils/app_strings.dart`
```dart
static const String baseUrl = "https://your-domain.com";
```

### Change Package Name

```bash
flutter pub run change_app_package_name:main com.yourcompany.spacewinkvpn
```

### Update App Name & Logo

1. Replace logo files in `android/app/src/main/res/mipmap-*/`
2. Update `assets/images/logo.png`
3. Modify `android/app/src/main/AndroidManifest.xml`

---

## 🌐 API Endpoints

### Authentication
- `POST /api/auth/user/login` - User login
- `POST /api/auth/user/register` - User registration
- `POST /api/user/forgot-password` - Password reset

### VPN Servers
- `GET /api/openvpn/list` - Get OpenVPN servers
- `GET /api/v2ray/list` - Get V2Ray servers
- `GET /api/wireguard/list` - Get WireGuard servers

### User Management
- `GET /api/user/show-profile` - Get user profile
- `GET /api/user/subscription` - Get subscription details
- `POST /api/server-connect` - Connect to server
- `POST /api/server-disconnect` - Disconnect from server

---

## 🏗️ Building for Production

### Android APK
```bash
# Debug build
flutter build apk --debug

# Release build (requires signing)
flutter build apk --release

# App Bundle (for Play Store)
flutter build appbundle --release
```

### iOS Build
```bash
# Requires Mac with Xcode
flutter build ios --release
```

---

## 🔐 Security Features

- ✅ AES-256 encryption
- ✅ SHA-256 authentication
- ✅ Perfect forward secrecy
- ✅ DNS leak protection
- ✅ IPv6 leak protection
- ✅ Kill switch
- ✅ No logs policy

---

## 📊 Supported Platforms

- ✅ Android 6.0+ (API 23+)
- ✅ iOS 12.0+
- ⚠️ Linux (Desktop support)
- ⚠️ macOS (Desktop support)
- ⚠️ Windows (Desktop support)

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is proprietary software. All rights reserved.

---

## 📞 Support

For support, email support@spacewink.com or join our Discord server.

---

## 🙏 Acknowledgments

- Flutter Team for the amazing framework
- OpenVPN, V2Ray, and WireGuard communities
- All contributors and testers

---

## 📸 Screenshots

<p align="center">
  <img src="screenshots/home.png" width="200"/>
  <img src="screenshots/servers.png" width="200"/>
  <img src="screenshots/profile.png" width="200"/>
</p>

---

## 🔄 Version History

### v1.0.0 (2026-01-05)
- 🎉 Initial release
- ✅ OpenVPN support
- ✅ V2Ray support
- ✅ WireGuard support
- ✅ User authentication
- ✅ Subscription management
- ✅ Multi-server support

---

**Made with ❤️ by SpaceWink Team**

© 2026 SpaceWink VPN. All rights reserved.
