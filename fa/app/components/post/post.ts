///<reference path="../../../typings/browser.d.ts"/>
///<reference path="../../../typings/browser/ambient/es6-shim/index.d.ts" />
import {APIGetService} from '../../services/apigetservice';
import {PostQuery} from '../../models/postquery';
import {APIPostService} from '../../services/apipostservice';
import {Component, OnInit} from '@angular/core';
import {FORM_DIRECTIVES, CORE_DIRECTIVES, NgFor, NgIf, FormBuilder, ControlGroup} from '@angular/common';
import { MdCard } from '@angular2-material/card';
import { MdInput } from '@angular2-material/input';
import { MdButton } from '@angular2-material/button';
import {PostFactory} from "../../utils/postFactory";
import {ModelSelector} from "../../directives/modelselector";

@Component({
    selector: 'post',
    providers:[APIGetService, APIPostService, PostFactory],
    viewBindings: [FormBuilder],
    templateUrl: './app/components/post/post.html',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES, ModelSelector, MdCard, MdInput, MdButton, NgFor, NgIf]
})

export class Post implements OnInit {
    items: Array<string>;
    posts: Array<PostQuery> = [];
    postService: APIPostService;
    getService: APIGetService;
    postFactory: PostFactory;
    postForm: ControlGroup;
    formBuilder: FormBuilder;
    response: any;
    playerTypes: Array<string> = ['Demon Hunter', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader'];
    playerRegions: Array<string> = ['EU', 'US', 'ASIA'];
    queryGameLevels: Array<string> = ['0+', '10+', '20+', '30+', '40+', '50+', '60+', '70+', '80+', '90+', '100+'];
    queryGameTypes: Array<string> = ['Rift', 'Grift', 'PowerGrift', 'Bounties', 'Keywardens', 'Ubers'];

    ngOnInit():void {
        this.postForm = this.formBuilder.group({
            playerType: [''],
            playerParagonPoints: [''],
            playerBattleTag: [''],
            playerRegion: [''],
            playerGameType: ['seasonal'],
            queryMinParagon: ['15'],
            queryGameLevel: ['40+'],
            queryGameType: ['grift'],
            queryCharacterType: ['demon hunter']
        });

        this.getService.get('http://riftrun.local/v1/posts')
            .map((posts: any) => {
                return this.postFactory.buildPosts(posts);
            })
            .subscribe(response => this.posts = response);
    }

    constructor(getService:APIGetService, postService:APIPostService, formBuilder: FormBuilder, postFactory: PostFactory) {
        this.getService = getService;
        this.postService = postService;
        this.postFactory = postFactory;
        this.formBuilder = formBuilder;
    }

    postContent(item:any) {
        console.log(item);
        this.postService.postContent(item);
    }
    onSelect(element) {
        console.log(element);
    }
}
