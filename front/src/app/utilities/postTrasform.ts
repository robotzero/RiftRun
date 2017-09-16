/**
 * Util function to transform Post data to send to API
 * @param {Array<any>} data
 */

export function postTranformOut(data: any): Object {
    data.query.playerCharacters = data.query.playerCharacters.filter(character => {
        return character.selected === true;
    }).map(character => {
        return {"type": character.type.toLowerCase()};
    });
    return data;
}