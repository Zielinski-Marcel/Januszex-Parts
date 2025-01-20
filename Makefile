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
	@docker-compose up -d
	@touch ./public/hot
	@rm ./public/hot
	@docker-compose exec -it app npm run build
	@echo waiting for dusk
	@docker-compose exec -it app php artisan dusk

testfront:
	@docker-compose exec -it app npm run test

migrate:
	@docker-compose exec app php artisan migrate:fresh --seed

test:
	@docker-compose exec -it app php artisan test

infection:
	@docker-compose exec -it app vendor/bin/infection

testall: dusk test testfront infection


check-if-env-file-exist:
	@if [ ! -f ".env" ]; then \
	  echo ".env file does not exist. Create a .env file and adjust it." ;\
	  exit 1;\
	fi; \
