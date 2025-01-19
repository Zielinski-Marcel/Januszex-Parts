init: check-if-env-file-exist
	@docker-compose build

dev:
	@docker-compose up -d
	@docker-compose exec app /dev.sh

stop:
	@docker-compose stop

shell:
	@docker-compose exec -it app bash

dusk:
	@docker-compose exec -it app npm run build
	@echo waiting for dusk
	@docker-compose exec -it app php artisan dusk

migrate:
	@docker-compose exec app php artisan migrate:fresh --seed

check-if-env-file-exist:
	@if [ ! -f ".env" ]; then \
	  echo ".env file does not exist. Create a .env file and adjust it." ;\
	  exit 1;\
	fi; \
