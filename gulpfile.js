'use strict';

var gulp = require('gulp'),
        sass = require('gulp-sass'),
        wrapper = require('gulp-wrapper'),
        cleanCSS = require('gulp-clean-css');


var admin_sass_path = './resources/sass/admin',
    public_sass_path = './resources/sass/public',
        admin_css_path = './wp-discord/admin/css',
        public_css_path = './wp-discord/public/css';

gulp.task('admin_sass', function () {
    return gulp.src(admin_sass_path + '/*.scss')
            .pipe(sass({includePaths: []}))
            .pipe(cleanCSS({compatibility: 'ie8'}))
            .pipe(sass().on('error', sass.logError))
            .pipe(gulp.dest(admin_css_path));
});

gulp.task('public_sass', function () {
    return gulp.src(public_sass_path + '/*.scss')
            .pipe(sass({includePaths:[]}))
            .pipe(cleanCSS({compatibility: 'ie8'}))
            .pipe(sass().on('error', sass.logError))
            .pipe(gulp.dest(public_css_path));
});

gulp.task('default', ['admin_sass', 'public_sass'], function () {
    //Silence is golden.
});