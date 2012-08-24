//Filename: pictures/tag_list
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
 
var tagListView = Backbone.View.extend({
    template: _.template($('#picturestag_listtemplate').html()),
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
        var v = new tagSingleView({ model: model });
        $(this.el).find('#findTagList tbody').append(v.render().el);
    },
	onReset: function() {
		console.log('onReset');
		this.render();
	}

});