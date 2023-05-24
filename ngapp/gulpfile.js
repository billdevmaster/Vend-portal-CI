var gulp = require('gulp');
var concat = require('gulp-concat');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');

var jsFiles = 'assets/js/*.js',
	jsCareer = 'career/*.js',
	jsCategories = 'categories/*.js',
	jsContact = 'contact/*.js',
	jsLogin = 'login/*.js',
	jsProducts = 'products/*.js',
	jsRegister = 'register/*.js',
    jsDest = 'dist/scripts';

gulp.task('scripts', function() {
    return gulp.src(['main.js',jsFiles,jsCareer,jsCategories,jsContact,jsLogin,jsProducts,jsRegister])
        .pipe(concat('scripts.js'))
        .pipe(gulp.dest(jsDest))
        .pipe(rename('scripts.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest(jsDest));
});