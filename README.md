## Identitas Mahasiswa

Nama: **Muh Zayyan Al Thaaf Nur**  
NIM: **607062330072**  
Jurusan: **D3 Rekayasa Perangkat Lunak Aplikasi**

---

## Requirement Server

- PHP **8.2.27**
- Visual Studio Code
- MySQL
- POSTMAN

---

## Cara Setup Project

1. Clone Repository
2. Composer Install
3. Membuat Database (lunar-api)
4. php artisan migrate
5. php artisan ser

## Cara Mengetes API Menggunakan Postman

**Testing Endpoint Checkout**

POST http://127.0.0.1:8000/api/checkout
body(json)
{
  "amount": 150000
}


**Testing Webhook Payment (tanpa signature)**

POST http://127.0.0.1:8000/api/webhook/payment
body(json)
{
  "order_code": "order code dari checkout sebelumnya",
  "status": "PAID"
}

**Testing Webhook Payment (menggunakan signature)**

POST http://127.0.0.1:8000/api/webhook/payment
Header(Content-Type: application/json, X-Signature: mengambil dari laravel logs)
{
  "order_code": "order code dari checkout sebelumnya",
  "status": "PAID"
}


