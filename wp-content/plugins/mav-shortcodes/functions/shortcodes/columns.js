mavShortcodeMeta = {
	attributes : [{
		label : "Title",
		id : "title",
		// isRequired : true,
		help : "Enter the column title."
	},{
		label : "Type",
		id : "type",
		type :
		{
			quarter				: "A quarter width",
			quarter_last		: "A quarter width (last)",
			three_quarters		: "Three quarters width",
			three_quarters_last	: "Three quarters width (last)",
			half				: "Half width",
			half_last			: "Half width (last)",
			full				: "Full width",
		},
		controlType : "select-control",
		help : "Select column width."
	},/*{
		label : "Color",
		id : "color",
		color :
		{
			blue	: "Blue Color Scheme",
			red	: "Red Color Scheme",
			green	: "Green Color Scheme"
		},
		controlType : "select-control",
		help : "Color scheme for the column."
	},*/{
		label : "Content",
		id : "content",
		controlType : "textarea-control",
		isRequired : true
	}],
	defaultContent : "Columns Content",
	clonableContent : true,
	disablePreview : true,
	shortcode : "mav_columns"
};

// Remember that you cannot use "-" in variables`s names! (so we use "_" or capitalised notation -> capitalisedNotationForVariable)
