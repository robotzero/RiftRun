import {Directive, Input} from 'angular2/core';
import {Output, EventEmitter} from "angular2/core";
import {Renderer} from "angular2/core";
import {ElementRef} from "angular2/core";
import {HostListener} from "angular2/core";

@Directive({
    selector: 'input[color]',
    events: ['colorChange'],
    host: {
        '(input)': 'updateColor($event)'
    }
})

export class MyCustomTest
{
    colorChange: EventEmitter<string>;

    constructor() {
        this.colorChange = new EventEmitter();
    }

    updateColor(event) {
        event.preventDefault();
        event.stopPropagation();
        var color = event.target.value;
        this.colorChange.emit(color);
    }
}