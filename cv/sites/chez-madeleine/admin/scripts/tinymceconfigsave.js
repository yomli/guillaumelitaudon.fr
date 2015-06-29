tinyMCE.init({
			mode : "exact",
			selector: "div.editable",
			elements: "content",
			body_id: "editor",
			language : "fr",
			theme : "advanced",
			skin : "o2k7",
			skin_variant : "black",
			width : "96%",
			theme_advanced_toolbar_location : "external",
			theme_advanced_buttons2 : "bold,italic,underline,strikethrough,separator,justifyleft,justifyright,justifycenter,justifyfull,separator,sub,sup,abbr,separator,forecolor,backcolor,separator,blockquote,charmap,hr,separator,styleprops",
			theme_advanced_buttons4 : "",
			theme_advanced_buttons3 : "link,unlink,anchor,separator,image,media,separator,bullist,numlist,separator,table,tablecontrols",
			theme_advanced_buttons1 : "save,separator,undo,redo,separator,cut,copy,paste,separator,code,fontselect,fontsizeselect,formatselect",
			theme_advanced_resizing : true,
			body_class: "mceBlackBody",
			plugins: "media,table,save,xhtmlxtras,style",
			save_onsavecallback : "save",
			file_browser_callback : "filebrowser",
			handle_event_callback : function(e) {
				if(e.type == 'click') {
					$('.mceExternalToolbar').draggable();
				}
				return true;
			}
		});
		
		function getQuerystring(key, default_) {
			if (default_==null) default_="";
			key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
			var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
			var qs = regex.exec(window.location.href);
			if(qs == null) return default_; else return qs[1];
		}

		function save() {
			var ed = tinyMCE.get('content');
			var page = getQuerystring("page", false);
			var content = ed.getContent();
			// Do you ajax call here, window.setTimeout fakes ajax call
			ed.setProgressState(true); // Show progress
			//alert(page+content);
			var request = jQuery.ajax({
				url: "admin/save.php",
				type: "POST",
				data: {
					content : content,
					page : page
				},
				dataType: "html"
			});

			request.done(function(msg) {
				//jQuery("#log").html( msg ).show().delay(800).fadeOut();
				alert("Mise à jour réussie !");
				ed.setProgressState(false);
			});

			request.error(function(jqXHR, textStatus) {
				alert( "Echec de la mise à jour : " + textStatus );
				ed.setProgressState(false);
			});
			
		}
		
		function filebrowser(field_name, url, type, win) {
			fileBrowserURL = "pdw_file_browser/index.php?editor=tinymce&filter=" + type;
     
			tinyMCE.activeEditor.windowManager.open({
				title: "PDW File Browser",
				url: fileBrowserURL,
				width: 950,
				height: 650,
				inline: 0,
				maximizable: 1,
				close_previous: 0
			},{
					window : win,
					input : field_name
				}
			);
		}