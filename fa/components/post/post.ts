import {Component, View, NgFor, NgIf, CORE_DIRECTIVES} from 'angular2/angular2';
import {FORM_DIRECTIVES, FormBuilder, ControlGroup} from 'angular2/angular2';
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
    //playerType: string = 'Choose your class type.';

    constructor(getService:APIGetService, postService:APIPostService, formBuilder: FormBuilder) {
        this.postService = postService;
        this.postForm = formBuilder.group({
            newPost: [''],
            newQuery: [''],
            playerType: ['']
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

    onSelection(value) {
        //this.playerType = value.value;

        console.log(value);
        //console.log(this.postForm.controls['playerType']);
        //this.postForm.controls['playerType'].value = "clicked";
    }
}
