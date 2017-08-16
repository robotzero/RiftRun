import { APIGetService } from '../../../services/apigetservice';
import { Post } from '../../../models/post';
import { APIPostService } from '../../../services/apipostservice';
import { Component, OnInit } from '@angular/core';
import { PostFactory } from "../../../utils/postFactory";
import {FormArray, FormBuilder, FormGroup, Validators} from "@angular/forms";
import { PostDTO } from "./post-dto";
import { PlayerType } from "./types/player-type";
import { GameType } from "./types/game-type";
import { RegionType } from "./types/region-type";
import { postTranformOut } from './utilities/postTrasform';
import { griftLevels } from './utilities/griftlevel-generator';
import { Observable } from "rxjs/Rx";
import {applySourceSpanToExpressionIfNeeded} from "@angular/compiler/src/output/output_ast";

@Component({
    selector: 'post-list',
    providers: [ APIPostService, PostFactory ],
    templateUrl: './post-list.html',
})

export class PostListComponent implements OnInit {
    private items: Array<string>;
    private posts: Array<Post> = [];
    private postForm: FormGroup;
    private response: any;
    private postListDto: PostDTO;
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
            'player': this.formBuilder.group({
                'type': ['', Validators.required],
                'paragonPoints': ['', Validators.required],
                'battleTag': ['', Validators.required],
                'region': ['', Validators.required],
                'gameType': ['', Validators.required],
                'seasonal': ['', Validators.required]
            }),
            'query': this.formBuilder.group({
                'minParagon': ['', Validators.required],
                'game': this.formBuilder.group({
                    'gameMode': ['', Validators.required],
                    'gameLevel': ['', Validators.required]
                }),

            }),
            'playerCharacters': this.buildQueryCharacters()
        });

        // this.postForm.valueChanges.subscribe(data => this.onValueChanged(data));
        // this.onValueChanged();
        // let countries=['US', 'Germany', 'France'];
        // this.setCountries(countries);
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
        // this.postListDto = new PostDTO();
    }

    get playerCharacters(): FormArray {
        return this.postForm.get('playerCharacters') as FormArray;
    };

    setCountries(countries:string[]) {

        //One Form Group for one country
        const countriesFGs = countries.map(country =>{
            let obj={};obj[country]=true;
            return this.formBuilder.group(obj)
        });

        const countryFormArray = this.formBuilder.array(countriesFGs);
        this.postForm.setControl('playerCharacters', countryFormArray);
    }

    postContent({ value, valid }: { value: PostDTO, valid: boolean }) {
        // this.postListDto = this.postForm.value;
        console.log(value);
        // console.log(postTranformOut(value));
        // this.postService.postContent(postTranformOut(value));
    }

    buildQueryCharacters() {
        const arr = this.playerTypes.map(playerType => {
            let obj = {
                type: playerType,
                selected: false
            };
            return this.formBuilder.control(obj);
        });
        return this.formBuilder.array(arr);
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
