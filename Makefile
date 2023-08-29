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