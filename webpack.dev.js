const merge = require('webpack-merge');
const common = require('./webpack.common.js');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = merge(common, {
  mode: 'development',
  devtool: 'inline-source-map',
  devServer: {
    openPage: ''
  },
  plugins: [
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      proxy: 'mayhem-wrestling/',
      tunnel: true,
      files: [
        './',
        './*.php',
        './src/*',
        '!./node_modules',
        '!./package.json',
        '!./style.css.map',
        '!./app.js.map',
      ],
      reloadDelay: 0,
    }),
  ]
});