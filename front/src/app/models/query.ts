import {IPlayerCharacter} from "./playercharacter";
import {IGame} from "./game";

export interface IQuery {
    id: string;
    minParagon: number;
    gameMode: IGame;
    playerCharacters: IPlayerCharacter[];
}