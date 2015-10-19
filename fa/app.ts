/// <reference path="../node_modules/angular2/angular2.d.ts" />
/// <reference path="../node_modules/angular2/router.d.ts" />
import {Component, View, bootstrap, bind} from 'angular2/angular2';
import {ROUTER_BINDINGS, ROUTER_DIRECTIVES, RouterOutlet, RouterLink, RouteConfig} from 'angular2/router';
import {LocationStrategy, HashLocationStrategy} from 'angular2/router';
//import {About} from "./components/about/about";
import {Todo} from "./components/todo/todo";

// Annotation section
@Component({
    selector: 'my-app',
})

@View({
    template: `
        <div class="container">
            <nav>
                <ul>
                    <li><a [router-link]="['/Home']">Todo</a></li>
                </ul>
            </nav>
            <router-outlet></router-outlet>
        </div>
    `,
    directives: [RouterOutlet, RouterLink]
})

@RouteConfig([
    { path: '/', component: Todo, as: 'Home' }
    //{ path: '/', component: About, as: 'Home' }
])

// Component controller
class MyAppComponent {

}

bootstrap(MyAppComponent, [ROUTER_BINDINGS, bind(LocationStrategy).toClass(HashLocationStrategy)]);
