var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var common_1 = require("angular2/common");
var common_2 = require("angular2/common");
var common_3 = require("angular2/common");
var core_1 = require("angular2/core");
var FormTest = (function () {
    function FormTest(formBuilder) {
        this.btnvalue = "Select Hero Power";
        this.powers = ['Smart', 'Breeze', 'Sup'];
        this.testForm = formBuilder.group({
            hero: ['']
        });
    }
    FormTest.prototype.onSubmit = function (value) {
        console.log(value.value);
    };
    FormTest.prototype.selected = function (value) {
        this.btnvalue = value;
    };
    FormTest = __decorate([
        core_1.Component({
            selector: 'formtest',
            directives: [common_1.CORE_DIRECTIVES, common_2.FORM_DIRECTIVES],
            templateUrl: './components/formtest/formtest.html',
            viewBindings: [common_3.FormBuilder]
        }), 
        __metadata('design:paramtypes', [common_3.FormBuilder])
    ], FormTest);
    return FormTest;
})();
exports.FormTest = FormTest;

//# sourceMappingURL=formtest.js.map
