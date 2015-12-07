import {Component, ElementRef, NgZone, FormBuilder, CORE_DIRECTIVES, FORM_DIRECTIVES, ControlGroup} from 'angular2/angular2';
import {Hero} from './hero';
@Component({
    selector: 'formtest',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES],
    templateUrl: './components/formtest/formtest.html',
    viewBindings: [FormBuilder]
})

export class FormTest {
    powers: string[];
    testForm: ControlGroup;

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
}