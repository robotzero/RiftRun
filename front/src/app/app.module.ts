import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { FormsModule } from "@angular/forms";
import { PostModule } from "./components/post/post.module";
import { AppRoutingModule } from "./app.routing";
import { HttpModule } from "@angular/http";
import { MaterialModule } from "./components/material/material.module";

@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    PostModule,
    AppRoutingModule,
    MaterialModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
