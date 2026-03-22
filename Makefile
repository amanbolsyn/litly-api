-include .env
export

# first application installation 
.PHONY: install 
install: 
	cp .env.example .env
	docker compose up -d
	docker exec ${APP_NAME}-php php artisan migrate

# start docker containers
.PHONY: run
run: 
	docker compose up -d 

# stop docker containers
.PHONY: down 
down: 
	docker compose down 

# run new db migrations 
.PHONY: migrate
migrate:
	docker exec ${APP_NAME}_php php artisan migrate

# run already migreated migrations
.PHONY: fresh
fresh:
	docker exec ${APP_NAME}_php php artisan migrate:fresh


# seed the database
.PHONY: seed
seed:
	docker exec ${APP_NAME}_php php artisan db:seed

	


