import {Component, View, NgFor, NgIf, CORE_DIRECTIVES} from 'angular2/angular2';
import {APIGetService} from '../../services/apigetservice';
import {PostQuery} from "../../models/postquery";
import {Player} from "../../models/player";
import {Query} from "../../models/query";
import {GameType} from "../../models/gametype";
import {CharacterType} from "../../models/charactertype";

@Component({
    selector: 'post',
    providers:[APIGetService]
})
@View({
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES, NgFor, NgIf]
})

export class Post {
    items: Array<string>;
    posts: Array<PostQuery> = [];

    constructor(getService:APIGetService) {
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
}
