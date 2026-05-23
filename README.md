# 🍎 Dự Án Website Bán Trái Cây - MVC PHP

## 🏗️ Mô Hình MVC

![Mô hình MVC](https://images.viblo.asia/beb9fe7b-f5c0-4cec-8c80-a82a2e8ce266.png)

Dự án sử dụng kiến trúc **MVC - Model View Controller** để tổ chức code rõ ràng, dễ bảo trì và dễ chia task khi làm nhóm.

### MVC là gì?

- **Model**: Làm việc với Database, xử lý truy vấn dữ liệu.
- **View**: Hiển thị giao diện cho người dùng.
- **Controller**: Nhận request, xử lý logic và điều hướng dữ liệu giữa Model và View.

---

# Site map:

Link: [Xem link Site map ở đây]("https://excalidraw.com/#json=gQxx5wrRdYrONmFAjjhDS,4DFyUptan9FvrIAv5kNUGQ")


## 📁 Cấu Trúc Thư Mục

```txt
Ten_du_an/
├── assets/                         # Tài nguyên tĩnh
│   ├── fonts/                      # Font chữ
│   ├── images/                     # Hình ảnh tĩnh
│   ├── javascripts/                # File JavaScript
│   └── css/                        # File CSS
│
├── uploads/                        # Ảnh upload từ admin
│   ├── products/                   # Ảnh sản phẩm
│   ├── categories/                 # Ảnh danh mục
│   └── settings/                   # Logo, banner website
│
├── controllers/                    # Xử lý logic request
│   ├── BaseController.php
│   ├── AuthController.php
│   ├── HomeController.php
│   ├── ProductController.php
│   ├── CartController.php
│   ├── OrderController.php
│   └── AdminController.php
│
├── models/                         # Tương tác Database
│   ├── BaseModel.php
│   ├── User.php
│   ├── Category.php
│   ├── Product.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Log.php
│   └── WebSetting.php
│
├── views/                          # Giao diện người dùng
│   ├── components/                 # Component dùng lại
│   ├── layouts/                    # Layout chung
│   │   ├── app.php                 # Layout public
│   │   └── admin.php               # Layout admin
│   │
│   ├── pages/                      # Các trang public
│   │   ├── home.php
│   │   ├── products.php
│   │   ├── product-detail.php
│   │   ├── cart.php
│   │   ├── checkout.php
│   │   ├── login.php
│   │   └── register.php
│   │
│   └── admin/                      # Giao diện admin
│       ├── dashboard.php
│       ├── categories/
│       ├── products/
│       ├── orders/
│       ├── users/
│       ├── logs/
│       └── settings/
│
├── config/                         # Cấu hình hệ thống
│   └── connection.php              # Kết nối Database
│
├── helpers/                        # Hàm hỗ trợ dùng chung
│   ├── auth.php                    # Check login, check admin
│   ├── upload.php                  # Xử lý upload ảnh
│   ├── slug.php                    # Tạo slug
│   └── log.php                     # Ghi log hệ thống
│
├── database/                       # File database
│   ├── schema.sql                  # Cấu trúc bảng
│   └── seed.sql                    # Data mẫu
│
├── index.php                       # Entry point
└── routes.php                      # Định tuyến URL
```

---

## 🔄 Flow Xử Lý Request

```txt
User truy cập URL
        ↓
index.php
        ↓
routes.php
        ↓
Controller
        ↓
Model
        ↓
Database
        ↓
Controller nhận dữ liệu
        ↓
View hiển thị HTML
```

Ví dụ flow xem danh sách sản phẩm:

```txt
/products
    ↓
routes.php gọi ProductController
    ↓
ProductController gọi Product Model
    ↓
Product Model SELECT dữ liệu từ MySQL
    ↓
ProductController truyền data sang View
    ↓
View hiển thị danh sách sản phẩm
```

---

## 🛠️ Tech Stack

| Công nghệ | Mục đích |
|---|---|
| **PHP thuần** | Xử lý backend |
| **MySQL** | Lưu trữ dữ liệu |
| **HTML** | Xây dựng cấu trúc giao diện |
| **CSS / Bootstrap / Tailwind** | Styling giao diện |
| **JavaScript / jQuery / Alpine.js** | Xử lý tương tác frontend |
| **Apache / XAMPP / Laragon** | Chạy server local |

---

## 🧩 Các Chức Năng Chính

### Public Website

| Chức năng | Mô tả |
|---|---|
| Trang chủ | Hiển thị banner, danh mục, sản phẩm nổi bật |
| Danh sách sản phẩm | Hiển thị sản phẩm, filter, search, pagination |
| Chi tiết sản phẩm | Hiển thị thông tin chi tiết của sản phẩm |
| Giỏ hàng | Thêm, sửa số lượng, xóa sản phẩm khỏi giỏ |
| Thanh toán | Tạo đơn hàng |
| Đăng ký | Tạo tài khoản user |
| Đăng nhập | Đăng nhập user/admin |
| Đăng xuất | Hủy session người dùng |
| Lịch sử đơn hàng | User xem các đơn đã đặt |

---

### Admin Dashboard

| Chức năng | Mô tả |
|---|---|
| Dashboard | Thống kê user, sản phẩm, đơn hàng, doanh thu |
| Quản lý danh mục | Thêm, sửa, ẩn danh mục |
| Quản lý sản phẩm | Thêm, sửa, ẩn sản phẩm, upload ảnh |
| Quản lý đơn hàng | Xem đơn, xem chi tiết, cập nhật trạng thái |
| Quản lý người dùng | Xem user, khóa/mở tài khoản |
| Log hệ thống | Xem IP, browser, hành động login/logout/register |
| Cài đặt website | Cập nhật logo, banner, màu, font, thông báo |

---

## 🗄️ Database Schema

Database chính:

```sql
CREATE DATABASE fruit_shop
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

---

## 1. Bảng `users`

Lưu thông tin người dùng và admin.

```txt
users
├── id
├── name
├── email
├── password_hash
├── phone
├── address
├── role
├── avatar
├── status
├── created_at
└── updated_at
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| name | VARCHAR(100) | Tên người dùng |
| email | VARCHAR(255) | Email đăng nhập |
| password_hash | VARCHAR(255) | Mật khẩu đã hash |
| phone | VARCHAR(20) | Số điện thoại |
| address | TEXT | Địa chỉ giao hàng |
| role | ENUM | `user`, `admin` |
| avatar | VARCHAR(255) | Ảnh đại diện |
| status | ENUM | `active`, `blocked` |
| created_at | TIMESTAMP | Ngày tạo |
| updated_at | TIMESTAMP | Ngày cập nhật |

---

## 2. Bảng `categories`

Lưu danh mục sản phẩm.

```txt
categories
├── id
├── name
├── slug
├── description
├── image
├── status
├── created_at
└── updated_at
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| name | VARCHAR(100) | Tên danh mục |
| slug | VARCHAR(120) | Slug SEO |
| description | TEXT | Mô tả danh mục |
| image | VARCHAR(255) | Ảnh danh mục |
| status | ENUM | `active`, `hidden` |
| created_at | TIMESTAMP | Ngày tạo |
| updated_at | TIMESTAMP | Ngày cập nhật |

---

## 3. Bảng `products`

Lưu thông tin sản phẩm trái cây.

```txt
products
├── id
├── category_id
├── name
├── slug
├── description
├── price
├── sale_price
├── stock
├── unit
├── image
├── status
├── created_at
└── updated_at
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| category_id | INT | ID danh mục |
| name | VARCHAR(150) | Tên sản phẩm |
| slug | VARCHAR(180) | Slug SEO |
| description | TEXT | Mô tả sản phẩm |
| price | DECIMAL(10,2) | Giá gốc |
| sale_price | DECIMAL(10,2) | Giá khuyến mãi |
| stock | INT | Số lượng tồn kho |
| unit | VARCHAR(50) | Đơn vị tính, ví dụ: kg, hộp, trái |
| image | VARCHAR(255) | Ảnh sản phẩm |
| status | ENUM | `active`, `hidden`, `out_of_stock` |
| created_at | TIMESTAMP | Ngày tạo |
| updated_at | TIMESTAMP | Ngày cập nhật |

---

## 4. Bảng `orders`

Lưu thông tin đơn hàng.

```txt
orders
├── id
├── user_id
├── customer_name
├── customer_phone
├── customer_address
├── total_amount
├── note
├── status
├── payment_method
├── payment_status
├── created_at
└── updated_at
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| user_id | INT | ID user đặt hàng, có thể NULL nếu khách vãng lai |
| customer_name | VARCHAR(100) | Tên khách hàng |
| customer_phone | VARCHAR(20) | Số điện thoại |
| customer_address | TEXT | Địa chỉ giao hàng |
| total_amount | DECIMAL(10,2) | Tổng tiền |
| note | TEXT | Ghi chú đơn hàng |
| status | ENUM | `pending`, `confirmed`, `shipping`, `completed`, `cancelled` |
| payment_method | ENUM | `cod`, `bank_transfer` |
| payment_status | ENUM | `unpaid`, `paid` |
| created_at | TIMESTAMP | Ngày tạo |
| updated_at | TIMESTAMP | Ngày cập nhật |

---

## 5. Bảng `order_items`

Lưu chi tiết sản phẩm trong từng đơn hàng.

```txt
order_items
├── id
├── order_id
├── product_id
├── product_name
├── product_price
├── quantity
├── unit
└── subtotal
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| order_id | INT | ID đơn hàng |
| product_id | INT | ID sản phẩm |
| product_name | VARCHAR(150) | Tên sản phẩm tại thời điểm đặt |
| product_price | DECIMAL(10,2) | Giá sản phẩm tại thời điểm đặt |
| quantity | INT | Số lượng mua |
| unit | VARCHAR(50) | Đơn vị tính |
| subtotal | DECIMAL(10,2) | Thành tiền |

---

## 6. Bảng `logs`

Lưu lịch sử hành động của user/admin.

```txt
logs
├── id
├── user_id
├── action
├── ip_address
├── browser
├── url
├── method
└── created_at
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| user_id | INT | ID user thực hiện hành động |
| action | VARCHAR(100) | Hành động: login, logout, register, create_product... |
| ip_address | VARCHAR(45) | Địa chỉ IP |
| browser | TEXT | Thông tin trình duyệt |
| url | TEXT | URL truy cập |
| method | VARCHAR(10) | HTTP method |
| created_at | TIMESTAMP | Thời gian tạo log |

---

## 7. Bảng `web_settings`

Lưu cấu hình website.

```txt
web_settings
├── id
├── setting_key
├── setting_value
├── type
└── updated_at
```

| Cột | Kiểu dữ liệu | Mô tả |
|---|---|---|
| id | INT | Khóa chính |
| setting_key | VARCHAR(100) | Tên setting |
| setting_value | TEXT | Giá trị setting |
| type | VARCHAR(50) | Kiểu dữ liệu: text, image, color, textarea |
| updated_at | TIMESTAMP | Ngày cập nhật |

Ví dụ dữ liệu trong `web_settings`:

```txt
site_name
logo
banner
primary_color
font_family
homepage_notice
footer_content
```

---

## 🔗 Quan Hệ Giữa Các Bảng

```txt
users 1 - n orders

users 1 - n logs

categories 1 - n products

orders 1 - n order_items

products 1 - n order_items
```

Giải thích:

- Một user có thể có nhiều đơn hàng.
- Một user/admin có thể tạo nhiều log.
- Một danh mục có nhiều sản phẩm.
- Một đơn hàng có nhiều sản phẩm thông qua bảng `order_items`.
- Một sản phẩm có thể xuất hiện trong nhiều đơn hàng.

---

## 🧭 Sitemap Chức Năng

| Khu vực | Trang / Chức năng | URL gợi ý | Quyền truy cập |
|---|---|---|---|
| Public | Trang chủ | `/` | Tất cả |
| Public | Danh sách sản phẩm | `/products` | Tất cả |
| Public | Chi tiết sản phẩm | `/products/detail.php?slug=product-slug` | Tất cả |
| Public | Giỏ hàng | `/cart` | Tất cả |
| Public | Thanh toán | `/checkout` | Tất cả |
| Public | Đăng ký | `/register` | Guest |
| Public | Đăng nhập | `/login` | Guest |
| User | Thông tin tài khoản | `/account` | User |
| User | Lịch sử đơn hàng | `/account/orders` | User |
| Admin | Dashboard | `/admin` | Admin |
| Admin | Quản lý danh mục | `/admin/categories` | Admin |
| Admin | Quản lý sản phẩm | `/admin/products` | Admin |
| Admin | Quản lý đơn hàng | `/admin/orders` | Admin |
| Admin | Quản lý người dùng | `/admin/users` | Admin |
| Admin | Log hệ thống | `/admin/logs` | Admin |
| Admin | Cài đặt website | `/admin/settings` | Admin |

---

## 🔐 Authentication & Authorization

Dự án sử dụng `session` để quản lý đăng nhập.

### Role

```txt
user
admin
```

### Middleware cơ bản

```txt
requireAuth()
requireAdmin()
```

### Flow đăng nhập

```txt
User nhập email/password
        ↓
Tìm user bằng email
        ↓
Kiểm tra password bằng password_verify()
        ↓
Lưu thông tin user vào session
        ↓
Redirect theo role
```

Nếu `role = admin` thì cho vào trang admin.

Nếu `role = user` thì cho vào trang người dùng.

---

## 🧾 Quy Tắc Làm Việc Với Database

- Không lưu mật khẩu thô.
- Luôn dùng `password_hash()` để hash mật khẩu.
- Luôn dùng `password_verify()` để kiểm tra mật khẩu.
- Luôn dùng Prepared Statement để tránh SQL Injection.
- Không xóa cứng sản phẩm/danh mục nếu không cần.
- Nên dùng `status = hidden` để ẩn dữ liệu.
- Đơn hàng cũ phải giữ lại `product_name` và `product_price` trong `order_items`.

---

## 📝 Quy Tắc Code

- Viết code rõ ràng, dễ đọc.
- Đặt tên biến, hàm, class bằng tiếng Anh.
- Tách biệt Controller, Model và View.
- Không viết SQL trực tiếp trong View.
- Không xử lý logic phức tạp trong View.
- Validate dữ liệu trước khi insert/update.
- Comment những đoạn code khó hiểu.
- Ưu tiên dùng Prepared Statement khi query Database.

---

## 👥 Gợi Ý Chia Task Nhóm

| Thành viên | Task |
|---|---|
| Người 1 | Auth, User, Log |
| Người 2 | Category, Product, Upload ảnh |
| Người 3 | Cart, Checkout, Order |
| Người 4 | Admin Dashboard, Web Settings, UI Layout |

---

## 🚀 Bắt Đầu Dự Án

### 1. Clone repository

```bash
git clone <repository-url>
```

### 2. Cấu hình Database

Mở file:

```txt
config/connection.php
```

Cập nhật thông tin kết nối:

```php
DB_HOST=localhost
DB_NAME=fruit_shop
DB_USER=root
DB_PASS=
```

### 3. Import Database

Import file:

```txt
database/schema.sql
```

vào MySQL bằng phpMyAdmin, MySQL Workbench hoặc WebStorm Database.

### 4. Chạy ứng dụng

Có thể chạy bằng XAMPP, Laragon hoặc PHP built-in server.

```bash
php -S localhost:8000
```

Sau đó truy cập:

```txt
http://localhost:8000
```

---

## 📌 Ghi Chú

Dự án này phù hợp để học và thực hành:

- PHP thuần
- MySQL
- MVC Pattern
- Authentication
- CRUD
- Upload file
- Admin Dashboard
- Quản lý đơn hàng
- Làm việc nhóm với GitHub

---

## ❤️ Made with Love

Dự án được xây dựng bởi nhóm phát triển website bán trái cây.
