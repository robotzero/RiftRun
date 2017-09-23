/**
 * Util function to transform Post data to send to API
 * @param {Array<any>} data
 */
import {IPlayerCharacter} from "../models/playercharacter";

export function postTranformOut(data: any): Object {
    console.log(data.query);
    data.query.playerCharacters = data.query.playerCharacters.filter(character => {
        return character.selected === true;
    }) as Array<Pick<IPlayerCharacter, 'type'>>;
    console.log(data.query);
    return data;
}