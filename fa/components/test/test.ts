import {Component, ElementRef, NgZone, CORE_DIRECTIVES} from 'angular2/angular2';

@Component({
    selector: 'test',
    directives: [CORE_DIRECTIVES],
    templateUrl: './components/test/test.html',
    //template:`
    //    <div style="background-color: papayawhip; height:500px;">
    //        <span [style.color] = "color"> TEST </span>
    //        <input [value] = "color">
    //    </div>
    //`
})

export class Test {
    color = 'red';

    constructor() {}
}