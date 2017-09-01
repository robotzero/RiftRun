import { Injectable } from "@angular/core";
import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Observable } from "rxjs/Observable";
import { griftLevels } from "../utilities/griftlevel-generator";
import {GameType} from "../components/post/post-list/types/game-type";

export interface GameModeState {
    gameMode: string;
    options: GameModeOptions;
}

export interface GameModeOptions {
    name: string,
    value: Observable<string[]>
}

const state: GameModeState = { gameMode: GameType.GRIFT.toString(), options: { name: 'level', value: this.queryGameLevels } };

@Injectable()
export class GameModeService {
    private queryGameLevels: Observable<string[]> = griftLevels().toArray();
    private queryTormentLevels: Observable<string[]> = Observable.range(1, 13).map(value => value.toString()).toArray();
    private subject = new BehaviorSubject<GameModeState>(state);
    store = this.subject.asObservable().distinctUntilChanged();

    select<T>(): Observable<T> {
        return this.store.pluck('options');
    }

    get currentStore(): Observable<GameModeState> {
        return this.store;
    }

    change<T>(name: string): void {
        if (name.toLowerCase() === GameType.GRIFT.toString().toLowerCase()) {
            this.subject.next({ gameMode: name, options: { name: 'level', value: this.queryGameLevels } });
        } else {
            this.subject.next({ gameMode: name, options: { name: 'torment', value: this.queryTormentLevels } });
        }
    }
}
