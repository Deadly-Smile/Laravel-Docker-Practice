setup:
	@make build
	@make up 
	@make composer-update
	@make data
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec laravel-docker bash -c "composer update"
data:
	docker exec laravel-docker bash -c "php artisan migrate"
	docker exec laravel-docker bash -c "php artisan db:seed"
extra:
	cd laravel-app
	sudo chmod o+w ./storage/ -R
	sudo chown www-data:www-data -R ./storage
