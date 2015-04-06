define([
  'jquery',
  'underscore',
  'backbone',
  'views/create-page',
  'views/poll-page'
], function($, _, Backbone, CreatePage, PollPage){
  var AppRouter = Backbone.Router.extend({
    routes: {
      '': 'createPage',
      ':urlComponent' : 'pollPage'
    },

    createPage: function() {
      var createPage = new CreatePage({ el: '#create-poll-page' });
    },

    pollPage: function(urlComponent) {
      var pollPage = new PollPage({ el: '#poll-page '})
    },

  });

  var initialize = function(){
    var app_router = new AppRouter;
    Backbone.history.start({ pushState: true });
  };

  return {
    initialize: initialize
  };
});