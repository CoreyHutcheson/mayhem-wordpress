const path = require('path');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const babelRule = {
  test: /\.js$/,
  exclude: /node_modules/,
  use: {
    loader: 'babel-loader',
    options: {
      presets: ['@babel/preset-env'],
    },
  },
};

const esLintRule = {
  enforce: 'pre',
  test: /\.js$/,
  exclude: /node_modules/,
  use: 'eslint-loader',
};

const sassRule = {
  test: /\.scss$/,
  use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader'],
};

const splitChunks = {
  chunks: 'all',
};

module.exports = {
  entry: {
    index: './src/js/index.js',
    roster: './src/js/roster.js',
  },
  output: {
    filename: '[name].bundle.js',
    path: path.resolve(__dirname, 'dist'),
  },
  mode: 'development',
  devtool: 'source-map',
  module: {
    rules: [babelRule, esLintRule, sassRule],
  },
  plugins: [
    new CleanWebpackPlugin(['dist']),
    new MiniCssExtractPlugin({
      filename: 'style.css',
    }),
  ],
  optimization: {
    splitChunks,
  },
};
