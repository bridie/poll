define([
  'jquery',
  'underscore',
  'backbone',
  'views/create-page',
  'views/poll-page',
  'views/results-page'
], function($, _, Backbone, CreatePage, PollPage, ResultsPage){
  var AppRouter = Backbone.Router.extend({
    routes: {
      '': 'createPage',
      ':urlComponent' : 'pollPage',
      ':urlComponent/results': 'resultsPage'
    },

    createPage: function() {
      var createPage = new CreatePage({ el: '#create-poll-page' });
    },

    pollPage: function(urlComponent) {
      var pollPage = new PollPage({ el: '#poll-page' });
    },

    resultsPage: function(urlComponent) {
      var resultsPage = new ResultsPage({ el: '#results-page', urlComponent: urlComponent });
    }

  });

  var initialize = function(){
    var app_router = new AppRouter;
    Backbone.history.start({ pushState: true });
  };

  return {
    initialize: initialize
  };
});