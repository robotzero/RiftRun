import {IPlayer} from "./player";
import {IQuery} from "./query";

export interface IPost {
    id: string;
    player: IPlayer;
    query: IQuery;
}