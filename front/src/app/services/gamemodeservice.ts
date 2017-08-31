import { Injectable } from "@angular/core";
import { BehaviorSubject } from "rxjs/BehaviorSubject";
import { Observable } from "rxjs/Observable";
import { griftLevels } from "../utilities/griftlevel-generator";

export interface GameModeState {
    gameMode: GameMode;
}

export interface GameMode {
    gameMode: string;
    options: GameModeOptions;
}

export interface GameModeOptions {
    name: string,
    value: Observable<string[]>
}

// export type PartialOption<GameModeOptions> = {
//     [P in keyof GameModeOptions]?: GameModeOptions[P];
// };

const state: GameModeState = {
    gameMode:
        { gameMode: 'Grift', options: { name: 'level', value: this.queryGameLevels } },
        // { gameMode: 'Rift', options: { torment: 1 } },
        // { gameMode: 'Keywardens', options: { torment: 1 } }
        // { gameMode: 'Bounties', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Goblins', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Ubers', options: { torment: 1, seasonal: false, level: '40+' } },
        // { gameMode: 'Powerlevel', options: { seasonal: false, level: '40+' } }

};

@Injectable()
export class GameModeService {
    private queryGameLevels: Observable<string[]> = griftLevels().toArray();
    private queryTormentLevels: Observable<string[]> = Observable.range(1, 13).map(value => value.toString()).toArray();
    private subject = new BehaviorSubject<GameModeState>(state);
    store = this.subject.asObservable().distinctUntilChanged();

    select<T>(name: string): Observable<T> {
        return this.store.pluck(name);
    }

    change<T>(name: string): void {
        if (name.toLowerCase() === 'grift') {
            this.subject.next({ gameMode: { gameMode: name, options: { name: 'level', value: this.queryGameLevels } }});
        } else {
            this.subject.next({ gameMode: { gameMode: name, options: { name: 'torment', value: this.queryTormentLevels } }});
        }
    }

    getQueryGameLevels(): Observable<string[]> {
        return this.queryGameLevels;
    }
}
