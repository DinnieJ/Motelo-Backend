up:
	docker-compose up

up-daemon:
	docker-compose up -d

down:
	docker-compose down

status:
	docker-compose ps

build:
	cp api/.env.development api/.env
	docker-compose build
	docker-compose up -d
	docker-compose exec api composer install
	docker-compose exec api php artisan key:generate
	docker-compose exec api php artisan jwt:secret
	docker-compose exec api composer dump-autoload

tinker:
	docker-compose exec api php artisan tinker

db:
	docker-compose exec mysql mysql -uroot -proot
migrate:
	docker-compose exec api php artisan migrate

cache:
	docker-compose exec api php artisan config:cache
	docker-compose exec api php artisan cache:clear
	docker-compose exec composer dump-autoload
