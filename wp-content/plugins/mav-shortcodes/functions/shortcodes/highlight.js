mavShortcodeMeta = {
	attributes : [{
		label : "Content",
		id : "content",
		controlType : "textarea-control",
		help : "Enter the content you wish to be highlighted.",
		isRequired : true
	},{
		label : "Color",
		id : "color",
		color :
		{
			blue	: "blue",
			green	: "green",
			red		: "red",
			orange	: "orange",
			yellow	: "yellow",
			pink	: "pink",
			purple	: "purple"
		},
		controlType : "select-control",
		help : "Select the highlight color."
	}],
	defaultContent : "Text Highlight",
	shortcode : "mav_highlight"
};
