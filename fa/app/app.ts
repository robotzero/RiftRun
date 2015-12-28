/// <reference path="../node_modules/angular2/core.d.ts" />
/// <reference path="../node_modules/angular2/router.d.ts" />
/// <reference path="../node_modules/angular2/http.d.ts" />

import {Component, View, bind} from 'angular2/core';
import {ROUTER_BINDINGS, ROUTER_DIRECTIVES, RouterOutlet, RouterLink, RouteConfig} from 'angular2/router';
import {bootstrap} from 'angular2/platform/browser';
import {HTTP_PROVIDERS} from 'angular2/http';
import {LocationStrategy, HashLocationStrategy} from 'angular2/router';
import {About} from "./components/about/about";
import {Todo} from "./components/todo/todo";
import {Post} from "./components/post/post";
import {Test} from "./components/test/test";
import {FormTest} from "./components/formtest/formtest";

// Annotation section
@Component({
    selector: 'my-app',
})

@View({
    template: `
        <div class="container">
            <nav>
                <ul>
                    <li><a [routerLink]="['/Test']">Test</a></li>
                    <li><a [routerLink]="['/FormTest']">Form Test</a></li>
                    <li><a [routerLink]="['/About']">About</a></li>
                    <!--li><a [router-link]="['/Post']">Post</a></li-->
                    <!--li><a [router-link]="['/Home']">About</a></li-->
                </ul>
            </nav>
            <router-outlet></router-outlet>
        </div>
    `,
    directives: [RouterOutlet, RouterLink, About, Todo, Post, About, ROUTER_DIRECTIVES]
})

@RouteConfig([
    //{ path: '/todo', component: Todo, as: 'Todo' },
    { path: '/test', component: Test, as: 'Test'},
    { path: '/', component: Post, as: 'Post'},
    { path: '/formtest', component: FormTest, as: 'FormTest'},
    { path: '/about', component: About, as: 'About' }
])

// Component controller
class MyAppComponent {

}

bootstrap(MyAppComponent, [ROUTER_BINDINGS, HTTP_PROVIDERS, bind(LocationStrategy).toClass(HashLocationStrategy)]);
