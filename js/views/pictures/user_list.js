//Filename: pictures/user_list
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
 
var userListView = Backbone.View.extend({
    template: _.template($('#picturesuser_listtemplate').html()),
    initialize: function() {
        this.collection = this.options.collection;
		this.collection.on('reset', this.onReset, this);
    },
    render: function() {
        var self = this;
        
        $(this.el).html(this.template());
        
        this.collection.each(function(m) {
            self.renderItem(m);
        });
        
        
        return this;
    },
    renderItem: function(model) {
        var v = new userSingleView({ model: model });
        $(this.el).find('#findUserList tbody').append(v.render().el);
    },
	onReset: function() {
		console.log('onReset');
		this.render();
	}

});