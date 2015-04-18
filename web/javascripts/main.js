require.config({
  paths: {
    jquery: 'vendor/jquery',
    underscore: 'vendor/underscore',
    backbone: 'vendor/backbone',
    jqueryCookie: 'vendor/jquery.cookie'
  }
});

require([
  'app',
], function(App){
  App.initialize();
});