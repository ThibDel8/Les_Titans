# =====================================
# Settings
# =====================================

MAKEFLAGS += --no-print-directory

CONSOLE=php bin/console
COMPOSE=docker compose
COMPOSE_EXEC=$(COMPOSE) exec php

# =====================================
# Docker
# =====================================

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

rebuild:
	$(COMPOSE) down -v --remove-orphans
	$(COMPOSE) up --build -d

bash:
	$(COMPOSE_EXEC) bash

# =====================================
# Installation
# =====================================

install:
	$(COMPOSE_EXEC) composer install
	$(MAKE) init-project

init-project:
	$(MAKE) create-database
	$(MAKE) cache-clear

# =====================================
# Symfony
# =====================================

cache-clear:
	$(COMPOSE_EXEC) $(CONSOLE) cache:clear

migrate:
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:migrations:migrate --no-interaction

# =====================================
# Database DEV
# =====================================

create-database:
	$(COMPOSE_EXEC) $(CONSOLE) app:clean-uploaded-file-fixture --env=dev
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:database:drop --force --if-exists --env=dev
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:database:create --env=dev
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:migrations:migrate --no-interaction --env=dev
	$(COMPOSE_EXEC) $(CONSOLE) app:create-admin-account --env=dev
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:fixtures:load --no-interaction --append --env=dev
	$(COMPOSE_EXEC) $(CONSOLE) cache:clear --env=dev

# =====================================
# Database TEST
# =====================================

test-db:
	$(COMPOSE_EXEC) $(CONSOLE) cache:clear --env=test
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:database:drop --force --if-exists --env=test
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:database:create --env=test
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:migrations:migrate --no-interaction --env=test
	$(COMPOSE_EXEC) $(CONSOLE) app:create-admin-account --env=test
	$(COMPOSE_EXEC) $(CONSOLE) doctrine:fixtures:load --no-interaction --append --env=test

# =====================================
# Tests
# =====================================

test:
	$(MAKE) test-db
	$(COMPOSE_EXEC) env XDEBUG_MODE=coverage php bin/phpunit --coverage-html var/coverage
	@if [ -d public/coverage ]; then rm -rf public/coverage; fi && cp -r var/coverage public/coverage

# =====================================
# PHP CS Fixer
# =====================================

qa:
	./vendor/bin/php-cs-fixer fix --verbose
