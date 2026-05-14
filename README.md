# フリーマーケットアプリ

## アプリケーション概要
ユーザー登録、ログイン、商品出品、商品購入、いいね、コメントなどができるフリーマーケットアプリです。

## 機能一覧
- 会員登録
- ログイン / ログアウト
- 商品一覧表示
- 商品詳細表示
- 商品検索
- 商品出品
- 商品購入
- 送付先住所変更
- いいね機能
- コメント機能
- マイページ表示
- プロフィール編集
- メールを用いた認証(応用要件)
- 認証メール再送機能(応用要件)
- 

## 環境構築

Dockerビルド  
・git clone  git@github.com:misaki-m11111/laravel-fleamarket-app.git  
・DockerDesktopアプリを立ち上げる  
・docker compose up -d --build  
 
 ※MySQL は、OS によって起動しない場合があるので、それぞれの PC に合わせて docker-compose.yml ファイルを編集してください。

## Laravel環境構築
1.docker compose exec php bash  
2.composer install  
3.cp .env.example .env  
4..env ファイルの一部を以下のように編集  

```bash
DB_HOST=mysql  
DB_DATABASE=laravel_db　　
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass　　
```
5.アプリケーションキーを作成 
```bash
php artisan key:generate  　
```
6.マイグレーションの実行
```bash
php artisan migrate
```
7.シーディングの実行
```bash
php artisan db:seed
```
8.シンボリックリンク作成
```bash
php artisan storage:link
```

## 使用技術(実行環境)
・PHP 8.1.33  
・Laravel 8.83.8  
・MySQL 8.0.26  
・Nginx 1.21  

## ER図
<img width="1502" height="1141" alt="fleamarket-app-er" src="https://github.com/user-attachments/assets/e28bfd41-9c5c-48c3-ab54-b1d9e8567bdc" />


## テーブル設計
- users
- items
- profiles
- comments
- likes
- categories
- category_item
- purchases
  
## URL
- 商品一覧ページ：/
- マイリスト：/?tab=mylist
- 会員登録ページ：/register
- ログイン画面：/login
- 商品詳細ページ：/item/{item_id}
- 商品購入ページ：/purchase/{item_id}
- 商品出品ページ：/sell
- 住所変更ページ：/purchase/address/{item_id}
- プロフィールページ：/mypage
- プロフィール編集ページ：/mypage/profile
- プロフィールページ（購入した商品一覧）：/mypage?my=buy
- プロフィールページ（出品した商品一覧）：/mypage?my=sell
- phpMyAdmin：http://localhost:8080

## テスト用アカウント

### 出品者アカウント

```txt
email: seller@example.com
password: password1234
```

### 購入者アカウント

```txt
email: buyer@example.com
password: password1234
```
※ Seederで作成されるユーザーはメール認証済みです。

## メール認証

新規登録時はメール認証を行ってください。

MailHog:
http://localhost:8025

## 補足説明　　　
・一部UI制御にJavaScriptを使用(views/purchase/create.blade.php)
