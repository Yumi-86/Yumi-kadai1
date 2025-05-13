## アプリケーション名

お問い合わせフォーム

## 環境構築

・Docker ビルド

```
git clone リンク
docker-compose up -d --build
```

\*MySQL は、OS によって起動しない場合があるのでそれぞれの PC に合わせて docker-compsoe.yml ファイルを編集してください。

Laravel 環境構築
・composer のインストール

```
docker-compose exec php bash
composer install
```

・.env.example をコピーし.env ファイルを作成、環境変数の変更。

・アプリケーションキーの設定

```
php artisan key:generate

```

・マイグレーション、シーディングの実行

```
php artisan migrate
php artisan db:seed

```

##　使用技術

フレームワーク：Laravel 8.75
言語：PHP 7.4.9
データベース：MySQL 8.0
Web サーバー：Nginx 1.21.1
管理ツール：phpMyAdmin
実行環境：Docker（docker-compose v3.8）

## ER 図

![ER図](ER.drawio.png)

## URL

・環境構築 : http://localhost/
・phpMyAdmin : http://localhost:8080/

```

```
