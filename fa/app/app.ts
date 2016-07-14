///<reference path="../typings/browser.d.ts"/>
///<reference path="../typings/browser/ambient/es6-shim/index.d.ts" />

import {Component, bind} from '@angular/core';
import {bootstrap} from '@angular/platform-browser-dynamic';
import {ROUTER_DIRECTIVES} from '@angular/router';
import {LocationStrategy, HashLocationStrategy} from '@angular/common';
import {HTTP_PROVIDERS} from '@angular/http';
// import {MdToolbar} from '@angular2-material/toolbar';
import {APP_ROUTER_PROVIDER} from "./routes";
import {provideForms, disableDeprecatedForms} from '@angular/forms';

// Annotation section
@Component({
    selector: 'my-app',
    templateUrl: './app/app.html',
    styleUrls: ['./app/app.css'],
    directives: [ROUTER_DIRECTIVES]
    // directives: [MdToolbar]
})

// Component controller
class MyAppComponent {

}

bootstrap(MyAppComponent, [
    HTTP_PROVIDERS, APP_ROUTER_PROVIDER, disableDeprecatedForms(), provideForms(), bind(LocationStrategy).toClass(HashLocationStrategy)
]);
