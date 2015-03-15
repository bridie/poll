
define([
  'jquery',
  'underscore',
  'backbone'
], function($, _, Backbone){
  var createPageView = Backbone.View.extend({
      events: {
        'keyup .last-option': 'addOptionInput',
        'focusout .option-input': 'manageOptionInputs'
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
      },

      manageOptionInputs: function() {
        $('.option-input').not('.last-option').each(function() {
          if ($(this).val() == '') {
            $(this).remove();

            var i = 1;
            $('.option-input').each(function() {
              $(this).attr('placeholder', 'Option ' + i);
              i++;
            });
          }
        });
      }

  });

  return createPageView;
});