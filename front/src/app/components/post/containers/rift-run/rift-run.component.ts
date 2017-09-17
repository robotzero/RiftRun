import {ChangeDetectionStrategy, Component} from '@angular/core';
import { APIGetService } from "../../../../services/apigetservice";
import { Observable } from "rxjs/Observable";
import { Post } from "../../../../models/post";

@Component({
    changeDetection: ChangeDetectionStrategy.OnPush,
    selector: 'rift-run',
    styleUrls: ['rift-run.component.css'],
    template: `
    <div class="rift-run">
      <div class="rift-run__title">
        <h1>
          Rift Run App
        </h1>
      </div>
      <div class="rift-run__panes">
        <post-search>
          <!--[toppings]="toppings$ | async"-->
          (add)="updateList($event)">
        </post-search>
        <post-list
          [posts]="posts | async">
        </post-list>
      </div>
    </div>
  `
})
export class RiftRunComponent {
    posts: Observable<Array<Post>> = this.getService.get('http://riftrun.local/v1/posts');
    // posts: Observable<Array<Post>> = this.getService.get('http://riftrun.local/v1/posts').take(1).subscribe(users =>
    // this.usersSubject.next([...users, newUser]));


    constructor(private getService: APIGetService) {}

    public updateList(event: any) {
        console.log("update");
        this.getService.updatePostsList(event.value());
    }
}