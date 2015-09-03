var nib = require('nib')
var path = require('path')
var webpack = require('webpack')
var ExtractTextPlugin = require("extract-text-webpack-plugin")

var outputPath = path.resolve(__dirname, 'resources', 'assets');
var adminPath = path.resolve(__dirname, 'src', 'admin.js');
var clientPath = path.resolve(__dirname, 'src/js/client', 'clientIndex.jsx');

module.exports = [{
  entry: {
    admin     : adminPath,
    client    : clientPath
  },
  output: {
    path: outputPath,
    filename: '[name].js'
  },
  module: {
    loaders: [
      { test: /\.styl$/, loader: ExtractTextPlugin.extract("style", "css!stylus")},
      { test: /\.jsx$|\.js$/, loader: 'babel' },
      { test: /reactfire/, loader: "react-proxy", loader: "imports?this=>window" }
    ]
  },

  plugins: [
    new ExtractTextPlugin('styles.css'),
    new webpack.optimize.UglifyJsPlugin({minimize:true})
  ],

  resolve: {
    context: __dirname,
    extensions: ['','.js', '.json', '.jsx', '.styl'],
    modulesDirectories: [
      'widgets', 'javascripts', 'web_modules', 'node_modules'
    ]
  },

  stylus: {
    use: [nib()]
  }

}]
