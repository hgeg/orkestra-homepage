
mavShortcodeMeta = {
	attributes : [{
		label : "Title",
		id : "content",
		help : "Enter the button title.",
		isRequired : true
	},{
		label : "Color",
		id : "color",
		color :
		{
			blue	: "blue",
			light_blue	: "light blue",
			green	: "green",
			red		: 	"red",
			orange	: "orange",
			yellow	: "yellow",
			pink	: "pink",
			purple	: "purple",
			white	: "white",
			black	: "black"
		},
		controlType : "select-control",
		help : "Select the button color."
	},{
		label : "Size",
		id : "size",
		size :
		{
			small	: "small",
			medium	: "medium",
			large	: "large"
		},
		controlType : "select-control",
		help : "Select the button size."
	},{
		label : "Type",
		id : "type",
		type :
		{
			square	: "square",
			rounded	: "rounded"
		},
		controlType : "select-control",
		help : "Select the button type."
	},{
		label : "Link",
		id : "link",
		help : "Add the button link URL (e.g. http://google.com).",
		isRequired : true,
		validateLink : true
	},{
		label : "Target",
		id : "target",
		target :
		{
			_self	: "_self",
			_blank	: "_blank"
		},
		controlType : "select-control",
		help : "_self = open in same window. _blank = open in new window"
	}],
	defaultContent : "Button Text",
	//disablePreview : true,
	shortcode : "mav_button"
};
