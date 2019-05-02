var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require("gulp-notify");
// file compiled
var cssWatch = "./assets/css/style.scss";
var cssWatchUrl = "./assets/css/*";
var cssDest = "./public/build/"
//compile

function watch_css() {
    gulp.watch(cssWatch, css)
}

function css(done) {
    gulp.src(cssWatch)
        .pipe(sass({
            errLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest(cssDest))
        .pipe( notify({message: 'Gulp is compile Done!'}) )
        ;
    done();
}

function watch_css(done) {
    gulp.watch(cssWatchUrl, css);
}

gulp.task('css_watch', gulp.series(watch_css));
gulp.task('css', css);
