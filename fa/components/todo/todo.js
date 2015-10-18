/// <reference path="../../models.ts" />
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") return Reflect.decorate(decorators, target, key, desc);
    switch (arguments.length) {
        case 2: return decorators.reduceRight(function(o, d) { return (d && d(o)) || o; }, target);
        case 3: return decorators.reduceRight(function(o, d) { return (d && d(target, key)), void 0; }, void 0);
        case 4: return decorators.reduceRight(function(o, d) { return (d && d(target, key, o)) || o; }, desc);
    }
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var angular2_1 = require('angular2/angular2');
var angular2_2 = require('angular2/angular2');
var angular2_3 = require('angular2/angular2');
var models_1 = require('../../models');
var Todo = (function () {
    function Todo(fb) {
        this.todos = new Array();
        this.todos.push(new models_1.TodoItem("Hello world", false));
        this.myForm = fb.group({
            newTodo: ['', angular2_3.Validators.required]
        });
    }
    Todo.prototype.removeTodo = function (item) {
        this.todos.splice(this.todos.indexOf(item), 1);
    };
    Todo.prototype.onSubmit = function () {
        this.todos.push(new models_1.TodoItem(this.newTodo.value, false));
        this.newTodo.updateValue('');
    };
    Todo = __decorate([
        angular2_1.Component({
            selector: 'todo',
            viewBindings: [angular2_2.FormBuilder]
        }),
        angular2_1.View({
            templateUrl: './components/todo/todo.html',
            directives: [angular2_1.NgFor, angular2_1.NgIf, angular2_2.FORM_DIRECTIVES]
        }), 
        __metadata('design:paramtypes', [angular2_2.FormBuilder])
    ], Todo);
    return Todo;
})();
exports.Todo = Todo;

//# sourceMappingURL=todo.js.map
