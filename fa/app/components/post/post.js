var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var apigetservice_1 = require('../../services/apigetservice');
var apipostservice_1 = require("../../services/apipostservice");
var core_1 = require("angular2/core");
var common_1 = require("angular2/common");
var common_2 = require("angular2/common");
var common_3 = require("angular2/common");
var common_4 = require("angular2/common");
var common_5 = require("angular2/common");
var Post = (function () {
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
    }
    Post.prototype.postContent = function (item) {
        this.postService.postContent(item);
    };
    Post = __decorate([
        core_1.Component({
            selector: 'post',
            providers: [apigetservice_1.APIGetService, apipostservice_1.APIPostService],
            viewBindings: [common_1.FormBuilder],
            templateUrl: './components/post/post.html',
            directives: [common_2.CORE_DIRECTIVES, common_3.FORM_DIRECTIVES, common_4.NgFor, common_5.NgIf]
        }), 
        __metadata('design:paramtypes', [apigetservice_1.APIGetService, apipostservice_1.APIPostService, common_1.FormBuilder])
    ], Post);
    return Post;
})();
exports.Post = Post;

//# sourceMappingURL=post.js.map
