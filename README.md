🎬 OTT Platform

A modern OTT (Over-The-Top) streaming web platform built with Laravel 12 and Filament v5.

This application allows users to explore and consume different types of media content including:

🎥 Movies

📺 TV Shows

🎞 Reels / Short Videos

📰 Blogs / Articles

The platform includes a Filament Admin Panel where administrators can easily manage content, categories, media assets, and platform data.

Filament provides powerful forms, tables, dashboards, and CRUD interfaces that make it easy to build admin panels on top of Laravel.

✨ Features
🎥 Media Modules

The platform supports multiple content modules.

Movies

Movie listing

Movie details

Poster / media assets

Genre & metadata

TV Shows

TV show management

Seasons

Episodes

Streaming content

Reels

Short-form video content

Social media-style browsing

Quick media playback

Blogs

Articles

News & updates

Editorial content

🧑‍💻 Admin Panel (Filament)

The platform uses Filament v5 to manage backend content.

Admin capabilities include:

Manage Movies

Manage TV Shows

Manage Reels

Manage Blog Posts

Manage Categories

Upload media assets

Manage users

Dashboard statistics

Filament automatically generates:

CRUD forms

Tables

Filters

Admin pages

🧰 Tech Stack
Backend

PHP

Laravel 12

Admin Panel

Filament v5

Frontend

Blade

Tailwind CSS

Alpine.js

Database

MySQL

Tooling

Composer

Vite

Laravel Artisan

Git

📂 Project Architecture

The project follows the Laravel MVC architecture.

app/
 ├── Models
 │    ├── Movie.php
 │    ├── TvShow.php
 │    ├── Reel.php
 │    ├── Blog.php
 │    └── Category.php
 │
 ├── Filament
 │    ├── Resources
 │    │    ├── MovieResource.php
 │    │    ├── TvShowResource.php
 │    │    ├── ReelResource.php
 │    │    ├── BlogResource.php
 │    │    └── CategoryResource.php
 │
 │    ├── Pages
 │    └── Widgets
 │
 └── Http
      └── Controllers
🗄 Database Structure

The application uses Laravel migrations to manage database schema.

Example tables:

Table	Purpose
users	User accounts
movies	Movie data
tv_shows	TV series
reels	Short videos
blogs	Articles
categories	Content categories

Relationships may include:

Movies → Category

TV Shows → Seasons → Episodes

Blogs → Author

Reels → Media files

🎨 Frontend

The frontend uses Blade templates and TailwindCSS to build a responsive interface.

Users can:

Browse content

Watch videos

Read blogs

Explore media categories

⚙️ Installation
1 Clone the repository
git clone https://github.com/prashannraj/ott.git
cd ott
2 Install dependencies
composer install
npm install
3 Setup environment
cp .env.example .env

Configure database in .env:

DB_DATABASE=ott
DB_USERNAME=root
DB_PASSWORD=
4 Generate application key
php artisan key:generate
5 Run migrations
php artisan migrate

(Optional)

php artisan db:seed
6 Create Filament admin user
php artisan make:filament-user
7 Link storage
php artisan storage:link
8 Start development server
php artisan serve

Application URL

http://127.0.0.1:8000
🔐 Admin Panel

Filament admin panel:

/admin

Example:

http://127.0.0.1:8000/admin
📊 Admin Dashboard

Admin dashboard may include:

Total Movies

Total TV Shows

Total Blogs

Total Reels

User statistics

Content analytics

🚀 Future Improvements

Possible enhancements:

User authentication

Watchlist feature

Video streaming optimization

Ratings & reviews

Subscription system

Recommendation system

Advanced search

CDN video delivery

Mobile API

🧪 Development Commands

Useful Laravel commands:

php artisan migrate
php artisan migrate:fresh
php artisan db:seed
php artisan queue:work
php artisan optimize

Filament commands:

php artisan make:filament-resource
php artisan make:filament-page
php artisan make:filament-widget
📄 License

This project is licensed under the MIT License.

👨‍💻 Author

Prashann Raj

GitHub
https://github.com/prashannraj