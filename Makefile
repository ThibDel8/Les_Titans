# Settings
MAKEFLAGS += --no-print-directory

# Variables
CONSOLE=php bin/console
COMPOSE=docker compose
COMPOSE_PHP=docker compose exec php

# ---------------------------
# Cache / Permissions
# ---------------------------

cache-clear:
	$(COMPOSE_PHP) $(CONSOLE) cache:clear

# ---------------------------
# Database / Fixtures Commands
# ---------------------------

create-database:
	$(COMPOSE_PHP) $(CONSOLE) app:clean-uploaded-file-fixture --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:drop --force --if-exists --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:create --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:migrations:migrate --no-interaction --env=dev
	$(COMPOSE_PHP) $(CONSOLE) app:create-admin-account --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:fixtures:load --no-interaction --append --env=dev
	$(COMPOSE_PHP) $(CONSOLE) cache:clear --env=dev

tf-db:
	$(COMPOSE_PHP) $(CONSOLE) cache:clear --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:drop --force --if-exists --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:create --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:migrations:migrate --no-interaction --env=test
	$(COMPOSE_PHP) $(CONSOLE) app:create-admin-account --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:fixtures:load --no-interaction --append --env=test

# ---------------------------
# Symfony Commands Shortcut
# ---------------------------

bash:
	docker exec -it les_titans_php bash

rebuild:
	$(COMPOSE) down -v --remove-orphans
	$(COMPOSE) up --build -d

# ---------------------------
# Tests PhpUnit
# ---------------------------

test:
	$(MAKE) tf-db
	$(COMPOSE_PHP) env XDEBUG_MODE=coverage php bin/phpunit --coverage-html var/coverage
