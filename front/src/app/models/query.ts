import {Game} from "./game";
import {PlayerCharacter} from "./playercharacter";
export class Query {
    constructor(
        public minParagon: number,
        public game: Game,
        public playerCharacters: Array<PlayerCharacter>,
        public id?: number
    ) {}
}