docker run --rm -ti -v /home/agnieszka/Code/RiftRun/:/var/www/html/riftrun --workdir=/var/www/html/riftrun deployment_phpfpm /usr/local/php7/bin/php app/console riftrun:database:seed test/Fixtures/DatabaseSeeder/GameType/grift_x10.yml test/Fixtures/DatabaseSeeder/CharacterClass/characterclass_x10.yml test/Fixtures/DatabaseSeeder/SearchQuery/searchquery_x10.yml test/Fixtures/DatabaseSeeder/Character/monks_x10.yml test/Fixtures/DatabaseSeeder/Post/post_x10.yml
