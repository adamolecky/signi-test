init:
	docker exec -it drivvn-test-php-1 bin/console doctrine:database:drop --force
	docker exec -it drivvn-test-php-1 bin/console doctrine:database:create
	docker exec -it drivvn-test-php-1 bin/console doctrine:migrations:migrate
	docker exec -it drivvn-test-php-1 bin/console doctrine:fixtures:load
	docker exec -it drivvn-test-php-1 bin/console -e test doctrine:database:drop --force
	docker exec -it drivvn-test-php-1 bin/console -e test doctrine:database:create
	docker exec -it drivvn-test-php-1 bin/console -e test doctrine:schema:create

