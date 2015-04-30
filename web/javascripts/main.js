require.config({
  paths: {
    jquery: 'vendor/jquery',
    underscore: 'vendor/underscore',
    backbone: 'vendor/backbone',
    jqueryCookie: 'vendor/jquery.cookie',
    chart: 'vendor/chart'
	}
});

require([
  'app',
], function(App){
  App.initialize();
});