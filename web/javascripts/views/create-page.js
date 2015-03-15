
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
        var target = $(e.currentTarget);
        var placeholder = this.getNextOptionInputPlaceholder(target);
        var newOptionInput = $('.last-option').clone().val('').attr('placeholder', placeholder);
        target.after(newOptionInput);
        target.removeClass('last-option');
      },

      getNextOptionInputPlaceholder: function(currentOption) {
        var currentOptionNumber = currentOption.attr('placeholder').substring(currentOption.attr('placeholder').length - 1);
        return 'Option ' + (parseInt(currentOptionNumber) + 1);
      }

  });

  return createPageView;
});