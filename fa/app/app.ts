///<reference path="../typings/browser.d.ts"/>
///<reference path="../typings/browser/ambient/es6-shim/index.d.ts" />

import {Component, bind} from '@angular/core';
import {bootstrap} from '@angular/platform-browser-dynamic';

import {LocationStrategy, HashLocationStrategy} from '@angular/common';
import {Post} from "./components/post/post";
import {ROUTER_PROVIDERS, ROUTER_DIRECTIVES, Routes} from '@angular/router';
import {HTTP_PROVIDERS} from '@angular/http';
import {MdToolbar} from '@angular2-material/toolbar';

// Annotation section
@Component({
    selector: 'my-app',
    templateUrl: './app/app.html',
    styleUrls: ['./app/app.css'],
    directives: [ROUTER_DIRECTIVES, MdToolbar]
})

@Routes([
    { path: '/', component: Post},
])

// Component controller
class MyAppComponent {

}

bootstrap(MyAppComponent, [HTTP_PROVIDERS, ROUTER_PROVIDERS, bind(LocationStrategy).toClass(HashLocationStrategy)]);
