var gulp = require('gulp');
var tsc = require('gulp-typescript');
var tsProject = tsc.createProject('tsconfig.json');
var config = require('./gulp.config.js')();

gulp.task('compile-ts', function() {
    var sourceTsFiles = [
      config.allTs,
        config.typings
    ];

    var tsResult = gulp.src(sourceTsFiles).pipe(tsc(tsProject));

    return tsResult.js.pipe(gulp.dest(config.tsOutputPath));
});