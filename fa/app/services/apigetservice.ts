import {Injectable} from "angular2/core";
import {Http} from "angular2/http";
import 'rxjs/add/operator/map';

@Injectable()
export class APIGetService {
    http:Http;

    constructor(http : Http) {
        this.http = http;
    }
    get(url:string) : any {
        return this.http.get(url).map(res => res.json());
    }
}
