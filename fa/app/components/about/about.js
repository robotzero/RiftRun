System.register(['angular2/core', 'angular2/router', "../../directives/mydirective/mydirective", "./coloroutput", "./HeroDetailComponent", "./hostb"], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var core_1, router_1, mydirective_1, coloroutput_1, HeroDetailComponent_1, hostb_1;
    var About;
    return {
        setters:[
            function (core_1_1) {
                core_1 = core_1_1;
            },
            function (router_1_1) {
                router_1 = router_1_1;
            },
            function (mydirective_1_1) {
                mydirective_1 = mydirective_1_1;
            },
            function (coloroutput_1_1) {
                coloroutput_1 = coloroutput_1_1;
            },
            function (HeroDetailComponent_1_1) {
                HeroDetailComponent_1 = HeroDetailComponent_1_1;
            },
            function (hostb_1_1) {
                hostb_1 = hostb_1_1;
            }],
        execute: function() {
            About = (function () {
                function About(params) {
                    this.id = params.get('id');
                }
                About = __decorate([
                    core_1.Component({
                        selector: 'about',
                        template: "\n\t\tWelcome to the about page! <br>\n\t\t<input color (colorChange)=\"output.getColor($event)\">\n\t\t<color-output #output ></color-output>\n\t\t<hero-detail [hero]=\"currentHero\"></hero-detail>\n\t\t<div dropdown-test>TEST OF THE DROP DOWN TOGGLE</div>\n\t",
                        directives: [mydirective_1.MyCustomTest, coloroutput_1.ColorOutput, HeroDetailComponent_1.HeroDetailComponent, hostb_1.Hostb]
                    }), 
                    __metadata('design:paramtypes', [router_1.RouteParams])
                ], About);
                return About;
            })();
            exports_1("About", About);
        }
    }
});

//# sourceMappingURL=about.js.map
