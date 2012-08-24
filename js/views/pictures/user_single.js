//Filename: pictures/user_single
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
 
var userSingleView = Backbone.View.extend({
    template: _.template($('#picturesuser_singletemplate').html()),
	tagName: 'tr',
    initialize: function() {
        this.model = this.options.model;
    },
    render: function() {
        $(this.el).html(this.template({model: this.model.toJSON()}));
        return this;
    }
});