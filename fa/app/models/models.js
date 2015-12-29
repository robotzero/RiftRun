System.register([], function(exports_1) {
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
            })();
            exports_1("TodoItem", TodoItem);
        }
    }
});

//# sourceMappingURL=models.js.map
