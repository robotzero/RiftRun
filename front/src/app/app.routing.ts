import { NgModule } from '@angular/core';
import { PreloadAllModules, RouterModule, Routes } from '@angular/router';

// import { NotFoundComponent } from './not-found.component';
import {PostListComponent} from "./components/post/post-list/post-list.component";

const routes: Routes = [
    // {
    //     path:'test',
    //     loadChildren: 'app/test/test.module#TestModule'
    // },
    {
        path: '',
        component: PostListComponent
    },
    // {
    //     path: '**',
    //     component: NotFoundComponent
    // }
];

@NgModule({
    imports: [RouterModule.forRoot(routes, { preloadingStrategy: PreloadAllModules })],
    exports: [RouterModule]
})
export class AppRoutingModule { }