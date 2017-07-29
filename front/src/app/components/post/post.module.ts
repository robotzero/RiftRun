import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { PostListComponent } from "./post-list/post-list.component";
import { MaterialModule } from "../material/material.module";

@NgModule({
    declarations: [
        PostListComponent
    ],
    imports: [BrowserModule, FormsModule, ReactiveFormsModule, MaterialModule]
})
export class PostModule { }