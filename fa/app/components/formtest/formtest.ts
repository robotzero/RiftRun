import {Hero} from './hero';
import {CORE_DIRECTIVES} from "angular2/common";
import {FORM_DIRECTIVES} from "angular2/common";
import {FormBuilder} from "angular2/common";
import {ControlGroup} from "angular2/common";
import {Component} from "angular2/core";

@Component({
    selector: 'formtest',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES],
    templateUrl: './components/formtest/formtest.html',
    viewBindings: [FormBuilder]
})

export class FormTest {
    powers: string[];
    testForm: ControlGroup;
    btnvalue: string = "Select Hero Power";

    constructor(formBuilder: FormBuilder) {
        //this.model = new Hero(18, 'tornado', 'turbulent', 'wind');
        this.powers = ['Smart', 'Breeze', 'Sup'];
        this.testForm = formBuilder.group({
            hero: ['']
        });
    }

    onSubmit(value) {
        console.log(value.value);
    }

    selected(value) {
        this.btnvalue = value;
        //this.testForm['controls'].
    }
}