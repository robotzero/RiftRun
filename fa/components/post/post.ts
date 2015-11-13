import {Component, View, NgFor, NgIf, CORE_DIRECTIVES} from 'angular2/angular2';
import {APIGetService} from '../../services/apigetservice';
import {ObjectHydrator} from "../../services/objecthydrator";

@Component({
    selector: 'post',
    providers:[APIGetService, ObjectHydrator]
})
@View({
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES, NgFor, NgIf]
})

export class Post {
    items: Array<string>;

    constructor(getService:APIGetService, public hydrator: ObjectHydrator) {
        getService.get('http://riftrun.local/v1/posts')
                  .subscribe(response => this.items = response._embedded.items);

        this.hydrate(this.items);
    }

    public hydrate(items:Array<string>) {
        let hydrated = [];
        items.forEach(function(item) {
            console.log(item);
        });
    }
}