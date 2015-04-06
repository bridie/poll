define([
  'jquery',
  'underscore',
  'backbone',
  'models/vote'
], function($, _, Backbone, Vote){
  var PollView = Backbone.View.extend({
	events: {
		'change input': 'vote'
	},

	vote: function(e) {
		var vote = new Vote();
			vote.save({ optionId: $(e.currentTarget).attr('id') });
		}
	});

	return PollView;
});