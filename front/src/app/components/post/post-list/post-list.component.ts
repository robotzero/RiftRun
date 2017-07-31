import { APIGetService } from '../../../services/apigetservice';
import { PostQuery } from '../../../models/postquery';
import { APIPostService } from '../../../services/apipostservice';
import { Component, OnInit } from '@angular/core';
import { PostFactory } from "../../../utils/postFactory";
import { FormBuilder, FormGroup } from "@angular/forms";
// import {FORM_DIRECTIVES, REACTIVE_FORM_DIRECTIVES, FormBuilder, FormGroup} from '@angular/forms';

@Component({
    selector: 'post-list',
    providers: [APIGetService, APIPostService, PostFactory],
    // viewProviders: [FormBuilder],
    templateUrl: './post-list.html',
    // directives: [NgFor, NgIf]
})

export class PostListComponent implements OnInit {
    items: Array<string>;
    posts: Array<PostQuery> = [];
    postService: APIPostService;
    getService: APIGetService;
    postFactory: PostFactory;
    postForm: FormGroup;
    formBuilder: FormBuilder;
    response: any;
    playerTypes: Array<string> = ['Demon Hunter', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader'];
    playerRegions: Array<string> = ['EU', 'US', 'ASIA'];
    queryGameLevels: Array<string> = ['0+', '10+', '20+', '30+', '40+', '50+', '60+', '70+', '80+', '90+', '100+'];
    queryGameTypes: Array<string> = ['Rift', 'Grift', 'Bounties', 'Keywardens', 'Ubers', 'Goblins'];

    ngOnInit():void {
        this.postForm = this.formBuilder.group({
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
