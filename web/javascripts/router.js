define([
  'jquery',
  'underscore',
  'backbone',
  'views/create-page'
], function($, _, Backbone, CreatePage){
  var AppRouter = Backbone.Router.extend({
    routes: {
      '': 'createPage'
    },

    createPage: function() {
      var createPage = new CreatePage({ el: '#create-poll-page' });
    }
  });

  var initialize = function(){
    var app_router = new AppRouter;
    Backbone.history.start();
  };

  return {
    initialize: initialize
  };
});