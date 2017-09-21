import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import { PostFactory } from "../utils/postFactory";
import { Post } from "../models/post";
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import { Subject } from "rxjs/Subject";
import {ReplaySubject} from "rxjs/ReplaySubject";

@Injectable()
export class APIGetService {
    private postData: Subject<Array<Post>> = new ReplaySubject(1);

    constructor(public http : Http, private postFactory: PostFactory) {}

    loadData() {
        this.http.get('http://riftrun.local/v1/posts').map(listPostsResponse => {
            return this.postFactory.buildPosts(listPostsResponse.json())
        }).subscribe(posts => {
            console.log(posts);
            this.postData.next(posts);
        });
    }

    get currentPostState() {
        return this.postData.asObservable();
    }

    // get(url:string, forceRefresh: boolean = false) : Observable<Array<Post>> {
    //     if (forceRefresh || !this.postsResponse) {
    //         this.http.get('http://riftrun.local/v1/posts')
    //             .map(listPostsResponse => {
    //                 return this.postFactory.buildPosts(listPostsResponse.json());
    //             }).subscribe(
    //             response => {
    //                 this.postsState.next(response);
    //             },
    //             error => {
    //                 console.log("WE DO HAVE AN ERROR.");
    //                 // console.log(error);
    //             }
    //         );
    //     }
    //     return this.data;
    // }

    updatePostsList(value):void {
        this.postData.next(value);
        // let currentList:Array<Post> = this.postsState.value;
        // this.postsState.next([...currentList, value]);
        // this.currentPostState;
        // this.postData.subscribe(all => {
        //     this.postsState.next([value]);
        // });
        // this.postData.subscribe(all => {

        //     this.postObserver.next([value]);
        // });
        // this.postObserver.next([value]);
        // return this.postsState;
        // this.postsState.take(1).subscribe(all => {
        //     this.postsState.next([...all, value])
        // })
    }
}
