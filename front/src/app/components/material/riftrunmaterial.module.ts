import {
    MdButtonModule, MdCardModule, MdCheckboxModule, MdInputModule, MdListModule, MdOptionModule, MdRadioModule,
    MdSelectModule
} from '@angular/material';
import { NgModule} from "@angular/core";

@NgModule({
    imports: [
        MdButtonModule,
        MdCheckboxModule,
        MdCardModule,
        MdButtonModule,
        MdListModule,
        MdInputModule,
        MdSelectModule,
        MdOptionModule,
        MdRadioModule
    ],

    exports: [
        MdButtonModule,
        MdCheckboxModule,
        MdCardModule,
        MdButtonModule,
        MdListModule,
        MdInputModule,
        MdSelectModule,
        MdOptionModule,
        MdRadioModule
    ],
})
export class RiftRunMaterialModule { }