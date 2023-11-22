const mix = require('laravel-mix')

// const WindiCSS = require('windicss')
const tailwindcss = require('tailwindcss')

mix.sass('resources/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss() ],
    })