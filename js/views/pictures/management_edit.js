//Filename: pictures/management_edit
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var pictureMgmtEditView = Backbone.View.extend({
    template: _.template($('#picturesmanagement_edittemplate').html()),
    initialize: function() {
		var self = this;
		this.model = new pictureModel();
		this.model.id = this.options.picture_id;
		this.model.fetch({
			success: function(m, r) {
				console.log(m, r);
				self.render();
			},
			error: function() {
				console.log('error', arguments);
			}
		});
        //this.model = this.options.model;
    },
    render: function() {
		// TO-DO: Add a state variable that renders a loading screen if the model isn't fetched
		// Or handle this in the view?
		
		var tags = Common.implodeTags(this.model);
		
        $(this.el).html(this.template({model: this.model.toJSON(), tags: tags}));
		$(this.el).find('input[name=tags]').tagit();
        return this;
    },
    events: {
        'click input[name=managementEditButton]': 'doEdit',
		'click input[name=managementCancelButton]': 'doCancel'
    },
    
    doEdit: function() {
		this.model.save({
			'description': $(this.el).find('textarea[name=description]').val(),
			'tags': $(this.el).find('input[name=tags]').val()
		},{
			success: function(m, r) {
				console.log('success edit', m, r);
				window.router.navigate("management", true);
			},
			error: function() {
				console.log('error', arguments);
			}
		});
    },
	
	doCancel: function() {
		window.router.navigate("management", true);
	},
	close: function() {
		this.undelegateEvents();
		//console.log('unbinding
		//$(this.el).undelegate();
	}
});
