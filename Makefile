-include .env
export

# first application installation 
.PHONY: install 
install: 
	cp .env.example .env
	docker compose up -d
	docker exec ${APP_NAME}_php composer install
	docker exec ${APP_NAME}_php php artisan key:generate
	docker exec ${APP_NAME}_php php artisan migrate
# minio configuraiton 
	sleep 3
	docker exec -it ${APP_NAME}_minio mc alias set myminio ${AWS_ENDPOINT} ${AWS_ACCESS_KEY_ID} ${AWS_SECRET_ACCESS_KEY}
	docker exec -t ${APP_NAME}_minio mc mb myminio/${APP_NAME}
	docker exec -it ${APP_NAME}_minio mc anonymous set download myminio/${APP_NAME}

# start docker containers
.PHONY: run
run: 
	docker compose up -d
	sleep 3
	docker exec -it ${APP_NAME}_minio mc alias set myminio ${AWS_ENDPOINT} ${AWS_ACCESS_KEY_ID} ${AWS_SECRET_ACCESS_KEY}
	docker exec -it ${APP_NAME}_minio mc anonymous set download myminio/${APP_NAME}

# stop docker containers
.PHONY: down 
down: 
	docker compose down 

# run new db migrations 
.PHONY: migrate
migrate:
	docker exec ${APP_NAME}_php php artisan migrate

# run already migreated migrations
# Don't run on prod unless you want to wipe all the data
.PHONY: fresh
fresh:
	docker exec ${APP_NAME}_php php artisan migrate:fresh
	docker exec ${APP_NAME}_minio mc rm --recursive --force myminio/${APP_NAME}


# seed the database
.PHONY: seed
seed:
	docker exec ${APP_NAME}_php php artisan db:seed

.PHONY: schedule
schedule: 
	docker exec ${APP_NAME}_php php artisan schedule:work
	


