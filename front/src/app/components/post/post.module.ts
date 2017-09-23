import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { ReactiveFormsModule, FormsModule } from '@angular/forms';
import { PostListComponent } from "./components/post-list/post-list.component";
import { RiftRunMaterialModule } from "../material/riftrunmaterial.module";
import { APIGetService } from "../../services/apigetservice";
import { GameModeService } from "../../services/gamemodeservice";
import { RomanNumerals } from "../../pipes/roman-numerals";
import { PostSearchComponent } from "./components/post-search/post-search.component";
import { RiftRunComponent } from "./containers/rift-run/rift-run.component";

@NgModule({
    declarations: [ PostListComponent, RomanNumerals, PostSearchComponent, RiftRunComponent ],
    providers: [ APIGetService, GameModeService ],
    imports: [ BrowserModule, FormsModule, ReactiveFormsModule, RiftRunMaterialModule ]
})
export class PostModule { }