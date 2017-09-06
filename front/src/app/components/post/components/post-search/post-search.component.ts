import { APIPostService } from '../../../../services/apipostservice';
import { Component, OnInit } from '@angular/core';
import { PostFactory } from "../../../../utils/postFactory";
import { FormArray, FormBuilder, FormGroup, Validators } from "@angular/forms";
import { Observable } from "rxjs/Rx";
import { GameModeService, GameModeState } from "../../../../services/gamemodeservice";
import { postTranformOut } from "../../../../utilities/postTrasform";
import {PostDTO} from "../post-list/post-dto";
import {PlayerType} from "../post-list/types/player-type";
import {RegionType} from "../post-list/types/region-type";
import {GameType} from "../post-list/types/game-type";

@Component({
    selector: 'post-search',
    providers: [ APIPostService, PostFactory, GameModeService ],
    templateUrl: 'post-search.html',
})

export class PostSearchComponent implements OnInit {
    private selectedGameMode: Observable<GameModeState> = this.gameModeService.currentStore;
    private currentGameMode: GameModeState;
    private postForm: FormGroup;
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

    constructor(
        private gameModeService: GameModeService,
        private postService: APIPostService,
        private formBuilder: FormBuilder,
        private postFactory: PostFactory
    ) {
        // this.postListDto = new PostDTO();
    }

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
                    'level': ['', Validators.nullValidator],
                    'torment': ['', Validators.nullValidator]
                }),
                'playerCharacters': this.buildQueryCharacters()
            }),
        });

        // this.postForm.valueChanges.subscribe(data => this.onValueChanged(data));
        // this.onValueChanged();

        this.selectedGameMode.subscribe({
            next: (value: GameModeState) => {
                this.currentGameMode = value;
            },
            error: (error) => console.log("Error selecting gameMode."),
            complete: () => console.log("This stream should have not ended.")
        });
    }

    get characters(): FormArray {
        return this.postForm.get('query').get('playerCharacters') as FormArray;
    };

    get gameControl(): FormArray {
        return this.postForm.get('query').get('game') as FormArray;
    }

    postContent({ value, valid }: { value: PostDTO, valid: boolean }) {
        // this.postListDto = this.postForm.value;
        this.postService.postContent(postTranformOut(value));
    }

    buildQueryCharacters(): FormArray {
        const arr = this.playerTypes.map(playerType => {
            return this.formBuilder.group({
                type: playerType,
                selected: false
            });
        });
        return this.formBuilder.array(arr);
    }

    private onChangeSelect(event) {
        this.gameModeService.change(event.value);
        if (event.value === 'Grift') {
            if (!this.gameControl.get('torment').disabled) {
                this.gameControl.get('torment').disable();
            }

            if (this.gameControl.get('level').disabled) {
                this.gameControl.get('level').enable();
            }
        }

        if (event.value !== 'Grift') {
            if (!this.gameControl.get('level').disabled) {
                this.gameControl.get('level').disable();
            }

            if (this.gameControl.get('torment').disabled) {
                this.gameControl.get('torment').enable();
            }
        }
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
