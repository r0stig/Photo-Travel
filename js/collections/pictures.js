//Filename: collections/pictures
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var pictureCollection = Backbone.Collection.extend({
    model: pictureModel,
    url: function() {
        return BASE_API_URL + 'pictures/user/' + this.get('picturesByUser');
    },
	fetchByUser: function(user_id, options) {
		this.url = BASE_API_URL + 'pictures/user/' + user_id;
		return this.fetch(options);
	},
	fetchByTags: function(tags, options) {
		this.url = BASE_API_URL + 'pictures/tags/' + tags;
		return this.fetch(options);
	}
});