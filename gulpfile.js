var gulp = require('gulp');
var gutil = require('gulp-util');
var sourcemaps = require('gulp-sourcemaps');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var watchify = require('watchify');
var browserify = require('browserify');
var lr = require('gulp-livereload');

var bundler = watchify(browserify('./src/js/index.jsx', watchify.args));
var client = watchify(browserify('./src/js/client/clientIndex.jsx', watchify.args));

bundler.transform('babelify');
client.transform('babelify');

gulp.task('js', bundleClient); // so you can run `gulp js` to build the file

function bundleClient() {
  return client.bundle()
    // log errors if they happen
    .on('error', gutil.log.bind(gutil, 'Browserify Error'))
    .pipe(source('client.js'))
    // optional, remove if you dont want sourcemaps
      .pipe(buffer())
      .pipe(sourcemaps.init({loadMaps: true})) // loads map from browserify file
      .pipe(sourcemaps.write('./')) // writes .map file
    //
    .pipe(gulp.dest('./resources/assets/'))
    .pipe(lr());
}

gulp.task('livereload', function() {
  return lr.listen();
});

gulp.task('default', ['js']);

