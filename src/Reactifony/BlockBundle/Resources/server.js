// var express = require('express');
// var bodyParser = require('body-parser');
// var app = express();
var webpack = require('webpack');
var WebpackDevServer = require('webpack-dev-server');
var config = require('./webpack.config');

// app.use(bodyParser.json());
// app.use(bodyParser.urlencoded({extended: true}));

// app.all('/*', function(req, res, next) {
//   res.header('Access-Control-Allow-Origin', '*');
//   res.header('Access-Control-Allow-Headers', 'X-Requested-With');
//   next();
// });

// app.listen(3001);

var server = new WebpackDevServer(webpack(config), {
  publicPath: config.output.publicPath
});

server.listen(3000, 'localhost', function(err, result) {
  if (err) {
    console.log(err);
  }
});
