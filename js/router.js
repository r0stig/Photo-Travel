// Filename: router.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */
var AppRouter = Backbone.Router.extend({
	initialize: function() {
	
		this.currentView = undefined;
	},
	routes: {
		// Define some URL routes
		'management': 'showManagement',
		'management/edit/:id': 'managementEditPicture',
		'map/user/:id': 'mapUserPictures',
		'map/tag/:tag': 'mapTagPictures',

		// Default
		'*actions': 'defaultAction'
	},
	showManagement: function() {
		var p = new pictureMgmtView({ el: $('#container') });
		this.beforeSwap(p);
		p.render();
	},
	managementEditPicture: function(id) {
		var p = new pictureMgmtEditView({ el: $('#container'), picture_id: id });
		this.beforeSwap(p);
		p.render();
	},
	mapUserPictures: function(id) {
		var v = new pictureMapView({ el: $('#container') , user_id: id});
		this.beforeSwap(v);
		v.render();
	},
	mapTagPictures: function(tag) {
		var v = new pictureMapView({ el: $('#container') , tag: tag});
		this.beforeSwap(v);
		v.render();
	},
	defaultAction: function(actions){
		// We have no matching route, lets just log what the URL was
		console.log('No route:', actions);
		//var v = new pictureMapView({ el: $('#container') });
		//v.render();
		var v = new findView({ el: $('#container') });
		this.beforeSwap(v);
		v.render();
	},
	
	beforeSwap: function(view) {
		if (this.currentView != undefined ) {
			this.currentView.close();
		}
		this.currentView = view;
	},
	afterSwap: function(view) {
		
	}
});