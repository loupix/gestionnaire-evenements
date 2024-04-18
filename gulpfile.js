'use strict';

var autoprefixer = require('gulp-autoprefixer');
var csso = require('gulp-csso');
var del = require('del');
var gulp = require('gulp');
var htmlmin = require('gulp-htmlmin');
var runSequence = require('run-sequence');
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var uglifyjs = require('gulp-uglifyjs');
var minify = require('gulp-minify-css');
var replace = require('gulp-replace');
var concat = require('gulp-concat');

// Concatenate & Minify JS
gulp.task('js', function() {
    return gulp.src('public/js/**/*.js')
        .pipe(replace(/"use strict"'/g, ';'))
        .pipe(concat('all.js'))
        .pipe(gulp.dest('public/dist'))
        .pipe(uglifyjs('all.min.js', {
            mangle:false
        }))
        .pipe(gulp.dest('public/dist'));
});



// Concatenate & Minify CSS
gulp.task('css', function() {
    return gulp.src('public/css/**/*.css')
        .pipe(concat('style.css'))
        .pipe(minify())
        .pipe(gulp.dest('public/dist'));
});




// Watch Files For Changes
gulp.task('watch', function() {
	gulp.watch('public/js/**/*.js', ['js']);
	gulp.watch('public/css/**/*.css', ['css']);
});

// Default Task
gulp.task('default', ['js','css']);