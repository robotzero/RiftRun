/**
 * Util function to transform Post data to send to API
 * @param {Array<any>} data
 */
import {PostListDto} from "../post-list-dto";

export function postTranformOut(data: PostListDto): Object {
    return { "player": {
                "type": data.playerType.toLowerCase(),
                "paragonPoints": data.playerParagonPoints,
                "battleTag": "#" + data.playerBattleTag,
                "region": data.playerRegion,
                "seasonal": data.playerSeason,
                "gameType": data.playerGameType.toLowerCase()
        },
            "query": {
                "minParagon": data.queryMinParagon,
                "game": {
                    "gameMode": data.queryGameType.toLowerCase(),
                    "level": data.queryGameLevel
                },
                "playerCharacters": [{"type": data.queryCharacterType.toLowerCase()}]
            }
    };
}