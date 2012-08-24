//Filename: find
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */


var findView = Backbone.View.extend({
	template: _.template($('#picturesfindtemplate').html()),
	initialize: function() {
	
		var userCol = new userCollection();
		var tagCol = new generalTagCollection();
		userCol.fetch({
			success: function() {
				
			},
			error: function() {
				console.log(arguments);
			}
		});
		tagCol.fetch({
			success: function() {
			
			},
			error: function() {
				console.log(arguments);
			}
		});
		
		this.userListView = new userListView({ collection: userCol });
		this.tagListView = new tagListView({collection: tagCol });
	},
	render: function() {
		$(this.el).html(this.template());
		$(this.el).find('#findUsersContainer').html(this.userListView.render().el);
		$(this.el).find('#findTagsContainer').html(this.tagListView.render().el);
	},
	close: function() {
		$(this.el).undelegate();
	}
});