<?php
/*
Plugin Name: Visual Editor Custom Buttons
Plugin URI: http://www.cyberduck.se
Description: Create custom buttons in Wordpress Visual Editor.
Version: 0.9
Author: Ola Eborn
Author URI: http://www.cyberduck.se
License: GPL
*/

add_action('init', 'vecb_editor_buttons');
add_action("admin_init", "vecb_admin_init");
add_action('save_post', 'vecb_save_options');



function vecb_editor_buttons() {
	
/************************************************************************
 *
 *  Adds a filter to append the default stylesheet to the tinymce editor.
 *
 ************************************************************************/
if ( ! function_exists('tdav_css') ) {
	function tdav_css($wp) {
		
		$url = plugins_url()."/visual-editor-custom-buttons";
	
		$wp .= ',' . $url.'/css/editor-style.css';
			
	return $wp;
	}
}
add_filter( 'mce_css', 'tdav_css' );
//************************************************************************


/************************************************************************
 *
 *  Adds Form Admin Style to Admin Head
 *
 ************************************************************************/

function vecb_customAdmin() {
	
	//$file = dirname(__FILE__) . '/js/admin_scripts.js';
	//$url = plugin_dir_url($file) . 'admin_scripts.js';
	
	$url = plugins_url()."/visual-editor-custom-buttons";
	
	 
	 echo '<script type="text/javascript" src="' . $url . '/js/admin_scripts.js"></script>';
	 echo '<link rel="stylesheet" type="text/css" href="' . $url .  '/css/admin-style.css">';
	 
	 //echo '<link rel="stylesheet" type="text/css" href="' . plugin_dir_url($file) .  'editor-style.css">';
     
}

add_action('admin_head', 'vecb_customAdmin');


function vecb_frontendstyle() {
	echo '<link rel="stylesheet" type="text/css" href="' . $url .  '/css/editor-style.css">';
}


add_action('wp_head', 'vecb_frontendstyle');

/************************************************************************/

/************************************************************************
 *
 *  Register Post Type And Add Custom Fields
 *
 ************************************************************************/	
	
$args = array(

'name' => 'vecb_editor_buttons',

'label' => __('Visual Editor Custom Buttons'),

'singular_label' => __('Custom button'),

'add_new' => __('Add new button'),

'all_items' => __('Visual Editor Custom Buttons'),

'edit_item' => __('Edit button'),

'new_item' => __('New button'),

'view_item' => __('View button'),

'search_items' => __('Search buttons'),

'not_found' => __('No buttons found'),

'not_found_in_trash' => __('No buttons found in trash'),

'public' => true,

'show_ui' => true,

'capability_type' => 'post',

'hierarchical' => false,

'rewrite' => true,

'supports' => array('title'),

'menu_position' => 100

);

register_post_type( 'vecb_editor_buttons' , $args );


function vecb_admin_init(){
add_meta_box("_vecb_tags", "Button Content", "vecb_tag_options", "vecb_editor_buttons", "normal", "low");

add_meta_box("_vecb_editor", "Display in editor", "vecb_editor_options", "vecb_editor_buttons", "normal", "low");
add_meta_box("_vecb_styling", "Visual Editor content styling", "vecb_styling_options", "vecb_editor_buttons", "normal", "low");

}


function vecb_tag_options() {
	
	global $post;
    $custom = get_post_custom($post->ID);
	$left_tag = $custom["left_tag"][0];
	$right_tag = $custom["right_tag"][0];
	$block_content = $custom["block_content"][0];
	
	$radio = $custom["content-type"][0];
	

	if ($radio == "wrap" || $radio == NULL) {
		$wrap = "checked";
		$block = "";
	} else if ($radio == "block") {
		$wrap = "";
		$block = "checked";
	}
	
	
	$content = ' <div class="recb_inputblock"><input type="radio" name="content-type" class="vecb_radiobtn" id="vecb_wrap" value="wrap" '.$wrap.'>
  <label for="wrap">&nbsp;Wrap Selection</label>&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="radio" class="vecb_radiobtn" name="content-type" id="block" value="block" '.$block.'>
  <label for="block">&nbsp;Single Block</label></div>';
	
	$content .= '<section id="vecb_wrap-selection" class="vecb_inputbox recb_inputblock"><div class="vecb_label">Before</div>
	<textarea name="left_tag" id="left_tag" cols="45" rows="5">' . $left_tag  . '</textarea>';
    
	$content .= '<div class="recb_inputblock vecb_less_space"><div class="vecb_label">After</div>
	<textarea name="right_tag" id="left_tag" cols="45" rows="5">' . $right_tag  . '</textarea></div></section>';
	
	$content .= '<div id="vecb_single-block" class="vecb_inputbox recb_inputblock"><div class="vecb_label">Content</div>
	<textarea name="block_content" id="content" cols="45" rows="5">' . $block_content . '</textarea></div>';
	
	echo $content;
	
}

function vecb_editor_options() {
	
	
	global $post;
    $custom = get_post_custom($post->ID);
	$rich_editor = $custom["rich_editor"][0];
	$html_editor = $custom["html_editor"][0];
	$icon = $custom["icon"][0];
	$custom_icon = $custom["custom_icon"][0];
	$quicktag = $custom["quicktag"][0];
	
	if ($custom_icon) {
		$icon = $custom_icon;
	}
	
	$sel1 = "";
	$sel2 = "";
	$sel3 = "";
	
	$btnicons = array(
	
	"none.png",
	"2_col.png",
	"3_col.png",
	"anchor.png",
	"behance.png",
	"bookmark.png",
	"box.png",
	"brush.png",
	"charts.png",
	"circlearrow_down.png",
	"circlearrow_left.png",
	"circlearrow_right.png",
	"circlearrow_top.png",
	"circle_ok.png",
	"download.png",
	"e-mail.png",
	"envelope.png",
	"facebook.png",
	"feltpen.png",
	"film.png",
	"four_squares.png",
	"justify.png",
	"magic.png",
	"nine_squares.png",
	"note.png",
	"open_envelope.png",
	"paperclip.png",
	"pen.png",
	"pencil.png",
	"playbutton.png",
	"pushpin.png",
	"rss.png",
	"scissors.png",
	"skype.png",
	"sound.png",
	"spray.png",
	"tag.png",
	"tags.png",
	"text_height.png",
	"text_resize.png",
	"text_width.png",
	"three_dots.png",
	"twitter.png",
	"upload.png",
	"user_add.png",
	"video.png",
	"vimeo.png",
	"youtube.png"
	
	);

	$sel = array();
	
	for ($i=0;$i<count($btnicons);$i++) {
	    if ($icon == $btnicons[$i]) {
		$sel[$i] = "selected";
		} else {
		$sel[$i] = "";	
		}
	}

	
	
	if ($rich_editor != "") {
		$re = "checked"; 
		
	} else {
		$re = "";
	} 
	

	if ($html_editor != "") {
		$he = "checked"; 
	} else {
		$he = "";
	} 
	
	$content = ' <div class="recb_inputblock"><input type="checkbox" name="rich_editor" id="vecb_rich_editor" value="rich_editor" '.$re.'>
  <label for="rich_editor">&nbsp;Visual Editor</label>&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="checkbox" name="html_editor" id="vecb_html_editor" value="html_editor" '.$he.'>
  <label for="html_editor">&nbsp;HTML Editor</label></div>';
  
  $content .= '<div id="vecb_btnicon"><div class="vecb_iconselect"><div class="recb_label">Button Icon</div>
  <select name="icon" id="vecb_icon">';
  
 for ($i=0;$i<count($btnicons);$i++) {
	
	 $ticon = explode(".", $btnicons[$i]);
	 $theicon = str_replace("_"," ",$ticon[0]);
	 $theicon = ucfirst($theicon);
	
	$content .= '<option value="'.$btnicons[$i].'" '.$sel[$i].' >'.$theicon.'</option>';
	 
 }
  
  
  $content .= '</select></div>';
  
  $content .= '<div id="vecb_pluginurl" style="display:none">'.plugins_url().'</div>';
  
  $content .= '<div class="vecb_preview"><div style="padding:23px 0 0 8px"><span id="vecb_btnpreview"><img src="'.plugins_url().'/visual-editor-custom-buttons/js/icons/none.png"></span><div class="vecb_preview_text">Preview</div></div></div>';

  $content .= ' <div class="recb_inputblock"><div class="vecb_label">Custom Icon</div>
    <div class="vecb_desc">Add your custom icon by adding your icon (20x20px) in the plugin icon folder: 
	<strong>..plugins/visual-editor-custom-buttons/js/icons/</strong>
	and writing the icon name below.</div>
  <input type="text" id="vecb_custom" placeholder="my_icon.png" class="vecb_text" value="'.$custom_icon.'" name="custom_icon"></div></div>

  ';
  
  $content .= '<div id="vecb_quicktag" class="recb_inputblock"><div class="vecb_label">Quicktag Label</div>
  <div class="vecb_desc">If not set, button title will be used.</div>
  <input type="text" class="vecb_text" value="'.$quicktag.'" name="quicktag"></div>';

	echo $content;
}

function vecb_styling_options() {
	
	global $post;
    $custom = get_post_custom($post->ID);
	$styling = $custom["styling_content"][0];
	$content = '<section class="recb_inputblock"><div class="vecb_label">CSS</div>
	<div class="vecb_desc">Only for visualization in the Visual Editor. Use normal stylesheet for Front End styling.</div>
	<textarea name="styling_content" id="styling_content" cols="45" rows="5">' . $styling  . '</textarea></section>';
	
	echo $content;
	
}


/*********************** SAVE OPTIONS ****************************/

function vecb_save_options()
{
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
    global $post;
	
	if ( 'vecb_editor_buttons' == get_post_type() ) :
    update_post_meta($post->ID, "left_tag", $_POST["left_tag"]);
    update_post_meta($post->ID, "right_tag", $_POST["right_tag"]);
	update_post_meta($post->ID, "styling_content", $_POST["styling_content"]);
	update_post_meta($post->ID, "content-block", $_POST["content-block"]);
	update_post_meta($post->ID, "content-type", $_POST["content-type"]);
	update_post_meta($post->ID, "block_content", $_POST["block_content"]);
	update_post_meta($post->ID, "rich_editor", $_POST["rich_editor"]);
	update_post_meta($post->ID, "html_editor", $_POST["html_editor"]);
	update_post_meta($post->ID, "icon", $_POST["icon"]);
	update_post_meta($post->ID, "custom_icon", $_POST["custom_icon"]);
	update_post_meta($post->ID, "quicktag", $_POST["quicktag"]);
	
	
// Save updates to files

 $args = array( 'post_type' => 'vecb_editor_buttons', 
'posts_per_page' => -1, 
'order' => 'asc');


$loop = new WP_Query( $args );
$count = 0;


$stylefile = WP_PLUGIN_DIR. '/visual-editor-custom-buttons/css/editor-style.css';

$style = '@charset "UTF-8";
/* CSS Document */

';

while ( $loop->have_posts() ) : $loop->the_post(); 


$id = get_the_ID();
$count ++;
$custom = get_post_custom($post->ID);
$left_tag = $custom["left_tag"][0];
$right_tag = $custom["right_tag"][0];
$styling = $custom["styling_content"][0];
$selection = $custom["content-type"][0];
$block_content = $custom["block_content"][0];
$icon = $custom["icon"][0];
$custom_icon = $custom["custom_icon"][0];
	
	if ($custom_icon) {
		$icon = $custom_icon;
	}
	

//Remove Linebreaks
$block_content = str_replace("\r\n","",$block_content);
$right_tag = str_replace("\r\n","",$right_tag);
$left_tag = str_replace("\r\n","",$left_tag);
//



$file = WP_PLUGIN_DIR. '/visual-editor-custom-buttons/js/button'.$count.'.js';


$current = file_get_contents($file);


/************************************************************************
 *
 *  Generate Visual Editor Button JS-files
 *
 ************************************************************************/

if($selection == "wrap") {

$current = "// JavaScript Document
(function() {
    tinymce.create('tinymce.plugins.button".$count."', {
        init : function(ed, url) {
            ed.addButton('button".$count."', {
                title : '".get_the_title()."',
                image : url+'/icons/".$icon."',
                onclick : function() {
                     ed.selection.setContent('". $left_tag . "' + ed.selection.getContent() + '". $right_tag ."');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('button".$count."', tinymce.plugins.button".$count.");
})();";

} else {
	
$current = "// JavaScript Document
(function() {
    tinymce.create('tinymce.plugins.button".$count."', {
        init : function(ed, url) {
            ed.addButton('button".$count."', {
                title : '".get_the_title()."',
                image : url+'/icons/".$icon."',
                onclick : function() {
                     ed.selection.setContent('".$block_content."');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('button".$count."', tinymce.plugins.button".$count.");
})();";
	
}




$style .= $styling . "

";

// Write the contents back to the file
file_put_contents($file, $current);

/************************************************************************************/



//

endwhile;

file_put_contents($stylefile, $style);

endif;
}

}


/************************************************************************
 *
 *  Add HTML-Editor Button
 *
 ************************************************************************/
if( !function_exists('_add_my_quicktags') ){
  function _add_my_quicktags(){ 
	  
	$content = '<script type="text/javascript">';

   $args = array( 'post_type' => 'vecb_editor_buttons', 
'order' => 'asc');


$loop = new WP_Query( $args );

while ( $loop->have_posts() ) : $loop->the_post(); 

$custom = get_post_custom($post->ID);
$left_tag = $custom["left_tag"][0];
$right_tag = $custom["right_tag"][0];
$quicktag = $custom["quicktag"][0];
$html = $custom["html_editor"][0];
$radio = $custom["content-type"][0];
$block_content = $custom["block_content"][0];
$count++;


//Remove Linebreaks
$block_content = str_replace("\r\n","",$block_content);
$right_tag = str_replace("\r\n","",$right_tag);
$left_tag = str_replace("\r\n","",$left_tag);
//


if ($quicktag != "") {
	$tagtitle = $quicktag;
} else {
	$tagtitle = get_the_title();
}

   if ($html == "html_editor") :
   
   if ($radio == "wrap") {
   $content .= "QTags.addButton( 'btn".$count."', '".$tagtitle."', '".$left_tag."', '".$right_tag."' );
   ";
   } else {
	$content .= "QTags.addButton( 'btn".$count."', '".$tagtitle."', '".$block_content."', '&nbsp;' );   
	";
   }
   endif;

 endwhile; 
	
	$content .= "

    QTags.addButton( 'tag', 'Link Tag', prompt_user );
    function prompt_user(e, c, ed) {
        prmt = prompt('Enter Tag Name');
        if ( prmt === null ) return;
        rtrn = '[tag]' + prmt + '[/tag]';
        this.tagStart = rtrn;
        QTags.TagButton.prototype.callback.call(this, e, c, ed);
    }
    </script>";
	  
	 echo $content;
	  
  }
  add_action('admin_print_footer_scripts',  '_add_my_quicktags');
} 

// -----



/************************************************************************
 *
 *  Add Visual Editor Buttons
 *
 ************************************************************************/
 
add_action('admin_init', 'vecb_add_buttons');


/**
Create Our Initialization Function
*/
 
function vecb_add_buttons() {
 
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
     return;
   }
 
   if ( get_user_option('rich_editing') == 'true' ) {
     add_filter( 'mce_external_plugins', 'vecb_add_plugin' );
     add_filter( 'mce_buttons', 'vecb_register_button' );
   }
 
}

/**
Register Button
*/


function vecb_register_button( $buttons ) {
	
 $args = array( 'post_type' => 'vecb_editor_buttons', 
'posts_per_page' => -1, 
'order' => 'asc');
$loop = new WP_Query( $args );
$count=0;

$count = 0;
while ( $loop->have_posts() ) : $loop->the_post(); 

$id = get_the_ID();
$count ++;

global $post;
$custom = get_post_custom($post->ID);
$rich_editor = $custom["rich_editor"][0];

if($rich_editor) {
array_push( $buttons, "button".$count);
}

endwhile;

return $buttons;
}
/**
Register TinyMCE Plugin
*/
 
function vecb_add_plugin( $plugin_array ) {
	
	
 $args = array( 'post_type' => 'vecb_editor_buttons', 
'posts_per_page' => -1, 
'order' => 'asc');

$loop = new WP_Query( $args );
$count = 0;

while ( $loop->have_posts() ) : $loop->the_post(); 

$id = get_the_ID();
$count ++;

	$url = plugins_url()."/visual-editor-custom-buttons";
   	$plugin_array['button'.$count] = $url.'/js/button'.$count.'.js';
   
 endwhile;
 
   return $plugin_array;
}


//------------------


?>