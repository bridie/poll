define([
  'jquery',
  'underscore',
  'backbone',
  'models/vote'
], function($, _, Backbone, Vote){
  var PollView = Backbone.View.extend({
		initialize: function() {
			this.model = null;
		},

		events: {
			'change input': 'vote'
		},

		vote: function(e) {
			var self = this;
			var optionId = $(e.currentTarget).attr('id');

			if (this.model) {
				this.model.destroy();
			}

			this.model = new Vote();
			this.model.save({ optionId:  optionId });
		}

	});

	return PollView;
});