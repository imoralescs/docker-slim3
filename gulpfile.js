var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');

// CSS Task
gulp.task('build:css', function() {
	var gulpSass = require('gulp-sass');
	var bourbon = require('node-bourbon');
  var neat = require("node-neat");

	var sassOptions = {
		errLogToConsole: true,
		linefeed: 'lf', // 'lf'/'crlf'/'cr'/'lfcr'
		outputStyle: 'compressed', // 'nested','expanded','compact','compressed'
		sourceComments: false,
		includePaths: bourbon.includePaths,
    includePaths: neat.includePaths
	};

	return gulp.src('./fed/scss/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(gulpSass(sassOptions))
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest('./public/assets/css/'));
});

// Watch and Default Task
gulp.task('default', ['build:css'], function () {
  gulp.watch('fed/scss/**/*.scss', ['build:css']);
  gulp.watch('public/assets/css/*.css');
});
