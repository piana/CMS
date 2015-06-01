		CKEDITOR.on( 'instanceCreated', function( event ) {
			var editor = event.editor,
				element = editor.element;

			if ( element.is( 'h1', 'h2', 'h3' ) || element.getAttribute( 'id' ) == 'taglist' ) {

				editor.on( 'configLoaded', function() {
					editor.config.removePlugins = 'colorbutton,find,flash,font,' +
						'forms,iframe,image,newpage,removeformat,' +
						'smiley,specialchar,stylescombo,templates';
					editor.config.toolbarGroups = [
						{ name: 'editing',		groups: [ 'basicstyles', 'links' ] },
						{ name: 'undo' },
						{ name: 'clipboard',	groups: [ 'selection', 'clipboard' ] }
					];
				});
			}else{
				editor.on( 'configLoaded', function() {

				    editor.config.enterMode = CKEDITOR.ENTER_BR;
				    editor.config.entities = false;
				    editor.config.basicEntities = false;
				    editor.config.uiColor = '#e5e5e5';
				    editor.config.allowedContent = true;
			  		editor.config.toolbar =
			  	    	[
			  	    	    ['Cut','Copy','Paste','PasteText','PasteFromWord'],
			  	    	    ['Undo','Redo','-','Find','Replace','-','RemoveFormat'],
			  	    	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
			  	    	    ['Flash','Iframe','Table','HorizontalRule','SpecialChar'],
			  	    	    '/',
			  	    	    
			  	    	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
			  	    	    ['TextColor','FontSize'],
			  	    	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
			  	    	    ['Link','Unlink','Anchor']		  	    	    
			  	    	    
			  	    	];  	

				});				
			}
		});

