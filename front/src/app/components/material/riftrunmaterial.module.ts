import {
    MdButtonModule, MdCardModule, MdCheckboxModule, MdInputModule, MdListModule, MdOptionModule,
    MdSelectModule
} from '@angular/material';
import { NgModule} from "@angular/core";

@NgModule({
    imports: [ MdButtonModule, MdCheckboxModule, MdCardModule, MdButtonModule, MdListModule, MdInputModule, MdSelectModule, MdOptionModule ],
    exports: [ MdButtonModule, MdCheckboxModule, MdCardModule, MdButtonModule, MdListModule, MdInputModule, MdSelectModule, MdOptionModule ],
})
export class RiftRunMaterialModule { }