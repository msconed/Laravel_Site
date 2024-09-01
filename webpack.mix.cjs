let mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('tailwindcss'),
       require('autoprefixer'),
   ])
   .copy('resources/assets/images', 'public/assets/images') // Копируем изображения
   .copy('resources/assets/svg', 'public/assets/svg') // Копируем изображения
   .browserSync('http://127.0.0.1:8000/');
