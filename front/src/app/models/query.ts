import {GameType} from "./gametype";
import {CharacterType} from "./charactertype";
export class Query
{
    constructor(
        public id:number,
        public minParagon:number,
        public gameType: GameType,
        public characterType: Array<CharacterType>
    ) {}
}