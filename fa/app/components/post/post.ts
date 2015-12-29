import {APIGetService} from '../../services/apigetservice';
import {PostQuery} from "../../models/postquery";
import {Player} from "../../models/player";
import {Query} from "../../models/query";
import {GameType} from "../../models/gametype";
import {CharacterType} from "../../models/charactertype";
import {APIPostService} from "../../services/apipostservice";
import {Component} from "angular2/core";
import {FormBuilder} from "angular2/common";
import {CORE_DIRECTIVES} from "angular2/common";
import {FORM_DIRECTIVES} from "angular2/common";
import {NgFor} from "angular2/common";
import {NgIf} from "angular2/common";
import {ControlGroup} from "angular2/common";

@Component({
    selector: 'post',
    providers:[APIGetService, APIPostService],
    viewBindings: [FormBuilder],
    templateUrl: './app/components/post/post.html',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES, NgFor, NgIf]
})

export class Post {
    items: Array<string>;
    posts: Array<PostQuery> = [];
    postService: APIPostService;
    postForm: ControlGroup;
    response: any;
    playerTypes: Array<string> = ['Demon Hunter', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader'];
    queryGameLevels: Array<string> = ['0+', '10+', '20+', '30+', '40+', '50+', '60+', '70+', '80+'];
    queryGameTypes: Array<string> = ['Rift', 'Grift', 'PowerGrift', 'Bounties', 'Keywardens', 'Ubers'];

    constructor(getService:APIGetService, postService:APIPostService, formBuilder: FormBuilder) {
        this.postService = postService;
        this.postForm = formBuilder.group({
            playerType: [''],
            playerParagonPoints: [''],
            playerBattleTag: [''],
            playerRegion: [''],
            playerGameType: [''],
            queryMinParagon: [''],
            queryGameLevel: [''],
            queryGameType: [''],
            queryCharacterType: ['']
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
