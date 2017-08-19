// require('expose?$!expose?jQuery!jquery');

// We need bootstrap for bootstrap-webpack
require('bootstrap');
// require('bootstrap-webpack');

// AdminLTE, skins and font-awesome
require('admin-lte'); // 'admin-lte/dist/js/app.min.js'
require('admin-lte/build/less/AdminLTE.less');
require('admin-lte/build/less/skins/_all-skins.less');
require('font-awesome/less/font-awesome.less');

// Add other libraries here..
require('holderjs');
require('jquery-slimscroll');

// Fastclick prevents the 300ms touch delay on touch devices
var attachFastClick = require('fastclick');
attachFastClick.attach(document.body);