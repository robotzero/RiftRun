import {Component, View, NgFor, NgIf, CORE_DIRECTIVES} from 'angular2/angular2';
import {FORM_DIRECTIVES, FormBuilder, ControlGroup} from 'angular2/angular2';
import {Control} from 'angular2/angular2';
import {APIGetService} from '../../services/apigetservice';
import {PostQuery} from "../../models/postquery";
import {Player} from "../../models/player";
import {Query} from "../../models/query";
import {GameType} from "../../models/gametype";
import {CharacterType} from "../../models/charactertype";
import {APIPostService} from "../../services/apipostservice";

@Component({
    selector: 'post',
    providers:[APIGetService, APIPostService],
    viewBindings: [FormBuilder],
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES, NgFor, NgIf]
})

export class Post {
    items: Array<string>;
    posts: Array<PostQuery> = [];
    postService: APIPostService;
    postForm: ControlGroup;
    firstName = 'Agnieszkaa';
    response: any;
    playerTypes: Array<string> = ['Demon Hunner', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader'];
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

        console.log(getService.get('http://riftrun.local/v1/posts'));

    //    getService.get('http://riftrun.local/v1/posts')
    //              .map((posts: any) => {
    //                  let result:Array<PostQuery> = [];
    //                  let characterTypes:Array<CharacterType> = [];
    //                  posts._embedded.items.forEach((post) => {
    //                      characterTypes.push(post.query.characterType.concat());
    //                      result.push(new PostQuery(
    //                          new Player(
    //                              post.player.id,
    //                              post.player.type,
    //                              post.player.paragonPoints,
    //                              post.player.battleTag,
    //                              post.player.region,
    //                              post.player.seasonal,
    //                              post.player.gametype
    //                          ),
    //                          new Query(
    //                              post.query.id,
    //                              post.query.minParagon,
    //                              new GameType(post.query.game.level, post.query.game.type),
    //                              characterTypes
    //                          )
    //                      ));
    //                  });
    //                  return result;
    //              })
    //              .subscribe(response => this.posts = response);
    }

    postContent(item:any) {
        this.postService.postContent(item);
    }
}
