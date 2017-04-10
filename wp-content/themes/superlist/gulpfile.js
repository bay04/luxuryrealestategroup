'use strict';

var gulp = require( './node_modules/gulp' );
var sass = require( './node_modules/gulp-sass' );
var sourcemaps = require('./node_modules/gulp-sourcemaps');

gulp.task('compile', function() {
	gulp.src( './assets/scss/*.scss' )
		.pipe( sass() )
		.pipe( gulp.dest( './assets/css/' ) );
});

gulp.task('compile-main', function() {
	gulp.src( './assets/scss/superlist-mint.scss' )
		.pipe(sourcemaps.init())
		.pipe( sass() )
		.pipe(sourcemaps.write('./maps'))
		.pipe( gulp.dest( './assets/css/' ) );
});

gulp.task('compile-custom', function() {
    gulp.src( './assets/scss/superlist-custom.scss' )
	.pipe( sass() )
	.pipe( gulp.dest( './assets/css/' ) );
});

gulp.task('watch', function() {
	gulp.watch( './assets/scss/superlist-mint.scss', ['compile-main'] );
	gulp.watch( './assets/scss/helpers/*.scss', ['compile-main'] );
});
