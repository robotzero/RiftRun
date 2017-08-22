import { Injectable } from "@angular/core";
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import {Observable} from "rxjs/Observable";

export interface GameModeState {
    gameModes: GameMode[];
}

export interface GameMode {
    gameMode: string;
    options: PartialOption<GameModeOptions>;
}

export interface GameModeOptions {
    level?: string;
    torment?: number;
}

export type PartialOption<GameModeOptions> = {
    [P in keyof GameModeOptions]?: GameModeOptions[P];
};

const state: GameModeState = {
    gameModes: [
        { gameMode: 'Grift', options: { level: '40+' } },
        { gameMode: 'Rift', options: { torment: 1 } }
        // { gameMode: 'Keywardens', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Bounties', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Goblins', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Ubers', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Powerlevel', options: { seasonal: false, level: '40+' } }
    ]
};

@Injectable()
export class GameModeService {
    private subject = new BehaviorSubject<GameModeState>(state);
    store = this.subject.asObservable().distinctUntilChanged();

    select<T>(name: string): Observable<T> {
        return this.store.pluck(name);
    }
}
