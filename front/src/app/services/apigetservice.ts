import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';

@Injectable()
export class APIGetService {
    constructor(private http : Http) {}

    get(url:string) : any {
        return this.http.get(url).map(res => res.json());
    }
}
