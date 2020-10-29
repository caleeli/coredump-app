const execSync = require('child_process').execSync;

process.env.VUE_APP_CONFIG = execSync('php artisan vue-app:config');

module.exports = {
    runtimeCompiler: true,
    pages: {
        index: {
            // entry for the page
            entry: 'resources/js/main.js',
            // the source template
            template: 'resources/index.html',
            // output as dist/index.html
            filename: 'index.html',
            // when using title option,
            // template title tag needs to be <title><%= htmlWebpackPlugin.options.title %></title>
            title: 'Index Page',
            // chunks to include on this page, by default includes
            // extracted common chunks and vendor chunks.
            chunks: ['chunk-vendors', 'chunk-common', 'index']
        }
    }
}
