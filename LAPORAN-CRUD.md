# Laporan Implementasi CRUD Toko Bunga

**Mata Kuliah:** Pemrograman Web Lanjutan  
**Nama:** Muhammad Syahrur  
**NIM:** 231240001362

---

## 1. Deskripsi Singkat

Toko Bunga adalah aplikasi web berbasis Laravel + Livewire yang menerapkan konsep CRUD (Create, Read, Update, Delete) untuk pengelolaan produk, pesanan, user, dan keranjang. Aplikasi ini mendukung peran admin dan customer, serta dilengkapi dashboard analitik dan UI/UX modern.

---

## 2. Rancangan Database

### 2.1. ERD (Entity Relationship Diagram)

```mermaid
erDiagram
    USER ||--o{ ORDER : membuat
    USER ||--o{ CART : memiliki
    ORDER ||--|{ ORDER_ITEM : terdiri_dari
    PRODUCT ||--o{ ORDER_ITEM : dipesan
    PRODUCT ||--o{ CART_ITEM : masuk_keranjang
    CART ||--|{ CART_ITEM : berisi

    USER {
        int id PK
        string name
        string email
        string password
        string role
        timestamp timestamps
    }
    PRODUCT {
        int id PK
        string name
        text description
        int stock
        int price
        string image
        timestamp timestamps
    }
    ORDER {
        int id PK
        int user_id FK
        string shipping_address
        string recipient_name
        string recipient_phone
        string status
        text notes
        int total_amount
        timestamp timestamps
    }
    ORDER_ITEM {
        int id PK
        int order_id FK
        int product_id FK
        int price
        int quantity
    }
    CART {
        int id PK
        int user_id FK
        timestamp timestamps
    }
    CART_ITEM {
        int id PK
        int cart_id FK
        int product_id FK
        int price
        int quantity
    }
```

### 2.2. Contoh Data

- **User**: name, email, password (hash), role
- **Product**: name, description, stock, price, image
- **Order**: user_id, shipping_address, recipient_name, recipient_phone, status, notes, total_amount
- **OrderItem**: order_id, product_id, price, quantity
- **Cart**: user_id
- **CartItem**: cart_id, product_id, price, quantity

---

## 3. Workflow CRUD & User Journey

### 3.1. Workflow Customer (Dari Registrasi hingga Pesan Selesai)
```mermaid
flowchart TD
    A[Register/Login] --> B[Lihat Daftar Produk]
    B --> C[Tambah ke Keranjang]
    C --> D[Lihat Keranjang]
    D --> E[Checkout]
    E --> F[Input Alamat & Data Penerima]
    F --> G[Buat Pesanan]
    G --> H[Status: Pending]
    H --> I[Admin Proses Pesanan]
    I --> J[Status: Processing]
    J --> K[Admin Tandai Selesai]
    K --> L[Status: Completed]
    G --> M[Customer Batalkan Pesanan]
    M --> N[Status: Canceled]
```

### 3.2. Workflow Admin (Manajemen CRUD)
```mermaid
flowchart TD
    AA[Login Admin] --> AB[Dashboard]
    AB --> AC[Kelola Produk]
    AB --> AD[Kelola User]
    AB --> AE[Lihat Pesanan Masuk]
    AE --> AF[Update Status Pesanan]
    AF --> AG[Pesanan Selesai]
    AC -->|Tambah/Edit/Hapus| AH[Database Produk]
    AD -->|Tambah/Edit/Hapus| AI[Database User]
```

### 3.3. Workflow CRUD Produk
```mermaid
sequenceDiagram
    participant Admin
    participant UI
    participant Livewire
    participant DB
    Admin->>UI: Klik Tambah/Edit/Hapus Produk
    UI->>Livewire: Kirim data produk
    Livewire->>DB: Simpan/Ubah/Hapus data
    DB-->>Livewire: Respon sukses/gagal
    Livewire-->>UI: Update tampilan & notifikasi
```

### 3.4. Workflow CRUD Order
```mermaid
sequenceDiagram
    participant Customer
    participant UI
    participant Livewire
    participant DB
    Customer->>UI: Checkout
    UI->>Livewire: Kirim data pesanan
    Livewire->>DB: Simpan order & order item
    DB-->>Livewire: Respon sukses
    Livewire-->>UI: Tampilkan status pesanan
    Admin->>UI: Update status pesanan
    UI->>Livewire: Kirim status baru
    Livewire->>DB: Update status order
    DB-->>Livewire: Respon sukses
    Livewire-->>UI: Update status di dashboard
```

---

## 4. Implementasi CRUD

### 4.1. Produk (Product)
- **Create:** Admin dapat menambah produk baru (nama, deskripsi, harga, stok, gambar).
- **Read:** Semua user dapat melihat daftar produk (public & admin panel).
- **Update:** Admin dapat mengedit detail produk.
- **Delete:** Admin dapat menghapus produk.

### 4.2. Pesanan (Order)
- **Create:** Customer membuat pesanan dari cart.
- **Read:** Customer & admin dapat melihat riwayat/detail pesanan.
- **Update:** Admin dapat mengubah status pesanan (pending, processing, completed).
- **Delete:** Customer dapat membatalkan pesanan selama status pending.

### 4.3. User
- **Create:** Register user baru (otomatis role customer).
- **Read:** Admin dapat melihat daftar user.
- **Update:** Admin dapat mengubah data user (opsional).
- **Delete:** Admin dapat menghapus user (opsional).

### 4.4. Cart & CartItem
- **Create:** Customer menambah produk ke keranjang.
- **Read:** Customer melihat isi keranjang.
- **Update:** Customer mengubah jumlah item di keranjang.
- **Delete:** Customer menghapus item dari keranjang.

---

## 5. Contoh Kode Model & Relasi (Laravel Eloquent)

```php
// app/Models/User.php
public function orders() { return $this->hasMany(Order::class); }
public function cart() { return $this->hasOne(Cart::class); }

// app/Models/Product.php
public function orderItems() { return $this->hasMany(OrderItem::class); }
public function cartItems() { return $this->hasMany(CartItem::class); }

// app/Models/Order.php
public function user() { return $this->belongsTo(User::class); }
public function items() { return $this->hasMany(OrderItem::class); }

// app/Models/OrderItem.php
public function order() { return $this->belongsTo(Order::class); }
public function product() { return $this->belongsTo(Product::class); }

// app/Models/Cart.php
public function user() { return $this->belongsTo(User::class); }
public function items() { return $this->hasMany(CartItem::class); }

// app/Models/CartItem.php
public function cart() { return $this->belongsTo(Cart::class); }
public function product() { return $this->belongsTo(Product::class); }
```

---

## 6. Visualisasi Alur CRUD

### 6.1. Alur CRUD Produk
```mermaid
flowchart TD
    A[Admin: Tambah/Edit/Hapus Produk] -->|Create/Update/Delete| B[Database Produk]
    C[User: Lihat Produk] -->|Read| B
```

### 6.2. Alur CRUD Pesanan
```mermaid
flowchart TD
    U[Customer: Checkout] -->|Create| O[Order]
    O -->|Read| U
    A[Admin: Update Status] -->|Update| O
    U -->|Cancel| O
```

---

## 7. Fitur Tambahan
- Dashboard analitik (Chart.js)
- SweetAlert2 konfirmasi hapus
- Livewire Alert notifikasi
- Validasi bahasa Indonesia
- Lacak pesanan tanpa login
- Responsive UI/UX

---

## 8. Penutup

Aplikasi ini mengimplementasikan seluruh aspek CRUD dengan relasi database yang jelas, UI modern, dan fitur analitik.