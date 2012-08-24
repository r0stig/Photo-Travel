//Filename: collections/user
/**
 *
 *
 * @author Robert S�ll <pr_125@hotmail.com>
 */

var userCollection = Backbone.Collection.extend({
    model: userModel,
    url: function() {
        return BASE_API_URL + 'users/';
    }
});