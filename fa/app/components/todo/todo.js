System.register(['../../models/models', "angular2/core", "angular2/common"], function(exports_1) {
    var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
        var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
        if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
        else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
        return c > 3 && r && Object.defineProperty(target, key, r), r;
    };
    var __metadata = (this && this.__metadata) || function (k, v) {
        if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
    };
    var models_1, core_1, common_1, common_2, common_3, common_4, core_2, common_5;
    var Todo;
    return {
        setters:[
            function (models_1_1) {
                models_1 = models_1_1;
            },
            function (core_1_1) {
                core_1 = core_1_1;
                core_2 = core_1_1;
            },
            function (common_1_1) {
                common_1 = common_1_1;
                common_2 = common_1_1;
                common_3 = common_1_1;
                common_4 = common_1_1;
                common_5 = common_1_1;
            }],
        execute: function() {
            // Annotation section
            Todo = (function () {
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
                        templateUrl: './app/components/todo/todo.html',
                        directives: [common_2.NgFor, common_3.NgIf, common_4.FORM_DIRECTIVES]
                    }), 
                    __metadata('design:paramtypes', [common_1.FormBuilder])
                ], Todo);
                return Todo;
            })();
            exports_1("Todo", Todo);
        }
    }
});

//# sourceMappingURL=todo.js.map
