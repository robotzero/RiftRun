import {Injectable} from "angular2/core";
import {Http} from "angular2/http";

@Injectable()
export class APIPostService
{
    http:Http;

    constructor(http : Http) {
        this.http = http;
    }

    postContent(json:string) : void {
        console.log(json);
    }
}