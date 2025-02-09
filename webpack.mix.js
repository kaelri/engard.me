let mix = require('laravel-mix');

let themePath = 'wp-content/themes/engard/common/';

mix
.options({
  processCssUrls: false,
})
.sass( themePath + 'sass/main.scss', themePath + 'css', {
  sassOptions: {
      outputStyle: 'compressed',
  }
})
.sass( themePath + 'sass/admin.scss', themePath + 'css', {
  sassOptions: {
      outputStyle: 'compressed',
  }
})
.combine([ themePath + 'js/main.js'  ], themePath + 'js/main.min.js' )
.disableNotifications();
