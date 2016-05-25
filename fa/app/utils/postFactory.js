///<reference path="../../typings/browser.d.ts"/>
///<reference path="../../typings/browser/ambient/es6-shim/index.d.ts" />
System.register(['../models/postquery', '../models/player', '../models/query', '../models/gametype', '@angular/core', "@angular/common"], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var postquery_1, player_1, query_1, gametype_1, core_1, common_1;
    var PostFactory;
    return {
        setters:[
            function (postquery_1_1) {
                postquery_1 = postquery_1_1;
            },
            function (player_1_1) {
                player_1 = player_1_1;
            },
            function (query_1_1) {
                query_1 = query_1_1;
            },
            function (gametype_1_1) {
                gametype_1 = gametype_1_1;
            },
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (common_1_1) {
                common_1 = common_1_1;
            }],
        execute: function() {
            PostFactory = (function () {
                function PostFactory() {
                }
                PostFactory.prototype.buildPosts = function (posts) {
                    var result = [];
                    var characterTypes = [];
                    posts._embedded.items.forEach(function (post) {
                        characterTypes.push(post.query.characterType.concat());
                        result.push(new postquery_1.PostQuery(new player_1.Player(post.player.id, post.player.type, post.player.paragonPoints, post.player.battleTag, post.player.region, post.player.seasonal, post.player.gametype), new query_1.Query(post.query.id, post.query.minParagon, new gametype_1.GameType(post.query.game.level, post.query.game.type), characterTypes)));
                    });
                    return result;
                };
                PostFactory = __decorate([
                    core_1.Component({
                        directives: [common_1.CORE_DIRECTIVES]
                    }),
                    core_1.Injectable(), 
                    __metadata('design:paramtypes', [])
                ], PostFactory);
                return PostFactory;
            }());
            exports_1("PostFactory", PostFactory);
        }
    }
});

//# sourceMappingURL=postFactory.js.map
