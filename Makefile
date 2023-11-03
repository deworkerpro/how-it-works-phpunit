init: docker-down docker-build docker-up
down: docker-down

docker-build:
	docker compose pull
	docker compose build --pull

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

app:
	@docker compose run --rm app-php-cli php bin/app.php

app-test:
	@docker compose run --rm app-php-cli php bin/test.php
