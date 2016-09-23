var gulp = require('gulp');
var rename = require('gulp-rename');
var less = require('gulp-less');
var cleanCSS = require('gulp-clean-css');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var replace = require('gulp-replace');
var gulpUtil = require('gulp-util');
var THEME_ROOT = 'wp-content/themes/irenesalomo/';

gulp.task('less', function () {
    return gulp.src(THEME_ROOT + 'assets/css/src/main.less')
        .pipe(less())
        .pipe(cleanCSS({
            compatibility: 'ie7',
            restructuring: false
        }))
        .pipe(rename({
            extname: '.min.css'
        }))
        .pipe(gulp.dest(THEME_ROOT + 'assets/css/build'));
});

gulp.task('watch', function () { // Watch .scss files
    gulp.watch(THEME_ROOT + 'assets/css/src/*.less', ['less']); // Watch .less files
    ;
});

gulp.task('js', function () {
    return gulp.src([
        THEME_ROOT + 'assets/js/src/main.js',
      ])
        .pipe(uglify({
            mangle: true
        }).on('error', gulpUtil.log))
    //.pipe(uglify().on('error', gulpUtil.log)) // notice the error event here
        .pipe(rename({
            extname: '.min.js'
        }))
        .pipe(gulp.dest(THEME_ROOT + 'assets/js'));
});

gulp.task('bump-version', function () {
    gulp.src([THEME_ROOT + '/functions.php'])
        .pipe(replace(/define\('THEME_VERSION', '.*?'\);/, "define('THEME_VERSION', '" + Date.now() + "');"))
        .pipe(gulp.dest(THEME_ROOT));
});

gulp.task('default', ['less', 'js', 'js-accordionpane', 'js-tabbedpane', 'js-tabbedview', 'js-infinite-scroll'], function () {});
