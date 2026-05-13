# 📋 Dự Án MVC PHP

## 🏗️ Mô Hình MVC

![Mô hình MVC](https://images.viblo.asia/beb9fe7b-f5c0-4cec-8c80-a82a2e8ce266.png)

Kiến trúc **Model - View - Controller** giúp tổ chức code gọn gàng và dễ bảo trì.

---

## 📁 Cấu Trúc Thư Mục

```
Ten_du_an/
├── assets/                 # Tài nguyên tĩnh
│   ├── fonts/             # Font chữ
│   ├── images/            # Hình ảnh
│   ├── javascripts/       # File JavaScript
│   └── css/               # File CSS
├── controllers/           # Logic ứng dụng
│   └── BaseController.php
├── models/                # Tương tác Database
│   └── BaseModel.php
├── views/                 # Giao diện người dùng
│   ├── components/        # Component tái sử dụng
│   ├── pages/             # Các trang riêng lẻ
│   └── layouts/
│       └── app.php        # Layout chính
├── config/                # Cấu hình
│   └── connection.php     # Kết nối Database
├── index.php              # Entry point
└── routes.php             # Định tuyến URL
```

---

## 🔄 Flow (Luồng Xử Lý)

1. **index.php** - Điểm vào của ứng dụng
2. **routes.php** - Xác định route và gọi Controller
3. **Controller** - Xử lý logic, gọi Model
4. **Model** - Tương tác với Database
5. **View** - Trả về giao diện cho người dùng

---

## 🛠️ Tech Stack

| Công Nghệ | Mục Đích |
|-----------|---------|
| **PHP** | Backend |
| **MySQL** | Database |
| **HTML** | Markup |
| **CSS/Tailwind/Bootstrap** | Styling |
| **JavaScript/jQuery/Alpine.js** | Frontend Interactivity |

---

## 📝 Quy Tắc Code

- Viết code clean, dễ đọc
- Tuân theo chuẩn PSR-2 cho PHP
- Đặt tên biến/hàm rõ ràng, tiếng Anh
- Comment ở những phần phức tạp
- Tách biệt Logic, View và Data

---

## 🎯 Thông Tin Các Folder

| Folder | Chức Năng |
|--------|----------|
| `assets` | Lưu trữ tài nguyên tĩnh (CSS, JS, hình ảnh) |
| `controllers` | Xử lý request, logic ứng dụng |
| `models` | Tương tác Database, CRUD |
| `views` | Giao diện HTML, template |
| `config` | Cấu hình ứng dụng (Database, ...) |

---

## 🚀 Bắt Đầu

1. Clone repository
2. Setup Database từ `config/connection.php`
3. Chạy ứng dụng trên server (Apache/Nginx)
4. Truy cập `http://localhost` để kiểm tra

---

## Schema:
```txt
- User:
  -- id
  -- name
  -- email
  -- password
  -- money
  -- token
  -- createAt
  -- updateAt
  
- Product
  -- id
  -- name
  -- price
  -- quantity
  -- short_description 
  -- full_description
  -- id_user
```

**Made with ❤️**
