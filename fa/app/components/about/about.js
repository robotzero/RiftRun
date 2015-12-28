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
var mydirective_1 = require("../../directives/mydirective/mydirective");
var coloroutput_1 = require("./coloroutput");
var HeroDetailComponent_1 = require("./HeroDetailComponent");
var hostb_1 = require("./hostb");
var About = (function () {
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
exports.About = About;

//# sourceMappingURL=about.js.map
