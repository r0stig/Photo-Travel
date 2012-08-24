// Filename: app.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

$(function() {
    vent = _.extend({}, Backbone.Events);
    window.router = new AppRouter();
    Backbone.history.start();
});