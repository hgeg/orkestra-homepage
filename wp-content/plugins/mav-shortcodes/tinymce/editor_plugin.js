(function(){

	$ = jQuery;

	// Create the plugin
	tinymce.create("tinymce.plugins.MavShortcodes", {

		// Initializes the plugin
		init : function(d,e) {

			d.addCommand( "mavOpenDialog", function(a,c) {

				mavSelectedShortcodeType = c.identifier;

				$.get( e + "/dialog.php", function(b) {

					$("#mav-dialog").remove();
					$("body").append( b );
					$("#mav-dialog").hide();

					$(function() {

						$( "#mav-dialog" ).dialog({
							//autoOpen: false,
							height: "auto",
							width: "auto",
							resizable: false,
							draggable: false,
							modal: true,
							buttons: [{
								id:"mav-btn-remove",
								text: "Remove",
								click: function() {
									// how many "duplicatable" blocks we currently have
									var num = $( '.mav-options-cloned' ).length;

									// the numeric ID of the new input field being added
									if ( num > 1 )
										$( '#mav-options-cloned-' + num ).remove();
										if ( num == 2 )
											$('#mav-btn-remove').button('disable');

									// Recenter the dialog window
									var winHeight = $(window).height() - 160;
									$("#mav-dialog").css( { 'max-height' : winHeight + 'px' } );
									$("#mav-dialog").dialog("option", "position", "center");
								}
							},{
								id:"mav-btn-add-new",
								text: "Add new",
								click: function() {
									// how many "duplicatable" blocks we currently have
									var num = $( '.mav-options-cloned' ).length;
									// the numeric ID of the new input field being added
									var newNum	= new Number( num + 1 );

									// We take the last "cloned" element to make our new one and change it`s ID
									var newElem = $( '#mav-options-cloned-' + num ).clone().attr( 'id', 'mav-options-cloned-' + newNum );

									// Array of formfields found in our table (we don`t know how many elements are there, this beeing dependent of our shortcode type)
									var formElem = newElem.find('td');

									$.each( formElem.find("*"), function(key, value) {
										var id = $(this).attr('id');

										// Check if is <br/> <- it doesn`t make sense to give it an id :)
										if ( $(this).get(0).tagName == "BR" )
											return;  // the jQuery javascript`s "continue"

										// If is an Error Label, don`t clone it!
										if ( $(this).get(0).tagName == "LABEL" ) {
											if ( $(this).hasClass('error') ) {
												$(this).remove();
												return
											}
										}

										// Remove the number of the formfield ID to replace it with the new one
										id = id.replace(id.split(/[- ]+/).pop(), '');
										$(this).attr( 'id', id + newNum );

											// Empty content if is input/ textarea
											if ( $(this).get(0).tagName == "INPUT" || $(this).get(0).tagName == "TEXTAREA" )
												$(this).val('');
									});

									$( newElem ).appendTo( '#mav-options-table' );

									$('#mav-btn-remove').button('enable');

									// Recenter the dialog window
									var winHeight = $(window).height() - 160;
									$("#mav-dialog").css( { 'max-height' : winHeight + 'px' } );
									$("#mav-dialog").dialog("option", "position", "center");
								}
							},{
								id:"mav-btn-insert",
								text: "Insert",
								click: function() {
									// The behaviour of this button is defined in dialog.js, based on ID
								}
							},{
								id:"mav-btn-preview",
								text: "Preview",
								click: function() {
									// The behaviour of this button is defined in dialog.js, based on ID
								}
							},{
								id:"mav-btn-cancel",
								text: "Cancel",
								click: function() {
									$(this).dialog("close");
								}
							}]
						});

						$( "#mav-dialog" ).dialog( "open" );

						// Initial state of the Remove Button
						$('#mav-btn-remove').button('disable');

					});

					if ( c.title == "Tabs" ) {
						$( "#mav-btn-add-new span" ).text( "Add new Tab" );
						$( "#mav-btn-remove span" ).text( "Remove Tab" );
					} else if (c.title == "Accordion" ) {
						$( "#mav-btn-add-new span" ).text( "Add new Accordion" );
						$( "#mav-btn-remove span" ).text( "Remove Accordion" );
					} else if (c.title == "Columns" ) {
						$( "#mav-btn-add-new span" ).text( "Add new Column" );
						$( "#mav-btn-remove span" ).text( "Remove Column" );
					} else {
						$( "#mav-btn-add-new" ).remove();
						$( "#mav-btn-remove" ).remove();
					}

					$( "#mav-options h3:first" ).text( "Customize the " + c.title + " Shortcode" );

				})
			});

			d.onNodeChange.add(function(a,c) {
				c.setDisabled("mav_button",a.selection.getContent().length>0)})
			},

			createControl : function(d,e) {

				if( d == "mav_button" ) {
					d = e.createSplitButton("mav_button", {
					// d = e.createMenuButton("mav_button", {
						title : "Insert Shortcode",
						image : "../wp-content/plugins/mav-shortcodes/tinymce/img/mav-icon.png",
						icons : false
					});

					var a = this;

					d.onRenderMenu.add(function(c,b) {
						a.addWithDialog( b, "Button", "button" );
						a.addWithDialog( b, "Info Box", "info-box" );
						a.addWithDialog( b, "Text Highlight", "highlight" );
						a.addWithDialog( b, "Tabs", "tabs" );
						a.addWithDialog( b, "Toggle", "toggle" );
						a.addWithDialog( b, "Accordion", "accordion" );
						a.addWithDialog( b, "Columns", "columns" );
						// b.addSeparator();
						/*c = b.addMenu({ title : "Dividers" });
						a.addImmediate( c, "Horizontal Rule", "[hr]" );
						a.addImmediate( c, "Divider", "[divider]" );
						a.addImmediate( c, "Flat Divider", "[divider_flat]" );*/
					});

					return d;
				}

				return null;
			},

			addImmediate : function(d,e,a) {
				d.add({ title:e, onclick:function(){
					tinyMCE.activeEditor.execCommand("mceInsertContent", false , a )}})
				},

				addWithDialog : function(d,e,a) {
					d.add({ title:e, onclick:function(){
						tinyMCE.activeEditor.execCommand("mavOpenDialog", false, {
							title : e,
							identifier:a
						})
					}
				});
			},

			getInfo : function() {
				return {
					longname: "Mav Shortcodes Plugin",
					author: "Mattia Viviani",
					authorurl: "http://mattiaviviani.com",
					infourl: "http://mattiaviviani.com/plugins/mav-shortcodes/",
					version : "1.0"
				};
			}
		});

		// Register plugin
		tinymce.PluginManager.add( "MavShortcodes", tinymce.plugins.MavShortcodes );
})();
