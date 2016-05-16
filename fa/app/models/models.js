System.register([], function(exports_1, context_1) {
    "use strict";
    var __moduleName = context_1 && context_1.id;
    var TodoItem;
    return {
        setters:[],
        execute: function() {
            TodoItem = (function () {
                function TodoItem(text, completed) {
                    this.text = text;
                    this.completed = completed;
                }
                return TodoItem;
            }());
            exports_1("TodoItem", TodoItem);
        }
    }
});

//# sourceMappingURL=models.js.map
