var gulp = require('gulp'),
	sass = require('gulp-sass'),
	concat = require('gulp-concat'),
	plumber = require('gulp-plumber'),
	notify = require('gulp-notify'),
	cssnano = require('gulp-cssnano'),
	flatten = require('gulp-flatten'),
	sourcemaps = require('gulp-sourcemaps'),
	uglify = require('gulp-uglify'),
	cssreplace = require('gulp-replace');

var theme_location = './wp-content/themes/fxprotools-theme',
	config = {
		theme_sass: theme_location + '/assets/sass/**/*.scss',
		theme_js: theme_location + '/assets/js/theme/custom/**/*.js',
		output: theme_location + '/assets'
	};

// ------------
// THEME - SASS
// ------------
gulp.task('fx-sass', function(){
	gulp.src(config.theme_sass)
		.pipe(plumber())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
		.pipe(cssreplace('/*!', '/*'))
		.pipe(concat('theme.css'))
		.pipe(cssnano())
		.pipe(gulp.dest(config.output + '/css/theme'))
		.pipe(notify('SASS processed'));
});

// ----------
// THEME - JS
// ----------
gulp.task('fx-js', function(){
	gulp.src(config.theme_js)
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(uglify({ mangle: true }))
		.pipe(concat('theme.js'))
		.pipe(sourcemaps.write(''))
		.pipe(gulp.dest(config.output + '/js/theme'))
		.pipe(notify('JS processed'));
});

// Default Task for watching sass
gulp.task('watch-sass', ['fx-sass'], function(){
	gulp.watch(config.theme_sass, ['fx-sass']);
});

// Default Task for watching js
gulp.task('watch-js', ['fx-js'], function(){
	gulp.watch(config.theme_js, ['fx-js']);
});

// Default Task for watching both sass/js
gulp.task('default', ['fx-sass', 'fx-js'], function(){
	gulp.watch(config.theme_sass, ['fx-sass']);
	gulp.watch(config.theme_js, ['fx-js']);
});

