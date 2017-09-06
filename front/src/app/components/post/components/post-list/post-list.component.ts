import { APIGetService } from '../../../../services/apigetservice';
import { Post } from '../../../../models/post';
import { APIPostService } from '../../../../services/apipostservice';
import { ChangeDetectionStrategy, Component, Input, OnInit} from '@angular/core';
import { PostFactory } from "../../../../utils/postFactory";
import { FormArray, FormBuilder, FormGroup, Validators } from "@angular/forms";
import { PostDTO } from "./post-dto";
import { PlayerType } from "./types/player-type";
import { GameType } from "./types/game-type";
import { RegionType } from "./types/region-type";
import { Observable } from "rxjs/Rx";
import { GameModeService, GameModeState } from "../../../../services/gamemodeservice";
import { postTranformOut } from "../../../../utilities/postTrasform";

@Component({
    changeDetection: ChangeDetectionStrategy.OnPush,
    selector: 'post-list',
    providers: [ APIPostService, PostFactory, GameModeService ],
    templateUrl: 'post-list.html',
})

export class PostListComponent implements OnInit {
    @Input()
    posts: Array<Post>;
    // private selectedGameMode: Observable<GameModeState> = this.gameModeService.currentStore;
    // private currentGameMode: GameModeState;
    // private items: Array<string>;
    // private postForm: FormGroup;
    // private response: any;
    // private postListDto: PostDTO;
    // private playerTypes: Array<PlayerType> = [
    //     PlayerType.DEMON_HUNTER,
    //     PlayerType.WIZARD,
    //     PlayerType.WITCH_DOCTOR,
    //     PlayerType.BARBARIAN,
    //     PlayerType.CRUSADER,
    //     PlayerType.NECROMANCER
    // ];
    // private playerRegions: Array<RegionType> = [
    //     RegionType.NA,
    //     RegionType.EU,
    //     RegionType.AUS,
    //     RegionType.ASIA
    // ];

    constructor(
        // private gameModeService: GameModeService,
        // private getService: APIGetService,
        // private postService: APIPostService,
        // private formBuilder: FormBuilder,
        // private postFactory: PostFactory
    ) {
        // this.postListDto = new PostDTO();
    }

    // private queryGameTypes: Array<GameType> = [
    //     GameType.RIFT,
    //     GameType.GRIFT,
    //     GameType.BOUNTIES,
    //     GameType.KEYWARDENS,
    //     GameType.UBERS,
    //     GameType.GOBLINS
    // ];

    ngOnInit():void {
        // this.postForm = this.formBuilder.group({
        //     'player': this.formBuilder.group({
        //         'type': ['', Validators.required],
        //         'paragonPoints': ['', Validators.required],
        //         'battleTag': ['', Validators.required],
        //         'region': ['', Validators.required],
        //         'gameType': ['', Validators.required],
        //         'seasonal': ['', Validators.required]
        //     }),
        //     'query': this.formBuilder.group({
        //         'minParagon': ['', Validators.required],
        //         'game': this.formBuilder.group({
        //             'gameMode': ['', Validators.required],
        //             'level': ['', Validators.nullValidator],
        //             'torment': ['', Validators.nullValidator]
        //         }),
        //         'playerCharacters': this.buildQueryCharacters()
        //     }),
        // });

        // this.postForm.valueChanges.subscribe(data => this.onValueChanged(data));
        // this.onValueChanged();
        // this.getService.get('http://riftrun.local/v1/posts')
        //     .map((posts: any) => {
        //         return this.postFactory.buildPosts(posts);
        //     })
        //     .subscribe(response => this.posts = response);

        // this.selectedGameMode.subscribe({
        //     next: (value: GameModeState) => {
        //         this.currentGameMode = value;
        //     },
        //     error: (error) => console.log("Error selecting gameMode."),
        //     complete: () => console.log("This stream should have not ended.")
        // });
    }

    // get characters(): FormArray {
    //     return this.postForm.get('query').get('playerCharacters') as FormArray;
    // };
    //
    // get gameControl(): FormArray {
    //     return this.postForm.get('query').get('game') as FormArray;
    // }

    // postContent({ value, valid }: { value: PostDTO, valid: boolean }) {
    //     // this.postListDto = this.postForm.value;
    //     this.postService.postContent(postTranformOut(value));
    // }

    // buildQueryCharacters(): FormArray {
    //     const arr = this.playerTypes.map(playerType => {
    //         return this.formBuilder.group({
    //             type: playerType,
    //             selected: false
    //         });
    //     });
    //     return this.formBuilder.array(arr);
    // }

    // private onChangeSelect(event) {
    //     this.gameModeService.change(event.value);
    //     if (event.value === 'Grift') {
    //         if (!this.gameControl.get('torment').disabled) {
    //             this.gameControl.get('torment').disable();
    //         }
    //
    //         if (this.gameControl.get('level').disabled) {
    //             this.gameControl.get('level').enable();
    //         }
    //     }
    //
    //     if (event.value !== 'Grift') {
    //         if (!this.gameControl.get('level').disabled) {
    //             this.gameControl.get('level').disable();
    //         }
    //
    //         if (this.gameControl.get('torment').disabled) {
    //             this.gameControl.get('torment').enable();
    //         }
    //     }
    // }

    private onValueChanged(data?: any) {
        // if (!this.postForm) {
        //     return;
        // }
        // const form = this.postForm;

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
