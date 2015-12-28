var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require('angular2/core');
var router_1 = require('angular2/router');
var browser_1 = require('angular2/platform/browser');
var http_1 = require('angular2/http');
var router_2 = require('angular2/router');
var about_1 = require("./components/about/about");
var todo_1 = require("./components/todo/todo");
var post_1 = require("./components/post/post");
var test_1 = require("./components/test/test");
var formtest_1 = require("./components/formtest/formtest");
var MyAppComponent = (function () {
    function MyAppComponent() {
    }
    MyAppComponent = __decorate([
        core_1.Component({
            selector: 'my-app',
        }),
        core_1.View({
            template: "\n        <div class=\"container\">\n            <nav>\n                <ul>\n                    <li><a [routerLink]=\"['/Test']\">Test</a></li>\n                    <li><a [routerLink]=\"['/FormTest']\">Form Test</a></li>\n                    <li><a [routerLink]=\"['/About']\">About</a></li>\n                    <!--li><a [router-link]=\"['/Post']\">Post</a></li-->\n                    <!--li><a [router-link]=\"['/Home']\">About</a></li-->\n                </ul>\n            </nav>\n            <router-outlet></router-outlet>\n        </div>\n    ",
            directives: [router_1.RouterOutlet, router_1.RouterLink, about_1.About, todo_1.Todo, post_1.Post, about_1.About, router_1.ROUTER_DIRECTIVES]
        }),
        router_1.RouteConfig([
            { path: '/test', component: test_1.Test, as: 'Test' },
            { path: '/', component: post_1.Post, as: 'Post' },
            { path: '/formtest', component: formtest_1.FormTest, as: 'FormTest' },
            { path: '/about', component: about_1.About, as: 'About' }
        ]), 
        __metadata('design:paramtypes', [])
    ], MyAppComponent);
    return MyAppComponent;
})();
browser_1.bootstrap(MyAppComponent, [router_1.ROUTER_BINDINGS, http_1.HTTP_PROVIDERS, core_1.bind(router_2.LocationStrategy).toClass(router_2.HashLocationStrategy)]);

//# sourceMappingURL=app.js.map
