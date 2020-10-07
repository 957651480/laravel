const path = require('path');
const mix = require('laravel-mix');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
const createThemeColorReplacerPlugin = require('./resources/backend/config/plugin.config')
function resolve(dir) {
  return path.join(
    __dirname,
    '/resources/backend',
    dir
  );
}
const isProd = process.env.NODE_ENV === 'production'

const rawArgv = process.argv.slice(2);
const report = rawArgv.includes('--report');
let plugins = [];
if (report) {
  plugins.push(new BundleAnalyzerPlugin({
    openAnalyzer: true,
  }));
}
if(!isProd){
  plugins.push(createThemeColorReplacerPlugin);
}
module.exports = {
  resolve: {
    extensions: ['.js', '.vue', '.json'],
    alias: {
      vue$: 'vue/dist/vue.esm.js',
      '@': path.resolve(__dirname, 'resources/backend'),
      '@assets': path.resolve(__dirname, 'resources/backend/assets'),
      '@comp': path.resolve(__dirname, 'resources/backend/components'),
      '@views': path.resolve(__dirname, 'resources/backend/views'),
      '@layout': path.resolve(__dirname, 'resources/backend/layout'),
      '@static': path.resolve(__dirname, 'resources/backend/static'),
    },
  },
  module: {
    rules: [
      {
        test: /\.svg$/,
        loader: 'babel-loader',
        include: [resolve('assets')],
      },
      {
        test: /\.svg$/,
        loader: 'vue-svg-icon-loader',
        include: [resolve('assets')],
        options: {
          symbolId: 'icon-[name]',
        },
      },
      {
        test: /\.less$/,
        loader: 'less-loader',
        options: {
          javascriptEnabled: true
        }
      },
    ],
  },
  plugins: plugins,
};
