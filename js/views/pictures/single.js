//Filename: boilerplate.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var pictureSingleView = Backbone.View.extend({
    template: _.template($('#picturessingletemplate').html()),
    initialize: function() {
        this.model = this.options.model;
    },
    render: function() {
		var tags = Common.implodeTags(this.model, ', ');
        $(this.el).html(this.template({model: this.model.toJSON(), tags: tags}));
        return this;
    },
    events: {
        'click .actionScroll': 'doScroll'
    },
    
    doScroll: function() {
        vent.trigger('scrollTo', { 
            lat: this.model.get('latitude'),
            lng: this.model.get('longitude')
        });
    }
});
