///<reference path="../../../typings/browser.d.ts"/>
///<reference path="../../../typings/browser/ambient/es6-shim/index.d.ts" />
import {APIGetService} from '../../services/apigetservice';
import {PostQuery} from '../../models/postquery';
import {Player} from '../../models/player';
import {Query} from '../../models/query';
import {GameType} from '../../models/gametype';
import {CharacterType} from '../../models/charactertype';
import {APIPostService} from '../../services/apipostservice';
import {Component} from '@angular/core';
import {FORM_DIRECTIVES, CORE_DIRECTIVES, NgFor, NgIf, FormBuilder, ControlGroup} from '@angular/common';
import { MdCard } from '@angular2-material/card';
import { MdInput } from '@angular2-material/input';
import { MdButton } from '@angular2-material/button';

@Component({
    selector: 'post',
    providers:[APIGetService, APIPostService],
    viewBindings: [FormBuilder],
    templateUrl: './app/components/post/post.html',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES, MdCard, MdInput, MdButton, NgFor, NgIf]
})

export class Post {
    items: Array<string>;
    posts: Array<PostQuery> = [];
    postService: APIPostService;
    postForm: ControlGroup;
    response: any;
    playerTypes: Array<string> = ['Demon Hunter', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader'];
    playerRegions: Array<string> = ['EU', 'US', 'ASIA'];
    queryGameLevels: Array<string> = ['0+', '10+', '20+', '30+', '40+', '50+', '60+', '70+', '80+'];
    queryGameTypes: Array<string> = ['Rift', 'Grift', 'PowerGrift', 'Bounties', 'Keywardens', 'Ubers'];

    constructor(getService:APIGetService, postService:APIPostService, formBuilder: FormBuilder) {
        this.postService = postService;
        this.postForm = formBuilder.group({
            playerType: ['Demon Hunter'],
            playerParagonPoints: [''],
            playerBattleTag: [''],
            playerRegion: ['EU'],
            playerGameType: ['seasonal'],
            queryMinParagon: ['15'],
            queryGameLevel: ['40+'],
            queryGameType: ['grift'],
            queryCharacterType: ['demon hunter']
        });

        getService.get('http://riftrun.local/v1/posts')
                  .map((posts: any) => {
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
                  })
                  .subscribe(response => this.posts = response);
    }

    postContent(item:any) {
        this.postService.postContent(item);
    }
}
