import { APIGetService } from '../../../services/apigetservice';
import { PostQuery } from '../../../models/postquery';
import { APIPostService } from '../../../services/apipostservice';
import { Component, OnInit } from '@angular/core';
import { PostFactory } from "../../../utils/postFactory";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import { PostListDto } from "./post-list-dto";

@Component({
    selector: 'post-list',
    providers: [ APIPostService, PostFactory ],
    // viewProviders: [FormBuilder],
    templateUrl: './post-list.html',
    // directives: [NgFor, NgIf]
})

export class PostListComponent implements OnInit {
    private items: Array<string>;
    private posts: Array<PostQuery> = [];
    private postForm: FormGroup;
    private response: any;
    private postListDto: PostListDto;
    private playerTypes: Array<string> = ['Demon Hunter', 'Wizard', 'Witch Doctor', 'Barbarian', 'Crusader', 'Necromancer'];
    private playerRegions: Array<string> = ['EU', 'US', 'ASIA'];
    private queryGameLevels: Array<string> = ['0+', '10+', '20+', '30+', '40+', '50+', '60+', '70+', '80+', '90+', '100+'];
    private queryGameTypes: Array<string> = ['Rift', 'Grift', 'Bounties', 'Keywardens', 'Ubers', 'Goblins'];

    ngOnInit():void {
        this.postForm = this.formBuilder.group({
            'playerType': [this.postListDto.playerType, [Validators.required]],
            'playerParagonPoints': [this.postListDto.playerParagonPoints, [Validators.required]],
            'playerBattleTag': [this.postListDto.playerBattleTag, [Validators.required]],
            'playerGameType': [this.postListDto.playerGameType],
            'playerRegion': [this.postListDto.playerRegion, [Validators.required]],
            'queryMinParagon': [this.postListDto.queryMinParagon, [Validators.required]],
            'queryGameLevel': [this.postListDto.queryGameLevel, [Validators.required]],
            'queryGameType': [this.postListDto.queryGameType, [Validators.required]],
            'queryCharacterType': [this.postListDto.queryCharacterType, [Validators.required]]
            // playerType: ['Demon Hunter'],
            // playerParagonPoints: [''],
            // playerBattleTag: [''],
            // playerRegion: ['EU'],
            // playerGameType: ['seasonal'],
            // queryMinParagon: ['15'],
            // queryGameLevel: ['40+'],
            // queryGameType: ['grift'],
            // queryCharacterType: ['demon hunter']
        });

        this.postForm.valueChanges.subscribe(data => this.onValueChanged(data));
        this.onValueChanged();

        this.getService.get('http://riftrun.local/v1/posts')
            .map((posts: any) => {
                return this.postFactory.buildPosts(posts);
            })
            .subscribe(response => this.posts = response);
    }

    constructor(
        private getService:APIGetService,
        private postService:APIPostService,
        private formBuilder: FormBuilder,
        private postFactory: PostFactory,
    ) {
        this.postListDto = new PostListDto();
    }

    postContent(item:any) {
        console.log(item);
        this.postService.postContent(item);
    }

    onSelect(element) {
        console.log(element);
    }

    private onValueChanged(data?: any) {
        if (!this.postForm) { return; }
        const form = this.postForm;

        // for (const field in this.formErrors) {
        //     // clear previous error message (if any)
        //     this.formErrors[field] = '';
        //     const control = form.get(field);
        //
        //     if (control && control.dirty && control.invalid) {
        //         const messages = this.validationMessages[field];
        //
        //         for (const key in control.errors) {
        //             this.formErrors[field] += messages[key] + ' ';
        //         }
        //     }
        // }
    }

    submit() {
        this.postListDto = this.postForm.value;
        console.log(JSON.stringify(this.postListDto));
    }
}
