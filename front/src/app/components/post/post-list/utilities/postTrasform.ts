/**
 * Util function to transform Post data to send to API
 * @param {Array<any>} data
 */
import {PostDTO} from "../post-dto";

export function postTranformOut(data: PostDTO): Object {
    return { "player": {
                "type": data.player.type.toLowerCase(),
                "paragonPoints": data.player.paragonPoints,
                "battleTag": "#" + data.player.battleTag,
                "region": data.player.region,
                "seasonal": data.player.season,
                "gameType": data.player.gameType.toLowerCase()
        },
            "query": {
                "minParagon": data.query.minParagon,
                "game": {
                    "gameMode": data.query.game.gameMode.toLowerCase(),
                    "level": data.query.game.level
                },
                "playerCharacters": [{"type": data.query.playerCharacters[0]}]
            }
    };
}