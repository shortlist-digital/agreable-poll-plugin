var nib = require('nib')
var path = require('path')
var ExtractTextPlugin = require("extract-text-webpack-plugin")

var buildPath = path.resolve(__dirname, 'resources', 'assets');
var mainAdminPath = path.resolve(__dirname, 'src', 'admin.js');
var mainPath = path.resolve(__dirname, 'src', 'main.js');

module.exports = [{
  entry: mainAdminPath,
  output: {
    path: buildPath,
    filename: 'admin.js'
  },
  module: {
    loaders: [
      { test: /\.js$/, exclude:'node_modules', loader: 'babel' }
    ]
  },

  plugins: [
  ],

  resolve: {
    context: __dirname,
    extensions: ['','.js', '.json'],
    modulesDirectories: [
      'widgets', 'javascripts', 'web_modules', 'node_modules'
    ]
  }

},{
  entry: mainPath,
  output: {
    path: buildPath,
    filename: 'app.js'
  },
  module: {
    loaders: [
      { test: /\.styl$/, loader: ExtractTextPlugin.extract("style", "css!stylus")},
      { test: /\.js$/, exclude:'node_modules', loader: 'babel' },
    ]
  },

  plugins: [
    new ExtractTextPlugin('styles.css')
  ],

  resolve: {
    context: __dirname,
    extensions: ['','.js', '.json', '.styl'],
    modulesDirectories: [
      'widgets', 'javascripts', 'web_modules', 'style-atoms', 'node_modules'
    ]
  },

  stylus: {
    use: [nib()]
  }
}]
