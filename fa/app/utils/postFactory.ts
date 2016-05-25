///<reference path="../../typings/browser.d.ts"/>
///<reference path="../../typings/browser/ambient/es6-shim/index.d.ts" />

import {PostQuery} from '../models/postquery';
import {Player} from '../models/player';
import {Query} from '../models/query';
import {GameType} from '../models/gametype';
import {CharacterType} from '../models/charactertype';
import {Component, Injectable} from '@angular/core';
import {CORE_DIRECTIVES} from "@angular/common";

@Component({
    directives: [CORE_DIRECTIVES]
})

@Injectable()
export class PostFactory {

    buildPosts (posts):Array<PostQuery> {
        let result:Array<PostQuery> = [];
        let characterTypes:Array<CharacterType> = [];
        posts._embedded.items.forEach((post) => {
            characterTypes.push(post.query.characterType.concat());
            result.push(new PostQuery(
                new Player(
                    post.player.id,
                    post.player.type,
                    post.player.paragonPoints,
                    post.player.battleTag,
                    post.player.region,
                    post.player.seasonal,
                    post.player.gametype
                ),
                new Query(
                    post.query.id,
                    post.query.minParagon,
                    new GameType(post.query.game.level, post.query.game.type),
                    characterTypes
                )
            ));
        });
        return result;
    }
}