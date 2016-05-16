System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var GameType;
    return {
        setters:[],
        execute: function() {
            GameType = (function () {
                function GameType(level, type) {
                    this.level = level;
                    this.type = type;
                }
                return GameType;
            }());
            exports_1("GameType", GameType);
        }
    }
});

//# sourceMappingURL=gametype.js.map
