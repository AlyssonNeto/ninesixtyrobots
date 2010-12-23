// $Id: javascript.js,v 1.1.4.2 2009/08/12 23:29:56 add1sun Exp $

// Prefill the search box with Search... text.
(function ($) {

Drupal.behaviors.ninesixtyrobots = {
  attach: function (context) {
    $('#search-block-form input:text', context).autofill({
      value: "Search ..."
    });
  }
};

})(jQuery);
