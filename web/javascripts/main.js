require.config({
  paths: {
    jquery: 'vendor/jquery',
    underscore: 'vendor/underscore',
    backbone: 'vendor/backbone'
  }
});

require([
  'app',
], function(App){
  App.initialize();
});