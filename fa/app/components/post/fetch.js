System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    function status(response) {
        if (response.status >= 200 && response.status < 300) {
            return Promise.resolve(response);
        }
        return response.text().then(function (text) {
            throw new Error(text);
        });
    }
    exports_1("status", status);
    function text(response) {
        return response.text();
    }
    exports_1("text", text);
    function json(response) {
        return response.json();
    }
    exports_1("json", json);
    return {
        setters:[],
        execute: function() {
        }
    }
});

//# sourceMappingURL=fetch.js.map
