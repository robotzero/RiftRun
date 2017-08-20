export interface PostDTO {
    player: {
        type: string;
        paragonPoints: number;
        battleTag: string;
        region: string;
        gameType: string;
        season: boolean;
    };
    query: {
        minParagon: number;
        game: {
            gameLevel?: string;
            torment?: string;
            gameMode: string;
        };
        playerCharacters: Array<SearchedCharacters>
    }
}

export interface SearchedCharacters {
    type: string;
    selected: boolean;
}