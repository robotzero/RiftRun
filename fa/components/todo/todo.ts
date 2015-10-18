/// <reference path="../../models.ts" />

import {Component, View, NgFor, NgIf} from 'angular2/angular2';
import {FORM_DIRECTIVES, FormBuilder, ControlGroup, Control} from 'angular2/angular2';
import {Validators} from 'angular2/angular2';
import {TodoItem} from '../../models';

// Annotation section
@Component({
    selector: 'todo',
    viewBindings: [FormBuilder]
})

@View({
    templateUrl: './components/todo/todo.html',
    directives: [NgFor, NgIf, FORM_DIRECTIVES]
})
    // Component controller
export class Todo {
    todos: Array<TodoItem>;
    myForm: ControlGroup;
    newTodo: Control;

    constructor(fb: FormBuilder) {
        this.todos = new Array<TodoItem>();
        this.todos.push(new TodoItem("Hello world", false));
        this.myForm = fb.group({
            newTodo: ['', Validators.required]
        });

        //this.newTodo = this.myForm['newTodo'];
    }


    removeTodo(item: TodoItem) {
        this.todos.splice(this.todos.indexOf(item), 1);
    }

    onSubmit() {
        this.todos.push(new TodoItem(this.newTodo.value, false));
        this.newTodo.updateValue('');
    }
}