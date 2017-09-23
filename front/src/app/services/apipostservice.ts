import {EventEmitter, Injectable} from '@angular/core';
import {Http} from '@angular/http';
import {Headers} from '@angular/http';
import {Response} from '@angular/http';
import {RequestOptions} from '@angular/http';

@Injectable()
export class APIPostService
{
    private response = null;
    private logError: Function = (err) => console.log("MY ERROR " + err.toString());

    constructor(private http : Http) {}

    postContent(postObject: Object, emitter:  EventEmitter<any>): void {
        let headers = new Headers();

        headers.append('Content-Type', 'application/json');
        let requestOptions = new RequestOptions({method: 'POST', headers: headers});

        this.http.post('http://riftrun.local/v1/posts', JSON.stringify(postObject), requestOptions)
            .map((res:Response) => res.json())
            .map((res:string) => this.response = res)
            .subscribe(
                data => emitter.emit(data),
                err => this.logError(err),
                () => console.log('Post done.')
            );
    }
}