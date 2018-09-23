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

const styleSheetRule = {
  test: /\.scss$/,
  use: [
    MiniCssExtractPlugin.loader,
    {
      loader: 'css-loader',
      options: {
        importLoaders: 2,
      },
    },
    'postcss-loader',
    'sass-loader',
  ],
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
  module: {
    rules: [babelRule, esLintRule, styleSheetRule],
  },
  plugins: [
    new CleanWebpackPlugin(['dist']),
    new MiniCssExtractPlugin({
      filename: 'style.css',
    }),
  ],
};