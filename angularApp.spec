Default front page get all.

Visitor point of view:
1. Buttons:
wizards, monks, barbs, dh, wd, all.

under buttons, filter area. (looking for part).
Filter as a form for each type or all types.

Form options:
Min Paragon points,
Character Class or classes -> one, two or any, (do we need extra buttons then for each type?)
Game Type (rift, keywardens, grift -> 40, 50, 60, 1%, bounties -> act1 act2 act3 act4) (choose only one)


Feature Front page.
As a visitor I would like to see unfiltered all paginated posts on the front page.
With buttons choosing how many posts I would like to see on the front. (max 100).
endpoint => /posts?page=1&rpp=?

Feature paragon points filtering.
When I filter paragon points to min 500
Character class defaults to any
Game type defaults to rift.
And click on filter, I will get only results with mininum 500 paragon points.
endpoint = /posts?page=1&rpp=?&q=paragonMin:500



sudo docker run --rm -ti -v /home/subzero/Code/RiftRun/:/var/www/html/riftrun --workdir=/var/www/html/riftrun deployment_phpfpm /usr/local/php7/bin/php bin/behat -c test/integration/behat.yml

curl -H "Content-Type: application/json" -X POST -d '{"player":{"type":"dh","paragonPoints":"13","battleTag":"20","region":"EU","seasonal":"false","gameType":"hardcore"},"query":{"minParagon":"10","game":{"level":"4"}}}' http://riftrun.local/v1/posts

curl -H "Content-Type: application/json" -X POST -d '{"player":{"type":"dh","paragonPoints":"13","battleTag":"#2000","region":"EU","seasonal":1,"gameType":"hardcore"},"query":{"minParagon":"10","game":{"type":"grift","level":"40+"},"characterType":[{"type":"dh"},{"type":"wizard"}]}}' http://riftrun.local/v1/posts

curl -H "Content-Type: application/json" -X POST -d '{"player":{"type":"demon hunter","paragonPoints":"13","battleTag":"#2000","region":"EU","seasonal":1,"gameType":"hardcore"},"query":{"minParagon":"10","game":{"type":"grift","level":"40+"},"characterType":[{"type":"demon hunter"},{"type":"wizard"}]}}' http://riftrun.local/v1/posts

curl -g -H "Content-Type: application/json" -X GET -d '{"player":{"type":"demon hunter","paragonPoints":"13","battleTag":"2000","region":"EU","seasonal":0,"gameType":"hardcore"},"query":{"minParagon":"10","game":{"gameMode":"bounties","torment":"5"},"playerCharacters":[{"type":"demon hunter"},{"type":"wizard"}]}}' "http://riftrun.local/v1/posts?filterParam[game]=player.paragonPoints&filterOp[game]=gt&filterValue[game]=10&filterParam[zomg]=game&filterOp[zomg]=eq&filterValue[zomg]=rift"

sudo docker run -it --rm --workdir /data jamesgroat/node-bower-gulp-tsd-sass tsd install angular2 es6-promise rx rx-lite
docker pull amitevski/docker-node-build

sudo docker run -it --rm -v /home/subzero/Code/RiftRun:/data --workdir=/data/fa dockerfile/nodejs-bower-gulp bower install --config.analytics=false --allow-root

https://github.com/Belkar/CampinaAsAService/blob/master/src/CampinaAsAService/app/main.ts#L1
https://github.com/angular/angular/issues/4504
https://github.com/angular/angular/issues/4759
https://github.com/rolandjitsu/ng2-lab
