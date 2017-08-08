import { APIGetService } from '../../../services/apigetservice';
import { PostQuery } from '../../../models/postquery';
import { APIPostService } from '../../../services/apipostservice';
import { Component, OnInit } from '@angular/core';
import { PostFactory } from "../../../utils/postFactory";
import { FormBuilder, FormGroup, Validators } from "@angular/forms";
import { PostListDto } from "./post-list-dto";
import { PlayerType } from "./types/player-type";
import { GameType } from "./types/game-type";
import { RegionType } from "./types/region-type";
import { postTranformOut } from './utilities/postTrasform';
import { griftLevels } from './utilities/griftlevel-generator';
import { Observable } from "rxjs/Rx";

@Component({
    selector: 'post-list',
    providers: [ APIPostService, PostFactory ],
    templateUrl: './post-list.html',
})

export class PostListComponent implements OnInit {
    private items: Array<string>;
    private posts: Array<PostQuery> = [];
    private postForm: FormGroup;
    private response: any;
    private postListDto: PostListDto;
    private playerTypes: Array<PlayerType> = [
        PlayerType.DEMON_HUNTER,
        PlayerType.WIZARD,
        PlayerType.WITCH_DOCTOR,
        PlayerType.BARBARIAN,
        PlayerType.CRUSADER,
        PlayerType.NECROMANCER
    ];
    private playerRegions: Array<RegionType> = [
        RegionType.NA,
        RegionType.EU,
        RegionType.AUS,
        RegionType.ASIA
    ];

    private queryGameLevels: Observable<string[]> = griftLevels().toArray();

    private queryGameTypes: Array<GameType> = [
        GameType.RIFT,
        GameType.GRIFT,
        GameType.BOUNTIES,
        GameType.KEYWARDENS,
        GameType.UBERS,
        GameType.GOBLINS
    ];

    ngOnInit():void {
        this.postForm = this.formBuilder.group({
            'playerType': [this.postListDto.playerType, [Validators.required]],
            'playerParagonPoints': [this.postListDto.playerParagonPoints, [Validators.required]],
            'playerBattleTag': [this.postListDto.playerBattleTag, [Validators.required]],
            'playerRegion': [this.postListDto.playerRegion, [Validators.required]],
            'playerGameType': [this.postListDto.playerGameType, [Validators.required]],
            'playerSeason': [this.postListDto.playerSeason, [Validators.required]],
            'queryMinParagon': [this.postListDto.queryMinParagon, [Validators.required]],
            'queryGameLevel': [this.postListDto.queryGameLevel, [Validators.required]],
            'queryGameType': [this.postListDto.queryGameType, [Validators.required]],
            'queryCharacterType': [this.postListDto.queryCharacterType, [Validators.required]]
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
        private getService: APIGetService,
        private postService: APIPostService,
        private formBuilder: FormBuilder,
        private postFactory: PostFactory,
    ) {
        this.postListDto = new PostListDto();
    }

    postContent(item:any) {
        this.postListDto = this.postForm.value;
        this.postService.postContent(postTranformOut(this.postListDto));
    }

    private onValueChanged(data?: any) {
        if (!this.postForm) {
            return;
        }
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
}
