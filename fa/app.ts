/// <reference path="../node_modules/angular2/angular2.d.ts" />
/// <reference path="../node_modules/angular2/router.d.ts" />
/// <reference path="../node_modules/angular2/http.d.ts" />

import {Component, View, bootstrap, bind} from 'angular2/angular2';
import {ROUTER_BINDINGS, ROUTER_DIRECTIVES, RouterOutlet, RouterLink, RouteConfig} from 'angular2/router';
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
                    <li><a [router-link]="['/Test']">Test</a></li>
                    <li><a [router-link]="['/FormTest']">Form Test</a></li>
                    <!--li><a [router-link]="['/Post']">Post</a></li-->
                    <!--li><a [router-link]="['/Home']">About</a></li-->
                </ul>
            </nav>
            <router-outlet></router-outlet>
        </div>
    `,
    directives: [RouterOutlet, RouterLink, About, Todo, Post]
})

@RouteConfig([
    //{ path: '/todo', component: Todo, as: 'Todo' },
    { path: '/test', component: Test, as: 'Test'},
    { path: '/', component: Post, as: 'Post'},
    { path: '/formtest', component: FormTest, as: 'FormTest'}
    //{ path: '/', component: About, as: 'Home' }
])

// Component controller
class MyAppComponent {

}

bootstrap(MyAppComponent, [ROUTER_BINDINGS, HTTP_PROVIDERS, bind(LocationStrategy).toClass(HashLocationStrategy)]);
