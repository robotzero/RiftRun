import {MdButton, MdButtonModule, MdCard, MdCheckboxModule} from '@angular/material';
import {NgModule} from "@angular/core";

// import {MdInput} from "@angular2-material/input/input";

@NgModule({
    imports: [MdButtonModule, MdCheckboxModule, MdCard, MdButton],
    exports: [MdButtonModule, MdCheckboxModule, MdCard, MdButton],
})
export class MaterialModule { }