///////////////////////////////////////////
// Include modules
// npm install gulp browser-sync gulp-sass sass gulp-plumber gulp-notify gulp-autoprefixer --save-dev
// npm update
// npm install (to install modules)
///////////////////////////////////////////


const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const browserSync = require('browser-sync').create();
const autoprefixer = require('gulp-autoprefixer');

const plumber = require('gulp-plumber');
const notify = require('gulp-notify');

// Autoprefixer options
const autoprefixerOptions = {
    overrideBrowserslist: ['last 2 versions', '>5%']
};

gulp.task('sass', function () {
    return gulp
        .src('sass/*style.scss')
        .pipe(plumber({ errorHandler: function(err) {
            notify.onError({
                title: "Gulp error in " + err.plugin,
                message:  err.toString()
            })(err);
            // stop pipe
            this.emit('end');
        }}))
        .pipe(sass())
        .pipe(autoprefixer(autoprefixerOptions))
        .pipe(gulp.dest('./'))
        .pipe(browserSync.stream());
});

gulp.task('watch', function () {
    gulp.watch('sass/**/*.scss', gulp.series('sass'));
    gulp.watch('blocks/**/*.scss', gulp.series('sass'));
    gulp.watch('./*.php', gulp.series('reload'));
    gulp.watch('./includes/**/*.{html,php,js,css}', gulp.series('reload'));
    gulp.watch('./blocks/*.{html,php,js,css}', gulp.series('reload'));
    gulp.watch('./blocks/**/*.{html,php,js,css}', gulp.series('reload'));
});

gulp.task('serve', function () {
    // Initialize Browsersync with a PHP server - change proxy URL
    browserSync.init({
      proxy: "http://revitalline-consumer.local/"
  });
});

gulp.task('reload', function (done) {
    browserSync.reload();
    done();
});

gulp.task('default', gulp.parallel('serve','sass','watch'));