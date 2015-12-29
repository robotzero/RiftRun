System.register(['../../services/apigetservice', "../../services/apipostservice", "angular2/core", "angular2/common"], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var apigetservice_1, apipostservice_1, core_1, common_1, common_2, common_3, common_4, common_5;
    var Post;
    return {
        setters:[
            function (apigetservice_1_1) {
                apigetservice_1 = apigetservice_1_1;
            },
            function (apipostservice_1_1) {
                apipostservice_1 = apipostservice_1_1;
            },
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (common_1_1) {
                common_1 = common_1_1;
                common_2 = common_1_1;
                common_3 = common_1_1;
                common_4 = common_1_1;
                common_5 = common_1_1;
            }],
        execute: function() {
            Post = (function () {
                function Post(getService, postService, formBuilder) {
                    this.posts = [];
                    this.playerTypes = ['Demon Hunter', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader'];
                    this.queryGameLevels = ['0+', '10+', '20+', '30+', '40+', '50+', '60+', '70+', '80+'];
                    this.queryGameTypes = ['Rift', 'Grift', 'PowerGrift', 'Bounties', 'Keywardens', 'Ubers'];
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
                Post.prototype.postContent = function (item) {
                    this.postService.postContent(item);
                };
                Post = __decorate([
                    core_1.Component({
                        selector: 'post',
                        providers: [apigetservice_1.APIGetService, apipostservice_1.APIPostService],
                        viewBindings: [common_1.FormBuilder],
                        templateUrl: './app/components/post/post.html',
                        directives: [common_2.CORE_DIRECTIVES, common_3.FORM_DIRECTIVES, common_4.NgFor, common_5.NgIf]
                    }), 
                    __metadata('design:paramtypes', [apigetservice_1.APIGetService, apipostservice_1.APIPostService, common_1.FormBuilder])
                ], Post);
                return Post;
            })();
            exports_1("Post", Post);
        }
    }
});

//# sourceMappingURL=post.js.map
