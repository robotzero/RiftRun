export class Player {
    constructor(
        public type: string,
        public paragonPoints: number,
        public battleTag: string,
        public region: string,
        public seasonal: boolean,
        public gametype: string,
        public id?: number
    ) {}
}