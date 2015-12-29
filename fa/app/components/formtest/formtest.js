System.register(["angular2/common", "angular2/core"], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var common_1, common_2, common_3, core_1;
    var FormTest;
    return {
        setters:[
            function (common_1_1) {
                common_1 = common_1_1;
                common_2 = common_1_1;
                common_3 = common_1_1;
            },
            function (core_1_1) {
                core_1 = core_1_1;
            }],
        execute: function() {
            FormTest = (function () {
                function FormTest(formBuilder) {
                    this.btnvalue = "Select Hero Power";
                    //this.model = new Hero(18, 'tornado', 'turbulent', 'wind');
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
                    //this.testForm['controls'].
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
            exports_1("FormTest", FormTest);
        }
    }
});

//# sourceMappingURL=formtest.js.map
