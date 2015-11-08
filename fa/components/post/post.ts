import {Component, View, NgFor, NgIf, CORE_DIRECTIVES} from 'angular2/angular2';
import {APIGetService} from '../../services/apigetservice';

@Component({
    selector: 'post',
    providers:[APIGetService]
})
@View({
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES, NgFor, NgIf]
})

export class Post {
    //result: Object;
    items: Array<string>;

    constructor(getService:APIGetService) {
        //this.result = {items: []};
        getService.get('http://riftrun.local/v1/posts').subscribe(res => this.items = res._embedded.items);
    }

    //callPostsEndpoint() {
    //    this.response = null;
    //    Zone.bindPromiseFn(fetch,{method:'GET','Content-Type':'application/json'})('http://riftrun.local/v1/posts').then(r => r.json()).then(r => {
    //        this.response = r;
    //        this.items = r._embedded.items;
    //    });
    //}
}