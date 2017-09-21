///<reference path="../../../../../../node_modules/@angular/core/src/metadata/lifecycle_hooks.d.ts"/>
import {ChangeDetectionStrategy, Component, OnInit} from '@angular/core';
import { APIGetService } from "../../../../services/apigetservice";
import { Observable } from "rxjs/Observable";
import { Post } from "../../../../models/post";
import {Subject} from "rxjs/Subject";
import {Http} from "@angular/http";
import {PostFactory} from "../../../../utils/postFactory";
import {AsyncSubject} from "rxjs/AsyncSubject";

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
        <post-search (add)="updateList($event)">
        </post-search>
        <post-list
          [posts]="posts | async">
        </post-list>
      </div>
    </div>
  `
})
export class RiftRunComponent implements OnInit {
    private posts: Observable<Array<Post>>;

    constructor(private getService: APIGetService) {}

    ngOnInit(): void {
        this.getService.loadData();
        this.posts = this.getService.currentPostState;
    }

    public updateList(event: any) {
        console.log("load");
        this.getService.loadData();
        this.posts = this.getService.currentPostState;
    }
}