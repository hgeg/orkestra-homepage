mavShortcodeMeta = {
	attributes : [{
		label : "Title",
		id : "title",
		help : "Enter the toggle title.",
		isRequired : true
	},{
		label : "Content",
		id : "content",
		controlType : "textarea-control",
		help : "Enter the toggle content.",
		isRequired : true
	},{
		label : "State",
		id : "state",
		state :
		{
			open	: "open",
			closed	: "closed"
		},
		controlType : "select-control",
		help : "Select the default toggle state."
	}],
	defaultContent : "Toggle Content",
	disablePreview : true,
	shortcode : "mav_toggle"
};
