import {Component} from "angular2/core";
import {Hero} from "../Hero";

@Component({
    selector: 'hero-detail',
    inputs: ['hero'],
    //outputs: ['deleted'],
    template: `
        <div><b>{{currentHero.fullName}}</b></div>
    `
})

export class HeroDetailComponent
{
    public hero: Hero;

    public currentHero = new Hero(13, 'HELLO');
}