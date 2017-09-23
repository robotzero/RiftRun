import {ChangeDetectionStrategy, Component, OnInit} from '@angular/core';
import { APIGetService } from "../../../../services/apigetservice";
import { Observable } from "rxjs/Observable";
import { IPost } from "../../../../models/post";

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
        <post-search
          (addEvent)="updateList($event)">
        </post-search>
        <post-list
          [posts]="posts | async">
        </post-list>
      </div>
    </div>
  `
})
export class RiftRunComponent implements OnInit {
    private posts: Observable<Array<IPost>> = this.getService.currentPostState;

    constructor(private getService: APIGetService) {}

    ngOnInit(): void {
        this.getService.loadData();
    }

    public updateList(event: any) {
        this.getService.loadData();
    }
}
