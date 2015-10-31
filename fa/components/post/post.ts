import {Component, View, NgFor, NgIf, CORE_DIRECTIVES} from 'angular2/angular2';
declare var fetch, Zone;

@Component({
    selector: 'post'
})
@View({
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES, NgFor, NgIf]
})

export class Post {
    response: string;
    items: Array<string>;

    constructor() {
        this.callPostsEndpoint();
    }
    callPostsEndpoint() {
        this.response = null;
        Zone.bindPromiseFn(fetch,{method:'GET','Content-Type':'application/json'})('http://riftrun.local/v1/posts').then(r => r.json()).then(r => {
            this.response = r;
            this.items = r._embedded.items;
        });
    }
}