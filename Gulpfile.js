var gulp = require('gulp');
var sass = require('gulp-sass');
var notify = require("gulp-notify");
// file compiled
var cssWatch = "./assets/css/style.scss";
var cssWatchUrl = "./assets/css/*";
var cssDest = "./public/build/"
//compile
// file compiled
var cssAdminWatch = "./assets/css/admin/style.scss";
var cssAdminDest = "./public/build/admin/css/"
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

function cssAdmin(done) {
    gulp.src(cssAdminWatch)
        .pipe(sass({
            errLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .pipe(gulp.dest(cssAdminDest))
        .pipe( notify({message: 'Gulp is compile Done!'}) )
        ;
    done();
}

function watch_css(done) {
    gulp.watch(cssWatchUrl, css);
}

gulp.task('css_watch', gulp.series(watch_css));
gulp.task('css', css);
gulp.task('css-admin', cssAdmin);
