import {HostBinding} from "angular2/core";
import {Directive} from "angular2/core";

@Directive({
    selector: '[dropdown-test]'
})
export class Hostb {
    private open:boolean = false;

    @HostBinding('attr.aria-expanded')
    public get isOpen() {
        return this.open;
    }
}