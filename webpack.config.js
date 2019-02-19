var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/js/app.js')
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())

    .enableSassLoader()
    .enableTypeScriptLoader()

    .addPlugin(
        new CopyWebpackPlugin([
            {
                from: './assets/static',
                to: 'static',
            },
        ])
    )
;

// Begin TypeScript Workaround - https://github.com/symfony/webpack-encore/issues/186
let config = Encore.getWebpackConfig();

let tsLoader = config.module.rules.filter(rule => {
    return Array.isArray(rule.use) && rule.use.some(use => use.loader === 'ts-loader')
})[0];
delete tsLoader.exclude;

module.exports = config;
// End TypeScript Workaround

// module.exports = Encore.getWebpackConfig();
