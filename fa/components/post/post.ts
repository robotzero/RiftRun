import {Component, View, CORE_DIRECTIVES} from 'angular2/angular2';
declare var fetch, Zone;

@Component({
    selector: 'post'
})
@View({
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES]
})

export class Post {
    response: string;

    constructor() {
        Zone.bindPromiseFn(fetch,{method:'GET','Content-Type':'application/json'})('http://riftrun.local/v1/posts').then(r => r.json()).then(r => {
            this.response = r;
        });
    }
    callPostsEndpoint() {
        this.response = null;

        Zone.bindPromiseFn(fetch)('http://localhost/v1/posts').then(r => r.json()).then(r => {
            this.response = r;
        });

        return this.response;
    }
}