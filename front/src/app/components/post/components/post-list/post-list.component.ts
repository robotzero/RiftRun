import {Component, Input} from "@angular/core";

@Component({
    selector: 'post-list',
    providers: [ ],
    templateUrl: 'post-list.html',
})

export class PostListComponent {
    @Input()
    posts: any;
}
