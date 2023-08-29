.PHONY: up
up: ## Create and start the services
	docker compose up --detach

.PHONY: build
build: ## Build or rebuild the services
	docker compose build --pull --no-cache

.PHONY: stop
stop: ## Stop the services
	docker compose stop

.PHONY: composer-install
composer-install: ## Install the dependencies
	docker compose exec php sh -lc 'composer install'

.PHONY: composer-update
composer-update: ## Update the dependencies
	docker compose exec php sh -lc 'composer update'

.PHONY: composer-check
composer-check: ## Check the platform requirements
	docker compose exec php sh -lc 'composer validate && composer check'

.PHONY: db-refresh
db-refresh: db-reset db-migrate ## Refresh the database migration

.PHONY: db-migrate
db-migrate: ## Start the database migration
	docker compose exec php sh -lc './bin/console doctrine:migrations:migrate --no-interaction'

.PHONY: db-reset
db-reset: ## Reset the database migration
	docker compose exec php sh -lc './bin/console doctrine:database:drop --if-exists --force'
	docker compose exec php sh -lc './bin/console doctrine:database:create'
