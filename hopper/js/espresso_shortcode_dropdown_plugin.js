(function() {
	//******* Load plugin specific language pack
	//tinymce.PluginManager.requireLangPack('example');

	tinymce.create('tinymce.plugins.EspressoShortcodeSelector', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			if(n=='EspressoShortcodeSelector'){
                var mlb = cm.createListBox('EspressoShortcodeSelectorList', {
                     title : 'Shortcodes',
                     onselect : function(v) {
						switch(v){

							case 'es-map':
							case 'es-col':
								tinyMCE.activeEditor.selection.setContent('[' + v + ']' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
								break;
							case 'es-button':
								tinyMCE.activeEditor.selection.setContent('[' + v + ' link="#" size="medium" target=""]' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
								break;
							case 'es-box':
								tinyMCE.activeEditor.selection.setContent('[' + v + ' title=""]' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
								break;
							default:
								if(tinyMCE.activeEditor.selection.getContent() != ''){
									tinyMCE.activeEditor.selection.setContent('[' + v + ']' + tinyMCE.activeEditor.selection.getContent() + '[/' + v + ']');
		                        }
		                        else{
									tinyMCE.activeEditor.selection.setContent('[' + v + ']');
								}
								break;

						}

                     }
                });

				for (var i = 0; i < wp_shortcodes.length; i++) {
					mlb.add(wp_shortcodes[i], wp_shortcodes[i]);
				};

                // Return the new listbox instance
                return mlb;
             }
             
             return null;
		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Shortcode selector',
				author : 'marquex',
				authorurl : 'http://marquex.es',
				infourl : 'http://marquex.es/387/adding-a-select-box-to-wordpress-tinymce-editor',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('EspressoShortcodeSelector', tinymce.plugins.EspressoShortcodeSelector);
})();
