//Filename: pictures/management_single
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var pictureMgmtSingleView = Backbone.View.extend({
    template: _.template($('#picturesmanagement_singletemplate').html()),
    initialize: function() {
        this.model = this.options.model;
		
		this.model.on('change', this.render, this);
    },
    render: function() {
	
		var tags = Common.implodeTags(this.model, ', ');
		
        $(this.el).html(this.template({model: this.model.toJSON(), tags: tags }));
        return this;
    },
	events: {
		'click button[name=mgmtEditBtn]': 'doEdit',
		'click button[name=mgmtDeleteBtn]': 'doDelete'
	},
	doEdit: function() {
		window.router.navigate('management/edit/' + this.model.id, true);
		//vent.trigger('mgmtEdit', this.model);
	},
	doDelete: function() {
		var self = this;
		this.model.destroy({
			error: function() {
				console.log(arguments);
			},
			success: function() {
				self.remove();
			}
		});
	}
});
