import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import { Subject } from "rxjs/Subject";
import {Observable} from "rxjs/Observable";
import {environment} from "../../environments/environment";
import {BehaviorSubject} from "rxjs/BehaviorSubject";
import {IPost} from "../models/post";

@Injectable()
export class APIGetService {
    private postData: Subject<Array<IPost>> = new BehaviorSubject([]);
    private postState = this.postData.asObservable().distinctUntilChanged();

    constructor(private http : Http) {}

    loadData() {
        this.http.get(`${environment.api_uri}`).map(listPostsResponse => {
            return listPostsResponse.json()._embedded.items as IPost[];
        }).subscribe(posts => {
            this.postData.next(posts);
        });
    }

    get currentPostState(): Observable<Array<IPost>> {
        return this.postState;
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
//    updatePostsList(value) {
//        this.get("blalalba", true).take(1).subscribe(all => {
//            this.postsState.next([...all, value])
//        })
    }
}
