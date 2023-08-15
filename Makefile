init:
	docker exec -it signi-git-php-1 bin/console doctrine:database:drop --force
	docker exec -it signi-git-php-1 bin/console doctrine:database:create
	docker exec -it signi-git-php-1 bin/console doctrine:migrations:migrate
	docker exec -it signi-git-php-1 bin/console doctrine:fixtures:load
	docker exec -it signi-git-php-1 bin/console -e test doctrine:database:create
	docker exec -it signi-git-php-1 bin/console -e test doctrine:schema:create

rebuild:
	docker exec -it signi-git-php-1 bin/console doctrine:database:drop --force
	docker exec -it signi-git-php-1 bin/console doctrine:database:create
	docker exec -it signi-git-php-1 bin/console doctrine:migrations:migrate
	docker exec -it signi-git-php-1 bin/console doctrine:fixtures:load
	docker exec -it signi-git-php-1 bin/console -e test doctrine:database:drop --force
	docker exec -it signi-git-php-1 bin/console -e test doctrine:database:create
	docker exec -it signi-git-php-1 bin/console -e test doctrine:schema:create
