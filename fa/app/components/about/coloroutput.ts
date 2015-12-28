import {ElementRef} from "angular2/core";
import {Renderer} from "angular2/core";
import {Component} from "angular2/core";
import {MyCustomTest} from "../../directives/mydirective/mydirective";

@Component({
    selector: 'color-output',
    template: `
        <p> Color entered is {{color}} </p>,
    `,
    directives: [MyCustomTest]
})
export class ColorOutput {
    color: string;
    el: ElementRef;
    renderer: Renderer;

    constructor(el: ElementRef, renderer: Renderer)
    {
        this.color = '';
        this.el = el;
        this.renderer = renderer;
    }

    getColor(color) {
        this.color = color;
        this.renderer.setElementStyle(this.el, 'color', this.color);
    }
}