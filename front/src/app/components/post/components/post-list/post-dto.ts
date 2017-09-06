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
        playerCharacters: Array<PSearchQ>
    }
}

export interface SearchedCharacters {
    type: string;
    selected: boolean;
}

export type Partial<T> = {
    [P in keyof T]?: T[P];
};

export type PSearchQ = Partial<SearchedCharacters>