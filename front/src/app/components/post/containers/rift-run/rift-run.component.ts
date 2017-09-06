import { Component } from '@angular/core';
import {APIGetService} from "../../../../services/apigetservice";

@Component({
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
          <!--(add)="addPizza($event)">-->
        </post-search>
        <post-list
          [posts]="posts | async">
        </post-list>
      </div>
    </div>
  `
})
export class RiftRunComponent {
    posts = this.getService.get('http://riftrun.local/v1/posts');
    constructor(private getService: APIGetService) {}
}