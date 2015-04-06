define([
  'jquery',
  'underscore',
  'backbone'
], function($, _, Backbone){
  var Votes = Backbone.Collection.extend({
  	url: '/votes'
  	model: Vote
  });

  return Votes;
});