//Filename: boilerplate.js
/**
 *
 *
 * @author Robert Säll <pr_125@hotmail.com>
 */

var pictureMgmtView = Backbone.View.extend({
    template: _.template($('#picturespicture_managementtemplate').html()),
    initialize: function() {
        /*this.collection = new userPicturesCollection();
        this.collection.fetch({
            success: function() {
                console.log('success');
                //self.render();
            },
            error: function() {
                console.log(arguments);
            }
        });
		*/
		this.collection = new pictureCollection();
		this.collection.fetchByUser(USER_ID, {
            success: function() {
                console.log('success');
                //self.render();
            },
            error: function() {
                console.log(arguments);
            }
        });
        this.pictureMgmtListView = new pictureMgmtListView({ collection: this.collection });
		
		$(this.el).find('#mgmtEditContainer').hide();
		$(this.el).find('#mgmtMyPicContainer').show();
		
		vent.on('mgmtEdit', this.doEdit, this);
		vent.on('mgmtEditCancel', this.doEditCancel, this);
		vent.on('mgmtEditSuccess', this.doEditSuccess, this);
    },
    render: function() {
        $(this.el).html(this.template());
		$(this.el).find('input[name=tags]').tagit({
			
		});
        $(this.el).find('#picMgmtMyPictures').html(this.pictureMgmtListView.render().el);
        $("#pictureUpload").submit(function() {
            console.log($(":text", this).serializeArray());
            $.ajax(this.action, {
                data: {
                    'description': $('textarea[name=description]').val(),
                    'tags': $('input[name=tags]').val()
                },
                files: $(":file", this),
                iframe: true,
                processData: true
                })
            .complete(function(data) {
                    console.log(data);
            });
            return false;
        });
        return this;
    },
    events: {
        //'submit #pictureUpload': 'doUpload'
    },
    /**
     * http://cmlenz.github.com/jquery-iframe-transport/
     *
     */
    doUpload: function() {
        console.log(this);
        var obj = $('#pictureUpload');
        $.ajax(obj.action, {
            files: $(":file", obj),
            iframe: true
        }).complete(function(data) {
            console.log(data);
        });
        return false;
    },
	
	doEdit: function(model) {
		var mgmtEditView = new pictureMgmtEditView({ model: model });
		$(this.el).find('#mgmtEditContainer').html(mgmtEditView.render().el);
		$(this.el).find('#mgmtEditContainer').show();
		$(this.el).find('#mgmtMyPicContainer').hide();
	},
	
	doEditCancel: function() {
		$(this.el).find('#mgmtEditContainer').hide();
		$(this.el).find('#mgmtMyPicContainer').show();
	},
	doEditSuccess: function() {
		// TO-DO: Add message that says the picture edit was successful.
		$(this.el).find('#mgmtEditContainer').hide();
		$(this.el).find('#mgmtMyPicContainer').show();
	},
	close: function() {
		this.unbind();
		//$(this.el).undelegate();
	}
});