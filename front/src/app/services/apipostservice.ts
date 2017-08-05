import {Injectable} from '@angular/core';
import {Http} from '@angular/http';
import {Headers} from '@angular/http';
import {Response} from '@angular/http';
import {RequestOptions} from '@angular/http';

@Injectable()
export class APIPostService
{
    http:Http;
    errorMessage: string;
    private response = null;

    constructor(http : Http) {
        this.http = http;
    }

    postContent(postObject: Object) : void {
        let headers = new Headers();

        headers.append('Content-Type', 'application/json');
        let requestOptions = new RequestOptions({method: 'POST', headers: headers});

        this.http.post('http://riftrun.local/v1/posts', JSON.stringify(postObject), requestOptions)
            .map((res:Response) => res.json())
            .map((res:string) => this.response = res)
            .subscribe(
                data => this.saveJwt(data),
                err => this.logError(err),
                () => console.log('Post done.')
            );
    }

    logError(err) {
        console.log("MY ERROR " + err.toString());
    }

    saveJwt(token) {
        console.log("Token " + this.response.postId);
        console.log("Token " + this.response.searchId);
    }
}

//
//{
//    "player":
//    {
//        "type":"demon hunter","paragonPoints":"13","battleTag":"#2000","region":"EU","seasonal":1,"gameType":"hardcore"},
//    "query":{
//    "minParagon":"10",
//        "game":{
//            "type":"grift","level":"40+"
//        },
//        "characterType":
//            [{"type":"Demon Hunter"},{"type":"wizard"}]
//        }
//}