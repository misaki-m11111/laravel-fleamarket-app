# フリーマーケットアプリ（Laravel / 模擬案件1）

## 環境構築

Dockerビルド  
・git clone　
・docker compose up -d --build

## Dockerビルド

```bash
・git clone https://github.com/misaki-m11111/laravel-contact-form-test.git
・cd laravel-contact-form-test
・docker compose up -d --build
```

## Laravel環境構築

・docker compose exec php bash  
・composer install  
・cp .env.example .env  
・php artisan key:generate  
・php artisan migrate  
・php artisan db:seed

## 開発環境

・お問い合わせ画面：http://localhost  
・ユーザー登録：http://localhost/register

・管理画面：http://localhost/admin  
 （ログイン制御なし）  
 ※ログイン成功時は管理画面へ遷移する導線を実装しています。  
 ※ なお、本確認テストではミドルウェア指定を行っていないため、管理画面はログインなしでも閲覧可能です。

・phpMyAdmin：http://localhost:8080

## 使用技術(実行環境)

・PHP 8.1.33  
・Laravel 8.83.8  
・MySQL 8.0.26  
・Nginx 1.21  
・PHP 8.1.33
・Laravel 8.83.8
・MySQL 8.0.26
・Nginx 1.21

## ER図


※ 氏名については日本語表記に合わせ、  
DB・画面表示ともに「姓 → 名（last_name → first_name）」の順で扱っています。  
仕様書上の記載順（first_name → last_name）とは異なりますが、  
意図した設計判断によるものです。

## URL

・お問い合わせ画面：http://localhost  
・ユーザー登録：http://localhost/register  
・管理画面：http://localhost/admin  
 （ログイン制御なし）  
・phpMyAdmin：http://localhost:8080
