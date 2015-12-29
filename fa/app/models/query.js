System.register([], function(exports_1) {
    var Query;
    return {
        setters:[],
        execute: function() {
            Query = (function () {
                function Query(id, minParagon, gameType, characterType) {
                    this.id = id;
                    this.minParagon = minParagon;
                    this.gameType = gameType;
                    this.characterType = characterType;
                }
                return Query;
            })();
            exports_1("Query", Query);
        }
    }
});

//# sourceMappingURL=query.js.map
