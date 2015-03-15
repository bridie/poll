
define([
  'jquery',
  'underscore',
  'backbone'
], function($, _, Backbone){
  var createPageView = Backbone.View.extend({
      events: {
        'keyup .last-option': 'addOptionInput'
      },

      addOptionInput: function(e) {
        var optionInputClone = $('.last-option').clone().val('');
        $(e.currentTarget).after(optionInputClone);
        $(e.currentTarget).removeClass('last-option');
      }
  });

  return createPageView;
});