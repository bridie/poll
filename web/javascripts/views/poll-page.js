define([
  'jquery',
  'underscore',
  'backbone',
  'jqueryCookie',
  'models/vote'
], function($, _, Backbone, jqueryCookie, Vote){
  var PollView = Backbone.View.extend({
		initialize: function() {
			if ($.cookie('vote-id')) {
				this.model = new Vote({ id: $.cookie('vote-id')});
				this.model.fetch({
					success: function(model, response) {
						$('#' + model.get('optionId')).prop('checked', true);
					}
				})
			} else {
				this.model = null;
			}
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
			this.model.save({ optionId: optionId }, {
				success: function() {
					$.cookie('vote-id', self.model.get('id'));
				}
			});
		}

	});

	return PollView;
});