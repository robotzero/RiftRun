import { APIPostService } from '../../../../services/apipostservice';
import { Component, EventEmitter, OnInit, Output} from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from "@angular/forms";
import { GameModeService, GameModeState } from "../../../../services/gamemodeservice";
import { PostDTO } from "../post-list/post-dto";
import {PlayerType} from "../post-list/types/player-type";
import {RegionType} from "../post-list/types/region-type";
import {GameType} from "../post-list/types/game-type";
import {Observable} from "rxjs/Observable";

@Component({
    // changeDetection: ChangeDetectionStrategy.Default,
    selector: 'post-search',
    providers: [ APIPostService, GameModeService ],
    templateUrl: 'post-search.html',
})

export class PostSearchComponent implements OnInit {

    @Output()
    private addEvent = new EventEmitter();

    private selectedGameMode: Observable<GameModeState> = this.gameModeService.currentStore;
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
        private formBuilder: FormBuilder
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
    }

    get characters(): FormArray {
        return this.postForm.get('query').get('playerCharacters') as FormArray;
    };

    get gameControl(): FormArray {
        return this.postForm.get('query').get('game') as FormArray;
    }

    postContent({ value, valid }: { value: PostDTO, valid: boolean }) {
        this.postService.postContent(value, this.addEvent);
    }

    buildQueryCharacters(): FormArray {
        const playerTypeFormArray = this.playerTypes.map(playerType => {
            return this.formBuilder.group({
                type: playerType.toLowerCase()
            });
        });
        playerTypeFormArray.forEach(control => {
            control.disable();
        });

        return this.formBuilder.array(playerTypeFormArray);
    }

    private onChangeSelect(event) {
        this.gameModeService.change(event.value);
        if (event.value === 'grift') {
            if (!this.gameControl.get('torment').disabled) {
                this.gameControl.get('torment').disable();
            }

            if (this.gameControl.get('level').disabled) {
                this.gameControl.get('level').enable();
            }
        }

        if (event.value !== 'grift') {
            if (!this.gameControl.get('level').disabled) {
                this.gameControl.get('level').disable();
            }

            if (this.gameControl.get('torment').disabled) {
                this.gameControl.get('torment').enable();
            }
        }
    }

    private addCharacters(value) {
        this.characters.controls.filter(control => {
           console.log(control.value.type === value);
           return control.value.type === value.toLowerCase();
        }).forEach(filteredControl => {
           if (filteredControl.disabled) {
               filteredControl.enable();
           } else {
               filteredControl.disable();
           }
        });
    }
}
