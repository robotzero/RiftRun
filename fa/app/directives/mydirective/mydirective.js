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
var core_2 = require("angular2/core");
var MyCustomTest = (function () {
    function MyCustomTest() {
        this.colorChange = new core_2.EventEmitter();
    }
    MyCustomTest.prototype.updateColor = function (event) {
        event.preventDefault();
        event.stopPropagation();
        var color = event.target.value;
        this.colorChange.emit(color);
    };
    MyCustomTest = __decorate([
        core_1.Directive({
            selector: 'input[color]',
            events: ['colorChange'],
            host: {
                '(input)': 'updateColor($event)'
            }
        }), 
        __metadata('design:paramtypes', [])
    ], MyCustomTest);
    return MyCustomTest;
})();
exports.MyCustomTest = MyCustomTest;

//# sourceMappingURL=mydirective.js.map
