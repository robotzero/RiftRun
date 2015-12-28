import {Component} from "angular2/core";
import {CORE_DIRECTIVES} from "angular2/common";
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