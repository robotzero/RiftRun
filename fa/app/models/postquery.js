System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var PostQuery;
    return {
        setters:[],
        execute: function() {
            PostQuery = (function () {
                function PostQuery(player, query) {
                    if (player === void 0) { player = null; }
                    if (query === void 0) { query = null; }
                    this.player = player;
                    this.query = query;
                }
                return PostQuery;
            }());
            exports_1("PostQuery", PostQuery);
        }
    }
});

//# sourceMappingURL=postquery.js.map
