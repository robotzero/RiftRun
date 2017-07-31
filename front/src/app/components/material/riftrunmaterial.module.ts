import {MdButtonModule, MdCardModule, MdCheckboxModule, MdInputModule, MdListModule} from '@angular/material';
import { NgModule} from "@angular/core";

@NgModule({
    imports: [ MdButtonModule, MdCheckboxModule, MdCardModule, MdButtonModule, MdListModule, MdInputModule ],
    exports: [ MdButtonModule, MdCheckboxModule, MdCardModule, MdButtonModule, MdListModule, MdInputModule ],
})
export class RiftRunMaterialModule { }