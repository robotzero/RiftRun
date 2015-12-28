import {Component, View} from 'angular2/core';
import {RouteParams} from 'angular2/router';
import {MyCustomTest} from "../../directives/mydirective/mydirective";
import {ColorOutput} from "./coloroutput";
import {HeroDetailComponent} from "./HeroDetailComponent";
import {Hostb} from "./hostb";

@Component({
    selector: 'about',
    template: `
		Welcome to the about page! <br>
		<input color (colorChange)="output.getColor($event)">
		<color-output #output ></color-output>
		<hero-detail [hero]="currentHero"></hero-detail>
		<div dropdown-test>TEST OF THE DROP DOWN TOGGLE</div>
	`,
    directives: [MyCustomTest, ColorOutput, HeroDetailComponent, Hostb]
})
export class About {
    id: string;

    constructor(params: RouteParams) {
        this.id = params.get('id');
    }
}