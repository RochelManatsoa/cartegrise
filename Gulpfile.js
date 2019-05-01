var gulp = require('gulp');
var sass = require('gulp-sass');
//compile
gulp.task('css', function(done) {
    gulp.src('assets/css/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('./public/build/'));
    done();
});
