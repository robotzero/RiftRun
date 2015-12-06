import {Component, ElementRef, NgZone, CORE_DIRECTIVES, FORM_DIRECTIVES} from 'angular2/angular2';
import {Hero} from './hero';
@Component({
    selector: 'formtest',
    directives: [CORE_DIRECTIVES, FORM_DIRECTIVES],
    templateUrl: './components/formtest/formtest.html',
})

export class FormTest {
    model: Hero;
    powers: string[];

    constructor() {
        this.model = new Hero(18, 'tornado', 'turbulent', 'wind');
        this.powers = ['Smart', 'Breeze', 'Sup'];
    }

    onSubmit(value) {
        console.log(value.value);
    }
}