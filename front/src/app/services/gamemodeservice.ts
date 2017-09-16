import { Injectable } from "@angular/core";
import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Observable } from "rxjs/Observable";
import { griftLevels } from "../utilities/griftlevel-generator";
import { GameType } from "../components/post/components/post-list/types/game-type";

export interface GameModeState {
    gameMode: string;
    options: GameModeOptions;
}

export interface GameModeOptions {
    name: string,
    value: Observable<string[]>
}

let state: GameModeState = { gameMode: GameType.GRIFT.toString().toLowerCase(), options: { name: 'level', value: this.queryTormentLevels } };

@Injectable()
export class GameModeService {
    private queryGameLevels: Observable<string[]> = griftLevels().toArray().delay(1);
    private queryTormentLevels: Observable<string[]> = Observable.range(1, 13).map(value => value.toString()).toArray().delay(1);
    private subject = new BehaviorSubject<GameModeState>(state);
    private store = this.subject.asObservable().distinctUntilChanged().delay(1);

    get currentStore(): Observable<GameModeState> {
        return this.store;
    }

    change<T>(name: string): void {
        if (name.toLowerCase() === GameType.GRIFT.toString().toLowerCase()) {
            this.subject.next({ gameMode: name.toLowerCase(), options: { name: 'level', value: this.queryGameLevels } });
        } else {
            this.subject.next({ gameMode: name.toLowerCase(), options: { name: 'torment', value: this.queryTormentLevels } });
        }
    }
}
