//Filename: boilerplate.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var userPicturesCollection = Backbone.Collection.extend({
    model: pictureModel,
    url: function() {
        return BASE_API_URL + 'pictures/user/' + this.get('picturesByUser');
    }
});