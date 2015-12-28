var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var models_1 = require('../../models');
var core_1 = require("angular2/core");
var common_1 = require("angular2/common");
var common_2 = require("angular2/common");
var common_3 = require("angular2/common");
var common_4 = require("angular2/common");
var core_2 = require("angular2/core");
var common_5 = require("angular2/common");
var Todo = (function () {
    function Todo(fb) {
        this.todos = new Array();
        this.todos.push(new models_1.TodoItem("Hello world", false));
        this.myForm = fb.group({
            newTodo: ['', common_5.Validators.required]
        });
    }
    Todo.prototype.removeTodo = function (item) {
        this.todos.splice(this.todos.indexOf(item), 1);
    };
    Todo.prototype.onSubmit = function (value) {
        this.todos.push(new models_1.TodoItem(value, false));
    };
    Todo = __decorate([
        core_1.Component({
            selector: 'todo',
            viewBindings: [common_1.FormBuilder]
        }),
        core_2.View({
            templateUrl: './components/todo/todo.html',
            directives: [common_2.NgFor, common_3.NgIf, common_4.FORM_DIRECTIVES]
        }), 
        __metadata('design:paramtypes', [common_1.FormBuilder])
    ], Todo);
    return Todo;
})();
exports.Todo = Todo;

//# sourceMappingURL=todo.js.map
