//Filename: tags/pictures
/**
 *
 *
 * @author Robert S�ll <pr_125@hotmail.com>
 */

var generalTagCollection = Backbone.Collection.extend({
    model: generalTagModel,
	url: function() {
		return BASE_API_URL + 'tags';
	}
});