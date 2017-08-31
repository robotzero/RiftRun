import {Observable} from "rxjs/Rx";

/**
 * Util function to generate grift levels
 */
export function griftLevels(): Observable<string> {
    return Observable.range(1, 10).map(num => num * 10).map(num => num + '+');
}