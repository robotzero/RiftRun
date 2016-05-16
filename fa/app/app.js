System.register(['@angular/core', '@angular/platform-browser-dynamic', '@angular/common', "./components/post/post", '@angular/router', '@angular/http'], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, platform_browser_dynamic_1, common_1, post_1, router_1, http_1;
    var MyAppComponent;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (platform_browser_dynamic_1_1) {
                platform_browser_dynamic_1 = platform_browser_dynamic_1_1;
            },
            function (common_1_1) {
                common_1 = common_1_1;
            },
            function (post_1_1) {
                post_1 = post_1_1;
            },
            function (router_1_1) {
                router_1 = router_1_1;
            },
            function (http_1_1) {
                http_1 = http_1_1;
            }],
        execute: function() {
            // Annotation section
            MyAppComponent = (function () {
                function MyAppComponent() {
                }
                MyAppComponent = __decorate([
                    core_1.Component({
                        selector: 'my-app',
                        template: "\n        <div class=\"container\">\n            <nav>\n                <ul>\n                    \n                </ul>\n            </nav>\n            <router-outlet></router-outlet>\n        </div>\n    ",
                        directives: [post_1.Post, router_1.ROUTER_DIRECTIVES]
                    }),
                    router_1.Routes([
                        { path: '/', component: post_1.Post },
                    ]), 
                    __metadata('design:paramtypes', [])
                ], MyAppComponent);
                return MyAppComponent;
            }());
            platform_browser_dynamic_1.bootstrap(MyAppComponent, [http_1.HTTP_PROVIDERS, core_1.bind(common_1.LocationStrategy).toClass(common_1.HashLocationStrategy)]);
        }
    }
});

//# sourceMappingURL=app.js.map
