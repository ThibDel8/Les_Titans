# Variables
CONSOLE=php bin/console
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
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:drop --force --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:create --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:migrations:migrate --no-interaction --env=dev
	$(COMPOSE_PHP) $(CONSOLE) app:create-admin-account --env=dev
	$(COMPOSE_PHP) $(CONSOLE) doctrine:fixtures:load --no-interaction --append --env=dev
	$(MAKE) cache-clear

tf-db:
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:drop --force --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:database:create --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:migrations:migrate --no-interaction --env=test
	$(COMPOSE_PHP) $(CONSOLE) app:create-admin-account --env=test
	$(COMPOSE_PHP) $(CONSOLE) doctrine:fixtures:load --no-interaction --append --env=test
	$(MAKE) cache-clear

# ---------------------------
# Symfony Commands Shortcut
# ---------------------------

bash:
	docker exec -it les_titans_php bash

