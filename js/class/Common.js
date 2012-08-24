function Common() {
}

Common.implodeTags = function(model, delim) {
	if ( typeof(delim) === 'undefined') {
		delim = ',';
	}
	var tags = '';
	var coltags = model.get('tags');
	if (coltags) {
		coltags.each(function(tag) {
			tags += tag.get('name') + delim;
		});
		// remove trailing ,
		tags = tags.substr(0, tags.length - delim.length);
	}
	return tags;
}

