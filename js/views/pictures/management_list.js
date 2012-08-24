//Filename: boilerplate.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
var pictureMgmtListView = Backbone.View.extend({
    template: _.template($('#picturesmanagement_listtemplate').html()),
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
        var v = new pictureMgmtSingleView({ model: model });
        $(this.el).find('#picMgmtListContainer').append(v.render().el);
    },
    
    onReset: function() {  
        console.log('onReset');
        this.render();
    }
});