import {TodoItem} from '../../models/models';
import {Component} from "angular2/core";
import {FormBuilder} from "angular2/common";
import {NgFor} from "angular2/common";
import {NgIf} from "angular2/common";
import {FORM_DIRECTIVES} from "angular2/common";
import {View} from "angular2/core";
import {ControlGroup} from "angular2/common";
import {Validators} from "angular2/common";

// Annotation section
@Component({
    selector: 'todo',
    viewBindings: [FormBuilder]
})

@View({
    templateUrl: './app/components/todo/todo.html',
    directives: [NgFor, NgIf, FORM_DIRECTIVES]
})
    // Component controller
export class Todo {
    todos: Array<TodoItem>;
    myForm: ControlGroup;

    constructor(fb: FormBuilder) {
        this.todos = new Array<TodoItem>();
        this.todos.push(new TodoItem("Hello world", false));
        this.myForm = fb.group({
            newTodo: ['', Validators.required]
        });
    }

    removeTodo(item: TodoItem) {
        this.todos.splice(this.todos.indexOf(item), 1);
    }

    onSubmit(value) {
        this.todos.push(new TodoItem(value, false));
    }
}