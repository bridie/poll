define([
  'jquery',
  'underscore',
  'backbone',
  'chart',
  'collections/votes'
], function($, _, Backbone, Chart, Votes){
  var ResultsView = Backbone.View.extend({
  	initialize: function(params) {
  		this.collection = new Votes();
  		this.collection.fetch({data: {urlComponent: params.urlComponent} }).done(function() {
        this.render();
      }.bind(this));
  	},

  	render: function() {
      //var data = [];
  		//var ctx = document.getElementById('resultsGraph').getContext('2d');
  		//var resultsChart = new Chart(ctx).Doughnut(data);
  	}
	});

	return ResultsView;
});