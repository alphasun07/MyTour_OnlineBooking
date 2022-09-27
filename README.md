## Introduction

#### 1. Localhost (xampp)
RUN
- composer update --ignore-platform-req=ext-gd
- composer dump-autoload
- cp .env.example .env
- php artisan key:generate
- config database in file .env
- php artisan config:cache
- php artisan cache:clear
- php artisan migrate
- php artisan db:seed
- php artisan storage:link

