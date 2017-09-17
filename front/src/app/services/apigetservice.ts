import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import { Observable } from "rxjs/Observable";
import { ReplaySubject } from "rxjs/ReplaySubject";
import { PostFactory } from "../utils/postFactory";
import { Post } from "../models/post";

@Injectable()
export class APIGetService {
    postsState: ReplaySubject<any>;
    postsResponse: Observable<any>;

    constructor(private http : Http, private postFactory: PostFactory) {
        this.postsState = new ReplaySubject(1);
    }

    get(url:string, forceRefresh: boolean = false) : Observable<Array<Post>> {
        if (forceRefresh || !this.postsResponse) {
            this.postsResponse = this.http.get('http://riftrun.local/v1/posts')
                .map(listPostsResponse => {
                    return this.postFactory.buildPosts(listPostsResponse.json());
                });

            this.postsResponse.subscribe(
                response => {
                    this.postsState.next(response);
                },
                error => {
                    console.log("WE DO HAVE AN ERROR.");
                    // console.log(error);
                }
            );
        }

        return this.postsState.asObservable();
    }

    updatePostsList(value) {
        this.postsState.asObservable().take(1).subscribe(all => {
            this.postsState.next([...all, value.value()])
        })
    }
}
