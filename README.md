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
- メールを用いた認証（応用要件）
- 認証メール再送機能（応用要件）
- Stripe決済（応用要件）

## 環境構築

### Dockerビルド

1. `git clone` git@github.com:misaki-m11111/laravel-fleamarket-app.git  
2. Docker Desktopアプリを立ち上げる
3. 以下のコマンドを実行する

```bash
docker compose up -d --build
```

※ MySQLは、OSによって起動しない場合があるため、それぞれのPCに合わせて `docker-compose.yml` ファイルを編集してください。

## Laravel環境構築

1. PHPコンテナに入る

```bash
docker compose exec php bash
```

2. Composerパッケージをインストールする

```bash
composer install
```

3. `.env` ファイルを作成する

```bash
cp .env.example .env
```

4. `.env` ファイルの一部を以下のように編集する

```env
DB_HOST=mysql
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass  
```

5. アプリケーションキーを作成する

```bash
php artisan key:generate
```

6. マイグレーションを実行する

```bash
php artisan migrate
```

7. シーディングを実行する

```bash
php artisan db:seed
```

8. シンボリックリンクを作成する

```bash
php artisan storage:link
```

## メール認証

本アプリでは、新規会員登録時にMailHogを使用してメール認証を行います。

MailHog: http://localhost:8025

### 確認手順

1. 新規会員登録を行う
2. MailHogを開く
3. 受信した認証メール内のリンクをクリックする
4. 認証後、アプリ画面へ遷移することを確認する

## Stripe

本アプリでは、商品購入の決済としてStripe Checkoutを使用しています。

Stripeを使用するため、`.env` に以下を設定してください。  
`STRIPE_KEY` と `STRIPE_SECRET` は、Stripeダッシュボードのテスト環境から取得してください。

```env
STRIPE_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
STRIPE_SECRET=sk_test_xxxxxxxxxxxxxxxxxxxxx
```

### Stripe決済の動作確認

1. ログインします。
2. 商品詳細ページから「購入手続きへ」をクリックします。
3. 支払い方法を選択します。
4. 購入ボタンをクリックします。
5. Stripe Checkout画面に遷移することを確認します。
6. 支払い方法を入力して決済を完了します。
7. 決済完了後、アプリの完了ページまたはトップページに戻ることを確認します。

## 使用技術（実行環境）

| 技術 | バージョン |
|---|---|
| PHP | 8.1.33 |
| Laravel | 8.83.8 |
| MySQL | 8.0.26 |
| Nginx | 1.21 |

## ER図

<img width="1502" height="1141" alt="fleamarket-app-er" src="https://github.com/user-attachments/assets/e28bfd41-9c5c-48c3-ab54-b1d9e8567bdc" />

## テーブル設計

### usersテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | ユーザーID |
| name | string | not null | ユーザー名 |
| email | string | not null / unique | メールアドレス |
| email_verified_at | timestamp | nullable | メール認証日時 |
| password | string | not null | パスワード |
| remember_token | string | nullable | ログイン保持用トークン |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### profilesテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | プロフィールID |
| user_id | bigint | foreign key / unique | ユーザーID |
| image | string | nullable | プロフィール画像 |
| post_code | string | not null | 郵便番号 |
| address | string | not null | 住所 |
| building | string | nullable | 建物名 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### itemsテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | 商品ID |
| user_id | bigint | foreign key | 出品者ID |
| name | string | not null | 商品名 |
| image | string | not null | 商品画像 |
| price | integer | not null | 価格 |
| brand_name | string | nullable | ブランド名 |
| description | text | not null | 商品説明 |
| condition | tinyInteger | not null | 商品状態 |
| sold_at | timestamp | nullable | 購入日時 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### commentsテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | コメントID |
| user_id | bigint | foreign key | ユーザーID |
| item_id | bigint | foreign key | 商品ID |
| content | text | not null | コメント内容 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### likesテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | いいねID |
| user_id | bigint | foreign key / unique(item_idと複合) | ユーザーID |
| item_id | bigint | foreign key / unique(user_idと複合) | 商品ID |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### categoriesテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | カテゴリーID |
| name | string | not null / unique | カテゴリー名 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### category_itemテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | カテゴリー商品ID |
| item_id | bigint | foreign key / unique(category_idと複合) | 商品ID |
| category_id | bigint | foreign key / unique(item_idと複合) | カテゴリーID |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

---

### purchasesテーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | bigint | primary key | 購入ID |
| user_id | bigint | foreign key | 購入者ID |
| item_id | bigint | foreign key / unique | 商品ID |
| post_code | string | not null | 配送先郵便番号 |
| address | string | not null | 配送先住所 |
| building | string | nullable | 配送先建物名 |
| payment_method | tinyInteger | not null | 支払い方法 |
| created_at | timestamp | nullable | 作成日時 |
| updated_at | timestamp | nullable | 更新日時 |

## URL

| ページ | URL |
|---|---|
| 商品一覧ページ | `/` |
| マイリスト | `/?tab=mylist` |
| 会員登録ページ | `/register` |
| ログイン画面 | `/login` |
| 商品詳細ページ | `/item/{item_id}` |
| 商品購入ページ | `/purchase/{item_id}` |
| 商品出品ページ | `/sell` |
| 住所変更ページ | `/purchase/address/{item_id}` |
| プロフィールページ | `/mypage` |
| プロフィール編集ページ | `/mypage/profile` |
| プロフィールページ（購入した商品一覧） | `/mypage?my=buy` |
| プロフィールページ（出品した商品一覧） | `/mypage?my=sell` |
| phpMyAdmin | http://localhost:8080 |

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

## PHPUnitテスト

本アプリでは、PHPUnitを使用してFeatureテストを実装しています。

### テスト準備

テスト実行前に、テスト用データベースを作成してください。

```bash
docker compose exec mysql bash
mysql -u root -p
```

```sql
CREATE DATABASE laravel_test;
exit;
```

`.env.testing` を以下のように設定します。

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_test
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

設定後、PHPコンテナ内で以下を実行します。

```bash
docker compose exec php bash
php artisan key:generate --env=testing
php artisan config:clear
```

### テスト実行方法

```bash
php artisan test
```

## 補足説明

- 権限エラーが発生した場合は、`storage` と `bootstrap/cache` の権限を確認してください。
- 一部UI制御にJavaScriptを使用しています。  
  対象ファイル: `views/purchase/create.blade.php`
- PHPUnit実行時は、外部API通信を防ぐため、`testing` 環境ではStripe処理をスキップしています。
