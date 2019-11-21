"use strict"

const gulp = require('gulp');
const minify = require('gulp-minify');
const cleanCSS = require('gulp-clean-css');
const concat = require('gulp-concat');
const urlAdjuster = require('gulp-css-replace-url');
const flatten = require('gulp-flatten');
const sass = require('gulp-sass');
sass.compiler = require('node-sass');

/* jQuery Select Areas */

function areaselectImages() {
    return gulp
        .src([
            'node_modules/jquery-select-areas/resources/bt-delete.png',
            'node_modules/jquery-select-areas/resources/filter.svg',
            'node_modules/jquery-select-areas/resources/outline.gif'
        ])
        .pipe(gulp.dest('public/img/areaselect'));
}

function areaselectCss() {
    return gulp
        .src([
            'node_modules/jquery-select-areas/resources/jquery.selectareas.css',
            'node_modules/jquery-select-areas/resources/jquery.selectareas.ie8.css'
        ])
        .pipe(urlAdjuster({
            replace: ['','/img/areaselect/'],
        }))
        .pipe(gulp.dest('assets/css'));
}

function areaselectJs() {
    return gulp
        .src([
            'node_modules/jquery-select-areas/jquery.selectareas.js'
        ])
        .pipe(gulp.dest('public/js/'));
}

const buildAreaselect = gulp.series(areaselectImages, areaselectCss, areaselectJs);


/* Leaflet */

function leafletImages() {
    return gulp
        .src('node_modules/leaflet/dist/images/*')
        .pipe(gulp.dest('public/img/leaflet'));
}

function leafletCss() {
    return gulp
        .src('node_modules/leaflet/dist/leaflet.css')
        .pipe(urlAdjuster({
            replace: ['images/','/img/leaflet/'],
        }))
        .pipe(gulp.dest('assets/css'));
}

const buildLeaflet = gulp.series(leafletImages, leafletCss);


/* Leaflet-Extramarkers */

function extramarkersImages() {
    return gulp
        .src('node_modules/leaflet-extra-markers/dist/img/*')
        .pipe(gulp.dest('public/img/leaflet-extra-markers'));
}

function extramarkersCss() {
    return gulp
        .src('node_modules/leaflet-extra-markers/dist/css/leaflet.extra-markers.min.css')
        .pipe(urlAdjuster({
            replace: ['../img/','/img/leaflet-extra-markers/'],
        }))
        .pipe(gulp.dest('assets/css'));
}

function extramarkersJs() {
    return gulp
        .src('node_modules/leaflet-extra-markers/dist/js/leaflet.extra-markers.js')
        .pipe(gulp.dest('public/js/'));
}

const buildExtramarkers = gulp.series(extramarkersImages, extramarkersCss, extramarkersJs);


/* Font Awesome */

gulp.task('copy-fontawesome-fonts', function () {
    return gulp.src('node_modules/@fortawesome/fontawesome-pro/webfonts/*')
        .pipe(gulp.dest('public/fonts'));
});

gulp.task('build-fontawesome', ['copy-fontawesome-fonts']);


/* Assets */

gulp.task('copy-colorpicker-images', function () {
    return gulp.src('node_modules/bootstrap-colorpicker/dist/img/bootstrap-colorpicker/*')
        .pipe(gulp.dest('public/images/colorpicker/'));
});

gulp.task('copy-datatable-images', function () {
    return gulp.src('node_modules/datatables/media/images/*')
        .pipe(gulp.dest('public/images/datatables/'));
});

gulp.task('copy-asset-images', function () {
    return gulp.src('assets/images/*/*')
        .pipe(gulp.dest('public/images/'));
});

gulp.task('build-assets', ['copy-asset-images', 'copy-datatable-images', 'copy-colorpicker-images']);


/* CSS */

gulp.task('sass', function () {
    return gulp.src('assets/scss/criticalmass.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest('assets/css'));
});

gulp.task('compress-css', ['leaflet-css', 'extramarkers-css', 'sass'], function () {
    return gulp.src([
            'assets/css/*.css',
            'node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
            'node_modules/bootstrap-slider/dist/css/bootstrap-slider.min.css',
            'node_modules/dropzone/dist/min/dropzone.min.css',
            'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css',
            'node_modules/datatables/media/css/jquery.dataTables.min.css',
            'node_modules/leaflet.markercluster/dist/MarkerCluster.Default.css',
            'node_modules/leaflet.locatecontrol/dist/L.Control.Locate.min.css',
            'node_modules/datatables/media/css/jquery.dataTables.min.css',
            'node_modules/leaflet-groupedlayercontrol/dist/leaflet.groupedlayercontrol.min.css',
            'node_modules/@fortawesome/fontawesome-pro/css/all.min.css',
        ])
        .pipe(cleanCSS())
        .pipe(concat('criticalmass.min.css'))
        .pipe(urlAdjuster({
            replace: ['webfonts/','fonts/'],
        }))
        .pipe(gulp.dest('public/css/'));
});

gulp.task('build-css', ['sass', 'compress-css']);


/* Javascript */

gulp.task('copy-js-modules', function () {
	return gulp.src([
		'assets/js/**/**/**/*.js',
	    ])
        .pipe(flatten())
		.pipe(gulp.dest('public/js/'));
});

gulp.task('copy-js-external', function () {
    return gulp.src([
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
        'node_modules/dropzone/dist/dropzone-amd-module.js',
        'node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
        'node_modules/bootstrap-slider/dist/bootstrap-slider.js',
        'node_modules/dateformat/lib/dateformat.js',
        'node_modules/jquery/dist/jquery.js',
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/typeahead.js/dist/bloodhound.js',
        'node_modules/typeahead.js/dist/typeahead.jquery.js',
        'node_modules/leaflet/dist/leaflet.js',
        'node_modules/leaflet.markercluster/dist/leaflet.markercluster.js',
        'node_modules/leaflet.locatecontrol/src/L.Control.Locate.js',
        'node_modules/chart.js/dist/Chart.bundle.js',
        'node_modules/datatables/media/js/jquery.dataTables.js',
        'node_modules/cookie-notice/dist/cookie.notice.js',
        'node_modules/leaflet-sleep/Leaflet.Sleep.js',
        'node_modules/jquery-select-areas/jquery.selectareas.js',
        'node_modules/requirejs/require.js',
        'node_modules/polyline-encoded/Polyline.encoded.js',
        'node_modules/leaflet-groupedlayercontrol/src/leaflet.groupedlayercontrol.js',
    ])
        .pipe(gulp.dest('public/js/'));
});

gulp.task('compress-js', ['copy-js'], function () {
	return gulp.src([
		'public/js/*.js',
	])
		.pipe(minify({
			ext: {
				min: '.min.js'
			},
			noSource: true,
			ignoreFiles: ['*.min.js']
		}))
		.pipe(gulp.dest('public/js/'));
});

gulp.task('copy-js', ['copy-js-modules', 'copy-js-external']);

gulp.task('build-js', ['compress-js']);

gulp.task('build', ['build-areaselect', 'build-leaflet', 'build-leaflet-extramarkers', 'build-fontawesome', 'build-assets', 'build-js', 'build-css'], function () {});

gulp.task('default', ['build']);
