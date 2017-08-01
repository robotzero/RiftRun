import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { PostListComponent } from "./post-list/post-list.component";
import { RiftRunMaterialModule } from "../material/riftrunmaterial.module";
import { APIGetService } from "../../services/apigetservice";

@NgModule({
    declarations: [ PostListComponent ],
    providers: [ APIGetService ],
    imports: [ BrowserModule, FormsModule, ReactiveFormsModule, RiftRunMaterialModule ]
})
export class PostModule { }