
var mavDialogHelper = {
	needsPreview : false,
	setUpButtons : function() {

		var a = this;

		jQuery("#mav-btn-cancel").live('click',function() {
			//a.closeDialog();
		});

		jQuery("#mav-btn-insert").live('click',function() {
			a.insertAction();
		});

		jQuery("#mav-btn-preview").live('click',function() {
			a.previewAction();
		})
	},

	loadShortcodeDetails : function() {

		if(mavSelectedShortcodeType) {
			var a = this;
			jQuery.getScript("../wp-content/plugins/mav-shortcodes/functions/shortcodes/"+mavSelectedShortcodeType+".js",
			function(){
				a.initializeDialog()
			})
		}
	},

	initializeDialog : function() {

		if(typeof mavShortcodeMeta == "undefined") {

			jQuery("#mav-options").append("<p>Error loading details for shortcode: "+mavSelectedShortcodeType+"</p>");

		} else {

			var a = mavShortcodeMeta.attributes,
			b = jQuery("#mav-options-table");

			if (mavShortcodeMeta.clonableContent) {

				if ( mavShortcodeMeta.hasGroup/*mavSelectedShortcodeType != 'columns'*/ )

				jQuery('#mav-options-table').before( '<div id="mav-cloned-group"><label for="mav-cloned-group-name"><span class="mav-group-name-text">Insert the ' + mavSelectedShortcodeType + ' Group Name (<i><small>eg: "my' + mavSelectedShortcodeType + '" or "my ' + mavSelectedShortcodeType + '"</small><i>)</span></label><input id="mav-cloned-group-name" name="mav-cloned-group" class="required" type="text"></div>' );

			}

			for (var c in a) {

				var f = "mav-value-"+a[c].id,
				d = a[c].isRequired?"required":"",
				g = jQuery('<th valign="top" scope="row"></th>');
				jQuery("<label/>").attr("for",f).attr("class",d).html(a[c].label).appendTo(g);
				f = jQuery("<td/>");
				d = (d = a[c].controlType)?d:"text-control";

				switch(d) {

					case "select-control":
						this.createSelectControl(a[c], f , c == 0);
						break;

					case "text-control":
						this.createTextControl(a[c], f , c == 0);
						break;

					case "textarea-control":
						this.createTextareaControl(a[c], f , c == 0);
						break;

				} // END switch(d)

				jQuery("<tr/>").append(g).append(f).appendTo(b)

			}

			if (mavShortcodeMeta.clonableContent) {

				jQuery('#mav-options-table tbody').attr({ 'class': 'mav-options-cloned', 'id': 'mav-options-cloned-1' });

			}

			if(mavShortcodeMeta.disablePreview) {
				jQuery("#mav-preview").remove();
				jQuery("#mav-btn-preview").remove();
				jQuery("#mav-dialog").dialog("option", "position", "center");
				jQuery("#mav-options").css("margin-right", 0);
			}

			jQuery(".mav-focus-here:first").focus()

		}
	},

	createTextControl : function(a,b,c) {
		var f = a.validateLink?"mav-validation-marker":"",
		d = a.isRequired?"required":"",
		u = a.validateLink?"url":"",
		g = "mav-value-"+a.id;

		if (mavShortcodeMeta.clonableContent) {
			jQuery('<input type="text">').attr("id",g+"-1").attr("name",g+"-1").addClass(u).addClass(f).addClass(d).addClass(c?"mav-focus-here":"").appendTo(b);
		} else {
			jQuery('<input type="text">').attr("id",g).attr("name",g).addClass(u).addClass(f).addClass(d).addClass(c?"mav-focus-here":"").appendTo(b);
		}

		// Add help if there is any
		this.addHelpSpan(a, b, g);

		var h = this;

		b.find("#"+g).bind("keydown focusout", function(e) {
			if (e.type == "keydown" && e.which!=13 && e.which!=9&&!e.shiftKey)h.needsPreview = true;

			else if (h.needsPreview&&(e.type == "focusout" || e.which == 13)) {
				h.previewAction(e.target);
				h.needsPreview = false
			}
		})
	},

	createTextareaControl : function(a,b,c) {
		var f = a.validateLink?"mav-validation-marker":"",
		d = a.isRequired?"required":"",
		g = "mav-value-"+a.id;

		if (mavShortcodeMeta.clonableContent) {
			jQuery('<textarea>').attr("id",g+"-1").attr("name",g+"-1").addClass(f).addClass(d).addClass(c?"mav-focus-here":"").appendTo(b);
		} else {
			jQuery('<textarea>').attr("id",g).attr("name",g).addClass(f).addClass(d).addClass(c?"mav-focus-here":"").appendTo(b);
		}

		// Add help if there is any
		this.addHelpSpan(a, b, g);

		var h = this;

		b.find("#"+g).bind("keydown focusout", function(e) {
			if (e.type == "keydown" && e.which!=13 && e.which!=9&&!e.shiftKey)h.needsPreview = true;

			else if (h.needsPreview&&(e.type == "focusout" || e.which == 13)) {
				h.previewAction(e.target);
				h.needsPreview = false
			}
		})
	},

	createSelectControl : function(a,b,c) {
		var f = a.validateLink?"mav-validation-marker":"",
		d = a.isRequired?"required":"",
		g = "mav-value-"+a.id;
		// Get select id and use it to extract the options for our select box
		n = a.id;
		// Options array
		o = a[n];

		var s = $('<select />');

		if (mavShortcodeMeta.clonableContent) {

			jQuery(s).attr("id",g+"-1").attr("name",g+"-1").addClass(f).addClass(d).addClass(c?"mav-focus-here":"").addClass("mav-marker-select-control").appendTo(b);

			for(var val in o) {
				jQuery('<option />', {value: val, text: o[val]}).attr("id",g+"-"+val+"-1").appendTo(s);
			}

		} else {

			jQuery(s).attr("id",g).attr("name",g).addClass(f).addClass(d).addClass(c?"mav-focus-here":"").addClass("mav-marker-select-control").appendTo(b);

			for(var val in o) {
				jQuery('<option />', {value: val, text: o[val]}).appendTo(s);
			}
		}

		// Add help if there is any
		this.addHelpSpan(a, b, g);

		var h = this;

		b.find("#"+g).bind("keydown focusout", function(e) {
			if (e.type == "keydown" && e.which!=13 && e.which!=9&&!e.shiftKey)h.needsPreview = true;

			else if (h.needsPreview&&(e.type == "focusout" || e.which == 13)) {
				h.previewAction(e.target);
				h.needsPreview = false
			}
		})
	},

	getTextKeyValue : function(a) {
		var b = a.find("input");
		if(!b.length)
		var b = a.find("textarea");
		if(!b.length)return null;

		if (mavShortcodeMeta.clonableContent) {
			a = b.attr("id").substring(10);
			a = a.slice(0, a.lastIndexOf("-"));
		} else {
			a = b.attr("id").substring(10);
		}

		b = b.val();
		return {
			key : a,
			value : b
		}

	},

	getSelectKeyValue : function(a) {
		var b = a.find("select option:selected");
		// In the Select type we need to take the parent name (not the value like in textarea/ input field), and it`s lenght
		var p = b.parent().attr("id").split("-");
		var l = p.length;

		if (mavShortcodeMeta.clonableContent) {
			a = p[l - 2]; // Get the select type from the id of dropdown. For cloned selects is the second word from the end, the last one is the number of the cloned select
		} else {
			a = p[l - 1]; // Get the select type from the id of dropdown. Is the last word in the id
		}

		b = b.val();
		return {
			key : a,
			value : b
		}
	},

	closeDialog : function() {
		this.needsPreview = false;
		tb_remove();
		jQuery("#mav-dialog").remove()
	},

	makeShortcode : function() {
		var a = {},
		b = this;

		if (mavShortcodeMeta.clonableContent) {

			var cloned = '';

			var le = jQuery( "#mav-options-table" ).find( ".mav-options-cloned" ).length;

			jQuery(".mav-options-cloned").each(function() {

				jQuery(this).find('td').each(function() {
					var h = jQuery(this);

					e = null;
					// Get first child of the <td/> to loop trough it`s classes
					n = h.context.children[0].classList;

					// Use the <td/>`s first element (it could`ve been input, select or other form element ...) to check what kind of control we will use
					if ( jQuery.inArray( "mav-marker-column-control", n ) == 0 ) {
						e = b.getColumnKeyValue(h);
						if ( e == false )

						a[e.key] = e.value;
					} else if ( jQuery.inArray( "mav-marker-select-control", n ) == 0 ) {
						e = b.getSelectKeyValue(h);
						a[e.key] = e.value;
					} else {
						e = b.getTextKeyValue(h);
						a[e.key] = e.value;
					}
				});

				var c = a.content?a.content:mavShortcodeMeta.defaultContent,f="";

				for (var d in a) {
					var g = a[d];
					if(g&&d!="content")f+=" "+d+'="'+g+'"'
				}

				// We take the ID from the HTML element ID (is the last group, given that the ID is split by "-" into substrings)
				var i = $(this).attr('id');
				i = i.split(/[- ]+/).pop();

				if ( mavShortcodeMeta.hasGroup ) {

					if ( i == le ) {
						f += " " + "id=" + i + " " + 'group="' + jQuery( "#mav-cloned-group-name" ).val().replace(/\s+/g, '-').toLowerCase() + '" last="last"';
					} else {
						f += " " + "id=" + i + " " + 'group="' + jQuery( "#mav-cloned-group-name" ).val().replace(/\s+/g, '-').toLowerCase() + '"';
					}

					cloned += "["+mavShortcodeMeta.shortcode+f+"]"+(c?c+"[/"+mavShortcodeMeta.shortcode+"] ":" ");

				} else {

					if ( i == le ) {
						f += " " + "id=" + i + '" last="last"';
					} else {
						f += " " + "id=" + i + '"';
					}

					cloned += "["+mavShortcodeMeta.shortcode+f+"]"+(c?c+"[/"+mavShortcodeMeta.shortcode+"] ":" ");

				}

			});

			if ( mavShortcodeMeta.hasGroup ) {

				cloned = "[mav_" + mavSelectedShortcodeType + "_all group=\"" + jQuery( "#mav-cloned-group-name" ).val().replace(/\s+/g, '-').toLowerCase() + "\" ids=\"" + le + "\"][/mav_" + mavSelectedShortcodeType + "_all]" + cloned;

			}

			return cloned;

		} else {

			jQuery("#mav-options-table td").each(function() {
				var h = jQuery(this);
				e = null;
				// Get first child of the <td/> to loop trough it`s classes
				n = h.context.children[0].classList;

				// Use the <td/>`s first element (it could`ve been input, select or other form element ...) to check what kind of control we will use
				if ( jQuery.inArray( "mav-marker-column-control", n ) == 0 ) {
					e = b.getColumnKeyValue(h);
					a[e.key] = e.value;
				} else if ( jQuery.inArray( "mav-marker-select-control", n ) == 0 ) {
					e = b.getSelectKeyValue(h);
					a[e.key] = e.value;
				} else {
					e = b.getTextKeyValue(h);
					a[e.key] = e.value;
				}
			});

			if (mavShortcodeMeta.customMakeShortcode)
				return mavShortcodeMeta.customMakeShortcode(a);

			var c = a.content?a.content:mavShortcodeMeta.defaultContent,f="";

			for (var d in a) {
				var g = a[d];
				if(g&&d!="content")f+=" "+d+'="'+g+'"';
			}

			return "["+mavShortcodeMeta.shortcode+f+"]"+(c?c+"[/"+mavShortcodeMeta.shortcode+"] ":" ");

		}

	},

	insertAction : function() {
		if(typeof mavShortcodeMeta!="undefined") {
			var a = this.makeShortcode();

			if (mavShortcodeMeta.clonableContent) {
				vi = jQuery('#mav-option-form').find('input').valid();
				vt = jQuery('#mav-option-form').find('textarea').valid();
				if ( vi == false || vt == false )
					return false
			} else {
				//v = jQuery('#mav-option-form').valid();
				//console.log(v);
				if ( ! jQuery('#mav-option-form').valid() )
					return false
			}

			tinyMCE.activeEditor.execCommand("mceInsertContent",false,a);
			this.closeDialog();
		}
	},

	previewAction : function(a) {
		jQuery(a).hasClass("mav-validation-marker")&&this.validateLinkFor(a);
		jQuery("#mav-preview h3:first").addClass("mav-loading");
		jQuery("#mav-preview-iframe").attr("src","../wp-content/plugins/mav-shortcodes/tinymce/shortcode-preview.php?shortcode="+encodeURIComponent(this.makeShortcode()))
	},

	addHelpSpan : function (a, b, g) {

		if (a = a.help) {

			if (mavShortcodeMeta.clonableContent) {
				jQuery("<br/>").appendTo(b);
				jQuery("<span/>").attr("id",g+"-help-1").addClass("mav-input-help").html(a).appendTo(b);
			} else {
				jQuery("<br/>").appendTo(b);
				jQuery("<span/>").attr("id",g).addClass("mav-input-help").html(a).appendTo(b);
			}
		}
	},

	validateLinkFor : function(a) {
		var b = jQuery(a);
		b.removeClass("mav-validation-error");
		b.removeClass("mav-validated");

		if(a = b.val()) {
			b.addClass("mav-validating");
			jQuery.ajax({
				url : ajaxurl,
				dataType : "json",
				data : {
					action : "mav_check_url_action",
					url : a
				},

				error : function() {
					b.removeClass("mav-validating")
				},

				success : function(c) {
					b.removeClass("mav-validating");
					c.error||b.addClass(c.exists?"mav-validated":"mav-validation-error")
				}
			})
		}
	}

};

mavDialogHelper.setUpButtons();
mavDialogHelper.loadShortcodeDetails();

