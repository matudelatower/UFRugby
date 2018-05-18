var Encore = require('@symfony/webpack-encore');
require('dotenv').config()

Encore
// the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    // .setPublicPath('/build')
    .setPublicPath(process.env.APP_PUBLIC_PATH)

    .setManifestKeyPrefix('build')


    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    // uncomment to define the assets of the project
    .addEntry('js/main', './assets/js/main.js')
    .addEntry('js/adminlte', './assets/js/adminlte.js')
    .addEntry('js/charts', './assets/js/charts.js')
    .addEntry('js/app', './assets/js/app.js')

    .addStyleEntry('css/main', './assets/css/main.scss')
    .addStyleEntry('css/adminlte', './assets/css/adminlte.scss')
    .addStyleEntry('css/charts', './assets/css/charts.scss')
    .addStyleEntry('css/app', './assets/css/app.scss')

    // uncomment if you use Sass/SCSS files
    .enableSassLoader(function (sassOptions) {
    }, {
        resolveUrlLoader: false
    })

    .enableVueLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
