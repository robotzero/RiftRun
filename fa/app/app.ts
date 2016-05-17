///<reference path="../typings/browser.d.ts"/>
///<reference path="../typings/browser/ambient/es6-shim/index.d.ts" />

import {Component, bind} from '@angular/core';
import {bootstrap} from '@angular/platform-browser-dynamic';

import {LocationStrategy, HashLocationStrategy} from '@angular/common';
import {Post} from "./components/post/post";
import {ROUTER_PROVIDERS, ROUTER_DIRECTIVES, Routes} from '@angular/router';
import {HTTP_PROVIDERS} from '@angular/http';

// Annotation section
@Component({
    selector: 'my-app',
    templateUrl: './app/app.html',
    // template: `
    //     <div class="container">
    //         <nav>
    //             <ul>
    //             </ul>
    //         </nav>
    //         <router-outlet></router-outlet>
    //     </div>
    // `,
    directives: [ROUTER_DIRECTIVES]
})

@Routes([
    { path: '/', component: Post},
])

// Component controller
class MyAppComponent {

}

bootstrap(MyAppComponent, [HTTP_PROVIDERS, ROUTER_PROVIDERS, bind(LocationStrategy).toClass(HashLocationStrategy)]);
