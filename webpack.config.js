var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    .autoProvideVariables({
        "window.Bloodhound": require.resolve('bloodhound-js'),
        "jQuery.tagsinput": "bootstrap-tagsinput"
    })
    .enableSassLoader()
    .enableVersioning()
    .addEntry('js/app', './assets/js/app.js')
    .addEntry('js/mantis', './assets/js/mantis.js')
    .addEntry('js/mantis', './assets/js/dashy.js')
    .addEntry('js/mantis', './assets/js/index.js')        
    .addEntry('js/login', './assets/js/login.js')
    .addEntry('js/admin', './assets/js/admin.js')
    .addEntry('js/search', './assets/js/search.js')
    .addStyleEntry('css/app', ['./assets/scss/app.scss'])
    .addStyleEntry('css/app', ['./assets/scss/dashy.scss'])    
    .addStyleEntry('css/admin', ['./assets/scss/admin.scss'])
    .splitEntryChunks()
;

module.exports = Encore.getWebpackConfig();
