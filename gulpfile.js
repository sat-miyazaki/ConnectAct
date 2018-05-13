'use strict'
var gulp = require('gulp');
var connect = require('gulp-connect-php');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var notify = require('gulp-notify');
var plumber = require('gulp-plumber');
var browserSync = require('browser-sync');
var sassLint = require('gulp-sass-lint');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var cssdeclsort = require('css-declaration-sorter');
var mqpacker = require('css-mqpacker');
var sourcemaps = require('gulp-sourcemaps');
var gulpCopy = require('gulp-copy');

gulp.task('sass', function(){
  gulp.src(['./_src/sass/**/*.scss', './_src/sass/**/*.sass'])
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(sass({outputStyle: 'expanded'}))
    .on('error', notify.onError(function(err) {
      return err.message;
    }))
    .pipe(postcss([autoprefixer({browsers: ['> 2%']})]))
    .pipe(postcss([cssdeclsort({order: 'smacss'})]))
    .pipe(postcss([mqpacker()]))
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./_assets/css'))
    .pipe(notify({
      title: 'Sass Build',
      message: 'Sass build complete'
     }));
});

gulp.task('sass-release', function() {
  gulp.src(['./_src/sass/**/*.scss', './_src/sass/**/*.sass'])
    .pipe(plumber())
    .pipe(sass({outputStyle: 'compressed'}))
    .pipe(postcss([autoprefixer({browsers: ['> 2%']})]))
    .pipe(postcss([cssdeclsort({order: 'smacss'})]))
    .pipe(postcss([mqpacker()]))
    .pipe(gulp.dest('./css'))
})

gulp.task('libs-copy', function() {
  gulp.src(['./node_modules/lightbox2/dist/css/lightbox.min.css',
            './node_modules/lightbox2/dist/images/**',
            './node_modules/lightbox2/dist/js/lightbox.min.js'])
    .pipe(gulpCopy('./_assets/libs/lightbox2', {prefix:3}));

  gulp.src(['./node_modules/jquery/dist/jquery.min.js'])
    .pipe(gulpCopy('./_assets/libs/', {prefix:3}))
})

gulp.task('watch', function(){
  watch(['./_src/sass/**/*.scss', './_src/sass/**/*.sass'], function() {
    return gulp.start(['sass']);
  });
  watch(['./_assets/css/**/*.css', './**/*.php', './**/*.html'], function() {
    return gulp.start(['bs-reload']);
  })
})

gulp.task('browser-sync', function() {
  connect.server({
    port: 8000,
    base: "./"
  }, function(){
    browserSync({
      server: {
        proxy: "localhost:8000"
      }
    })
  });
})

gulp.task('bs-reload', function() {
  browserSync.reload();
})

gulp.task('default',['browser-sync', 'watch']);
gulp.task('release',['sass-release']);
