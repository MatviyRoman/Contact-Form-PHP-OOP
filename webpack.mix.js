// webpack.mix.js

let mix = require('laravel-mix');
const folder = 'contact_form';
const disableNotifications = true; // disable Notifications after build
// const del = require('del');
// // (imagemin = false), // 1,2, or false
// (imagemin = 0), // 1,2, or false
// (jpgToJpg = true), //this work if choice imagemin 2
// (jpgToWebp = true); //this work if choice imagemin 2

mix.js(folder + '/src/js/*.js', folder + '/public').setPublicPath(
	folder + '/public'
);
mix.sass(folder + '/src/scss/style.scss', folder + '/public');

mix.browserSync('http://aform.ua');

if (disableNotifications) {
	mix.disableNotifications(); //this line disable notification
}
