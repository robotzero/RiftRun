var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") return Reflect.decorate(decorators, target, key, desc);
    switch (arguments.length) {
        case 2: return decorators.reduceRight(function(o, d) { return (d && d(o)) || o; }, target);
        case 3: return decorators.reduceRight(function(o, d) { return (d && d(target, key)), void 0; }, void 0);
        case 4: return decorators.reduceRight(function(o, d) { return (d && d(target, key, o)) || o; }, desc);
    }
};
var angular2_1 = require('angular2/angular2');
var APIGetService = (function () {
    function APIGetService(http) {
        this.http = http;
    }
    APIGetService.prototype.get = function (url) {
        //this.aloha = {};
        //this.http.get('http://riftrun.local/v1/posts').map(res => {
        //    console.log(res);
        //    this.aloha = res.json();
        //    return this.aloha;
        //});
        return this.http.get(url).map(function (res) { return res.json(); });
    };
    APIGetService = __decorate([
        angular2_1.Injectable()
    ], APIGetService);
    return APIGetService;
})();
exports.APIGetService = APIGetService;
//# sourceMappingURL=apigetservice.js.map