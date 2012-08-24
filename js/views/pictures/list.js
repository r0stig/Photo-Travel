//Filename: boilerplate.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
var pictureListView = Backbone.View.extend({
    template: _.template($('#pictureslisttemplate').html()),
    initialize: function() {
        this.collection = this.options.collection;
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
        var v = new pictureSingleView({ model: model });
        $(this.el).find('#singlePictureContainer').append(v.render().el);
    }
});