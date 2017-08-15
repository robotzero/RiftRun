import {Component, Injectable} from '@angular/core';
import {Post} from "../models/post";
import {PlayerCharacter} from "../models/playercharacter";
import {Player} from "../models/player";
import {Query} from "../models/query";
import {Game} from "../models/game";

@Component({

})

@Injectable()
export class PostFactory {
    buildPosts (posts):Array<Post> {
        let result:Array<Post> = [];
        let characterTypes:Array<PlayerCharacter> = [];
        posts._embedded.items.forEach((post) => {
            characterTypes.push(post.query.playerCharacters.concat());
            result.push(new Post(
                new Player(
                    post.player.type,
                    post.player.paragonPoints,
                    post.player.battleTag,
                    post.player.region,
                    post.player.seasonal,
                    post.player.gametype
                ),
                new Query(
                    post.query.minParagon,
                    new Game(post.query.gameMode.level, post.query.gameMode.type),
                    characterTypes
                )
            ));
        });
        return result;
    }
}