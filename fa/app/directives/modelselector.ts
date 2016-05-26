///<reference path="../../typings/browser.d.ts"/>
///<reference path="../../typings/browser/ambient/es6-shim/index.d.ts" />

import {Component, Output, OnInit, Input} from "@angular/core";
import {EventEmitter} from "@angular/core";

@Component({
    selector: 'model-selector',
    templateUrl: './app/directives/modelselector.html',
})

export class ModelSelector implements OnInit {
    @Output() select = new EventEmitter();
    @Input() models;
    
    ngOnInit():any {
        this.select.emit(this.models[0]);
    }
}
