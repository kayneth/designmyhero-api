'use strict';

var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var csso = require('gulp-csso');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var csscomb = require('gulp-csscomb');
var mainBowerFiles = require('main-bower-files');
var flatten = require('gulp-flatten');
var gulpFilter = require('gulp-filter');
var uglify = require('gulp-uglify');
var rename = require("gulp-rename");
var babel = require('gulp-babel');
var imagemin = require('gulp-imagemin');
var cache = require('gulp-cache');
var browserSync = require('browser-sync');

// Configurable paths for the application
var dist_path = "./web/dist";
var src_path = "./web/src";


gulp.task('sass', function () {
    return gulp.src(src_path + '/scss/**/*.scss')
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
        }}))
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer(['last 20 versions']))
        .pipe(csscomb())
        .pipe(gulp.dest(dist_path + '/css'))
        .pipe(rename({suffix: '.min'}))
        .pipe(csso())
        .pipe(gulp.dest(dist_path+'/css/'))
        .pipe(browserSync.reload({stream:true}))
});

gulp.task('sass:watch', function () {
    gulp.watch(src_path + '/sass/**/*.scss', ['sass']);
});

gulp.task('images', function(){
    gulp.src('web/src/images/**/*')
        .pipe(cache(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true })))
        .pipe(gulp.dest('web/dist/images/'));
});

gulp.task('js', function() {
    return gulp.src(src_path + '/js/*.js')
        .pipe(plumber({
            errorHandler: function (error) {
                console.log(error.message);
                this.emit('end');
        }}))
        .pipe(concat('scripts.js'))
        .pipe(babel())
        .pipe(gulp.dest(dist_path + '/js'))
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(uglify())
        .pipe(gulp.dest(dist_path + '/js'))
        .pipe(browserSync.reload({stream:true}))
        ;
});

gulp.task('vendor', function() {
    var jsFilter = gulpFilter('**/*.js', {restore: true}),
        cssFilter = gulpFilter('**/*.css', {restore: true}),
        fontFilter = gulpFilter(['**/*.eot', '**/*.woff', '**/*.svg', '**/*.ttf'], {restore: true});

    return gulp.src(mainBowerFiles())

    // grab vendor js files from bower_components, minify and push in /public
        .pipe(jsFilter)
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest(dist_path + '/js'))
        .pipe(uglify())
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(gulp.dest(dist_path + '/js'))
        .pipe(jsFilter.restore)

        // // grab vendor css files from bower_components, minify and push in /public
        .pipe(cssFilter)
        .pipe(concat('vendor.css'))
        .pipe(gulp.dest(dist_path + '/css'))
        .pipe(csso())
        .pipe(uglify())
        .pipe(rename({
            suffix: ".min"
        }))
        .pipe(gulp.dest(dist_path + '/css'))
        .pipe(cssFilter.restore)

        // // grab vendor font files from bower_components and push in /public
        .pipe(fontFilter)
        .pipe(flatten())
        .pipe(gulp.dest(dist_path + '/fonts'))
    ;
});

gulp.task('browser-sync', function() {
    browserSync({
        server: {
            baseDir: "./"
        }
    });
});

gulp.task('bs-reload', function () {
    browserSync.reload();
});

// Watch Files For Changes
gulp.task('watch', function () {
    gulp.watch('./web/scss/*.sass', ['sass']);
});

// Tasks
// gulp.task('default', ['sass']);
gulp.task('default', ['browser-sync'], function(){
    gulp.watch("web/src/scss/**/*.scss", ['sass']);
    gulp.watch("web/src/js/**/*.js", ['js']);
    gulp.watch("*.html", ['bs-reload']);
    gulp.watch("*.html.twig", ['bs-reload']);
});