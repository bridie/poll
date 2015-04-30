define([
  'jquery',
  'underscore',
  'backbone',
  'models/vote'
], function($, _, Backbone, Vote){
  var Votes = Backbone.Collection.extend({
	url: '/votes',
  	model: Vote
  });

  return Votes;
});