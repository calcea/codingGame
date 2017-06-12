window.App = {
  Models: {},
  Collections: {},
  Views: {},
  Routers: {},
  init: function() {
    Backbone.history.start();
  }
};

$(document).ready(function(){
  App.init();
});
