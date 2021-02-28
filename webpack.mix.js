let mix = require('laravel-mix');

let themePath = 'wp-content/themes/kaelri/';

mix
.options({
  processCssUrls: false,
})
.sass( themePath + 'sass/main.scss', themePath + 'css', {
  sassOptions: {
      outputStyle: 'compressed',
  }
})
.disableNotifications();
