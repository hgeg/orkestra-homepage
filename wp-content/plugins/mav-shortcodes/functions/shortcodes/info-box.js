
mavShortcodeMeta = {
	attributes : [{
		label : "Content",
		id : "content",
		controlType : "textarea-control",
		help : "Enter the box content.",
		isRequired : true
	},{
		label : "Type",
		id : "type",
		type :
		{
			info	: "info",
			success	: "success",
			note	: "note",
			warning	: "warning",
			danger	: "danger"
		},
		controlType : "select-control",
		help : "Select the box type."
	}/*,{
		label : "Icon",
		id : "icon",
		icon :
		{
			yes	: "yes",
			no	: "no"
		},
		controlType : "select-control",
		help : ""
	}*/],
	defaultContent : "Hello, I'm an Info Box.",
	shortcode : "mav_box"
};
