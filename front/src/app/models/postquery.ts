import {Player} from "./player";
import {Query} from "./query";

export class PostQuery {
    constructor(public player:Player = null, public query: Query = null) {}
}