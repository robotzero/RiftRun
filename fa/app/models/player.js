System.register([], function(exports_1) {
    var Player;
    return {
        setters:[],
        execute: function() {
            Player = (function () {
                function Player(id, type, paragonPoints, battleTag, region, seasonal, gametype) {
                    this.id = id;
                    this.type = type;
                    this.paragonPoints = paragonPoints;
                    this.battleTag = battleTag;
                    this.region = region;
                    this.seasonal = seasonal;
                    this.gametype = gametype;
                }
                return Player;
            })();
            exports_1("Player", Player);
        }
    }
});

//# sourceMappingURL=player.js.map
