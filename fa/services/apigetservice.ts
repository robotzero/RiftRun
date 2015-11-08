import {Injectable} from 'angular2/angular2'
import {Http} from 'angular2/http'

@Injectable()
export class APIGetService {
    http:Http;

    constructor(http : Http) {
        this.http = http;
    }
    get(url:string) : any {
        //this.aloha = {};
        //this.http.get('http://riftrun.local/v1/posts').map(res => {
        //    console.log(res);
        //    this.aloha = res.json();
        //    return this.aloha;
        //});

        return this.http.get(url).map(res => res.json());
    }
}
