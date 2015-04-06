define([
  'jquery',
  'underscore',
  'backbone'
], function($, _, Backbone){
  var Vote = Backbone.Model.extend({
    urlRoot: '/votes'
  });

  return Vote;
});