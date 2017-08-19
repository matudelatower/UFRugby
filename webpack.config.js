// webpack.config.js
var Encore = require('@symfony/webpack-encore');

var env = require('./env.json');

Encore
// directory where all compiled assets will be stored
    .setOutputPath('web/build/')

    // what's the public path to this directory (relative to your project's document root dir)
    .setPublicPath(env.publicPath)

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // will output as web/build/app.js
    .addEntry('app', './assets/js/main.js')

    // will output as web/build/global.css
    .addStyleEntry('global', './assets/css/global.scss')

    // allow sass/scss files to be processed
    .enableSassLoader(function (sassOptions) {
    }, {
        resolve_url_loader: false
    })
    .enableLessLoader()
    // .enableLessLoader((options) => {
    //     options.relativeUrls = false;
    // })

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    // .addLoader(
    //     {
    //         test: /\.less$/,
    //         use: [{
    //             loader: "style-loader"
    //         }, {
    //             loader: "css-loader"
    //         }, {
    //             loader: "less-loader", options: {
    //                 strictMath: true,
    //                 noIeCompat: true
    //             }
    //         }]
    //     }
    // )

    .enableSourceMaps(!Encore.isProduction())

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();