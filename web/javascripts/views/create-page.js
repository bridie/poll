
define([
  'jquery',
  'underscore',
  'backbone'
], function($, _, Backbone){
  var createPageView = Backbone.View.extend({
      events: {
        'keyup .last-option': 'addOptionInput',
        'keyup input': 'checkSubmitAvailability',
        'focusout .option-input': 'manageOptionInputs'
      },

      addOptionInput: function(e) {
        var target = $(e.currentTarget);
        var placeholder = this.getNextOptionInputPlaceholder(target);
        var newOptionInput = $('.last-option').clone().val('').attr('placeholder', placeholder);
        target.after(newOptionInput);
        target.removeClass('last-option');
      },

      checkSubmitAvailability: function() {
        var questionExists = $('.question-input').val() != '';
        var optionsExist = 0;
        $('.option-input').each(function() {
          if ($(this).val() != '') {
            optionsExist++;
          }
        });

        if (questionExists && optionsExist >= 2) {
          $('button').css('background', '#E45857').attr('disabled', false);
        } else {
          $('button').css('background', '#7B7B7B').attr('disabled', true);
        }
      },

      getNextOptionInputPlaceholder: function(currentOption) {
        var currentOptionNumber = currentOption.attr('placeholder').substring(currentOption.attr('placeholder').length - 1);
        return 'Option ' + (parseInt(currentOptionNumber) + 1);
      },

      manageOptionInputs: function() {
        var self = this;
        $('.option-input').not('.last-option').each(function() {
          if ($(this).val() == '') {
            $(this).remove();

            self.resetOptionInputPlaceholderText();
          }
        });
      },

      resetOptionInputPlaceholderText: function() {
        var i = 1;
        $('.option-input').each(function() {
          $(this).attr('placeholder', 'Option ' + i);
          i++;
        });
      }

  });

  return createPageView;
});