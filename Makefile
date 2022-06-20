.RECIPEPREFIX +=
.DEFAULT_GOAL := help

help:
	@echo "Welcome to IT Support, have you tried turning it off and on again?"

install:
	@composer install

test:
	@docker exec desafiobackend_php php artisan test

coverage:
	@docker exec desafiobackend_php ./vendor/bin/pest --coverage

migrate:
	@docker exec desafiobackend_php php artisan migrate

seed:
	@docker exec desafiobackend_php php artisan db:seed

fresh:
	@docker exec desafiobackend_php php artisan migrate:fresh

analyse:
	./vendor/bin/phpstan analyse --memory-limit=256m

generate:
	@docker exec desafiobackend_php php artisan ide-helper:models --write

nginx:
	@docker exec -it desafiobackend_nginx /bin/sh

php:
	@docker exec -it desafiobackend_php /bin/sh

mysql:
	@docker exec -it desafiobackend_mysql /bin/sh

redis:
	@docker exec -it desafiobackend_redis /bin/sh
