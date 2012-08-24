//Filename: models/user
/**
 *
 *
 * @author Robert S�ll <pr_125@hotmail.com>
 */

var userModel = Backbone.Model.extend({
    url: function() {
        if(this.isNew()) {
            return BASE_API_URL + 'user/';
        } else {
            return BASE_API_URL + 'user/' + this.id;
        }
    }

});