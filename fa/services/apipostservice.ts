import {Injectable} from 'angular2/angular2'
import {Http} from 'angular2/http'

@Injectable()
export class APIPostService
{
    http:Http;

    constructor(http:Http) {
        this.http = http;
    }

    postContent(json:string) {
        console.log("I posted something!");
    }
}