
ifeq ($(shell uname), Darwin)
	SED_INPLACE_FLAG=-i ''
	XDEBUG_CLIENT_HOST := host.docker.internal
else
	SED_INPLACE_FLAG=-i
	XDEBUG_CLIENT_HOST := $(shell hostname -I | cut -d" " -f1)
endif

install: \
	install-docker-env-file \
	install-docker-compose-override \
	install-php-ini-files \
	install-docker-build \
	install-composer-packages \
	install-app-env-file \
	start

install-docker-env-file:
	cp -f ./docker/.env.example ./docker/.env

install-docker-compose-override:
	cp -f ./docker/compose.override.yml.example ./docker/compose.override.yml
	sed $(SED_INPLACE_FLAG) "s/HOST_UID:.*/HOST_UID: $(shell id -u)/" ./docker/compose.override.yml

install-php-ini-files:
	cp -f ./docker/php/assets/php.ini.example ./docker/php/assets/php.ini
	cp -f ./docker/php/assets/xdebug.ini.example ./docker/php/assets/xdebug.ini
	sed $(SED_INPLACE_FLAG) "s/XDEBUG_CLIENT_HOST/${XDEBUG_CLIENT_HOST}/" ./docker/php/assets/xdebug.ini

install-docker-build:
	cd ./docker && docker compose build

install-composer-packages:
	cd ./docker && docker compose run --rm -u www-data -it app bash -c "composer install"

install-app-env-file:
	cp -f ./src/.env.example ./src/.env
	cd ./docker && docker compose run --rm -u www-data app bash -c "php artisan key:generate"

start:
	cd ./docker && docker compose up -d
	@echo "Your application is available at: http://localhost:8087"

stop:
	cd ./docker && docker compose stop

clean:
	cd ./docker && docker compose down -v
	git clean -fdx -e .idea

cli-php:
	cd ./docker && docker compose run --rm -u www-data app bash -l
