import {provideRouter, RouterConfig} from '@angular/router'
import {Post} from "./components/post/post";

export const appRoutes: RouterConfig = [
    { path: '', component: Post},
];

export const APP_ROUTER_PROVIDER = provideRouter(appRoutes);