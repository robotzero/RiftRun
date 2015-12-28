var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var core_1 = require("angular2/core");
var core_2 = require("angular2/core");
var Hostb = (function () {
    function Hostb() {
        this.open = false;
    }
    Object.defineProperty(Hostb.prototype, "isOpen", {
        get: function () {
            return this.open;
        },
        enumerable: true,
        configurable: true
    });
    __decorate([
        core_1.HostBinding('attr.aria-expanded'), 
        __metadata('design:type', Object)
    ], Hostb.prototype, "isOpen", null);
    Hostb = __decorate([
        core_2.Directive({
            selector: '[dropdown-test]'
        }), 
        __metadata('design:paramtypes', [])
    ], Hostb);
    return Hostb;
})();
exports.Hostb = Hostb;

//# sourceMappingURL=hostb.js.map
