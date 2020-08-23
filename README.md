#  Тестовое задание для компании OXEM

### Установка

1. Cначала надо склонировать репозиторий и перейти в папку
	> git clone https://github.com/DanilMazurkin/OxemTest.git oxem  
	> cd oxem
2. Установить пакеты
	> composer install
3. Cоздать .env файл
	> cp .env.example .env
4. Установить ключ проекта
	> php artisan key:generate
5. Установить следующие строки в .env
	> DB_HOST=localhost  
	> DB_DATABASE={имя_вашей_БД}
6. Ввести команду
	> php artisan config:cache
7. Запустить миграции
	> php artisan migrate
8. Установить ключи для passport
	> php artisan passport:install
9. Посеять данные в БД
	> php artisan db:seed
10. Запустить сервер
	> php artisan serve

### Работа с консольной командой


1. Для создания продуктов из products.json
    > php artisan product:create  
2. Для обновления продуктов из products.json
    > php artisan product:update
3. Для создания категорий из categories.json  
    > php artisan category:create  
4. Для обновления категорий из categories.json  
    > php artisan category:update
