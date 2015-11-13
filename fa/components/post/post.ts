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
    items: Array<string>;

    constructor(getService:APIGetService) {
        getService.get('http://riftrun.local/v1/posts')
                  .subscribe(response => this.items = response._embedded.items);
    }
}