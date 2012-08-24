//Filename: boilerplate.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var pictureModel = Backbone.Model.extend({
    url: function() {
        if(this.isNew()) {
            return BASE_API_URL + 'picture/';
        } else {
            return BASE_API_URL + 'picture/' + this.id;
        }
    },
	parse: function(response) {
		if (response != null) {
			response.tags = new tagCollection(response.tags);
		}
		return response;
	}

});