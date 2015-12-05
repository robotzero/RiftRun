import {Injectable} from 'angular2/angular2'
import {Http} from 'angular2/http'

@Injectable()
export class APIGetService {
    http:Http;

    constructor(http : Http) {
        this.http = http;
    }
    get(url:string) : any {
        //return this.http.get(url);
        return this.http.get(url).map(res => res.json());
    }
}
