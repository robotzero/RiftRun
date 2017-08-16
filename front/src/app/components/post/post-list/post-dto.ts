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
            level?: string;
            torment?: string;
            gameMode: string;
        };
        playerCharacters: Array<SearchedCharacters>
    }
}

export interface SearchedCharacters {
    playerCharacter: {
        type: string
    }
}