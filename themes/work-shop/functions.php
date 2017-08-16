<?php
// general functions for use in setting up post data, etc.

// Monadic functions for echoing content to the page.
function ws_ifdef_do_else( $check, $content, $else ) {
	return ( $check || !empty($check) ) ? $content : $else;
}

function ws_ifdef_do( $check, $content ) {
	return ws_ifdef_do_else( $check, $content, "");
}

function ws_ifdef_show( $content ) {
	return ws_ifdef_do( $content, $content );
}

function ws_ifdef_concat($before, $content, $after) {
	return ws_ifdef_do( $content, $before.$content.$after );
}

function ws_derive_story_title( $story ) {
	return strtolower( str_replace( ' ', '-', $story['project_story_name'] ));
}

function ws_derive_project_type( $post ) {
	$post_id = $post->ID;
	$taxonomy = 'project_type';
	$terms = wp_get_post_terms( $post_id, $taxonomy);

	$type1 = 'type-' . $terms[0]->slug;
	$type2 = '';
	$type3 = '';

	if($terms[1]->slug):
		$type2 = ' type-' . $terms[1]->slug;
	endif;


	if($terms[2]->slug):
		$type3 = ' type-' . $terms[2]->slug;
	endif;		

	$type = $type1 . $type2 . $type3;
	return $type;
}

function ws_derive_scope_string( $scope_tags ) {
	$accumulator = "";
	if ( $scope_tags ) {
		$count = count( $scope_tags );
		foreach ( $scope_tags as $i => $tag ) {
			if ( $i < $count - 1 ) {
				$accumulator .= $tag['scope_tag']->slug." ";
			} else {
				$accumulator .= $tag['scope_tag']->slug;
			}
		}
	}
	return $accumulator;	
}

function ws_split_array_by_key( $array, $delimiter, $format_function ) {
	$accumulator = "";
	if ( $array ) {
		$count = count( $array );
		foreach ( $array as $i => $tag ) { 
			if ( $i < $count - 1 ) {
				$accumulator .= $format_function($tag) . $delimiter;
			} else {
				$accumulator .= $format_function($tag);
			}
		}
	}
	return $accumulator;	
}

function ws_parity( $i, $zero, $one ) {
	return ( $i % 2 == 0 ) ? $zero : $one;
}

function ws_render_taxonomy( $taxonomy, $action ) {
	$accumulator = "";
	foreach ( $taxonomy as $i => $term ) {
		$accumulator .= $action( $term );
	}
	return $accumulator;
}

function ws_render_date( $datestring ) {
	$date = date_parse( $datestring );
	return $date['month'] . '/' . $date['day'] . '/' . $date['year'];
}

function ws_decide_image_type( $file ) {
	return '<img type="'.$file['mime_type'].'" src="'.$file['url'].'" />';
}

function ws_decide_link_type( $link ) {
	return ( !strpos($link, 'http://') ) ? $link : get_bloginfo('url').$link;

}

// Wordpress Functionality

get_template_parts( array( 'theme-options') );

add_action( 'init', 'create_post_type' );

function create_post_type() {
	register_post_type( 'projects',
		array(
			'labels' => array(
				'name' => 'Projects',
				'singular_name' =>'Project',
				'add_new' => 'Add New',
				'add_new_item' => 'Add New Project',
				'edit_item' => 'Edit Project',
				'new_item' => 'New Project',
				'all_items' => 'All Projects',
				'view_item' => 'View Project',
				'search_items' => 'Search Projects',
				'not_found' =>  'No Projects found',
				'not_found_in_trash' => 'No Projects found in Trash', 				
				),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'projects'),
			'supports' => array( 'title', 'editor', 'thumbnail', 'tags' ),
			'taxonomies' => array( 'scope_tag', 'type' )			
			)
		);

}

function projects_taxonomy() {  
	register_taxonomy(  
		'project_categories',  
		'projects',  
		array(  
			'hierarchical' => true,  
			'label' => 'Project Categories',  
			'query_var' => true,  
			'rewrite' => array('slug' => 'project_categories')  
			)  
		);  
}
add_action( 'init', 'projects_taxonomy' );

function projects_scope_tags() {
	register_taxonomy(
		'scope_tag',
		'projects',
		array(
			'hierarchical' => false,
			'label' => 'Scope Tags',
			'query_var' => true,
			'rewrite' => array('slug' => 'scope_tags')
			)
		);
}
add_action('init', 'projects_scope_tags');

function project_type() {
	register_taxonomy(
		'project_type',
		'projects',
		array(
			'hierarchical' => true,
			'label' => 'Project Type',
			'query_var' => true,
			'rewrite' => array('slug' => 'project_type')
			)
		);
}
add_action('init', 'project_type');

function theme_scripts() {
	wp_deregister_script( 'jquery' );

	wp_register_script( 'jquery', get_template_directory_uri() . '/_/js/jquery.js');
	wp_register_script( 'jquery-viewport', get_template_directory_uri() . '/_/js/jquery.viewport.js');
	wp_register_script( 'isotope', get_template_directory_uri() . '/_/js/isotope.js');
	wp_register_script( 'bootstrap', get_template_directory_uri() . '/_/js/bootstrap.js');
	wp_register_script( 'flexslider', get_template_directory_uri() . '/_/js/flexslider.js');
	wp_register_script( 'functions', get_template_directory_uri() . '/_/js/functions.js');
	wp_register_script( 'iso', get_template_directory_uri() . '/_/js/iso.js');
	wp_register_script( 'instafeed', get_template_directory_uri() . '/_/js/instafeed.min.js' );
	wp_register_script( 'current', get_template_directory_uri() . '/_/js/current.js' );

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-viewport' );
	wp_enqueue_script( 'isotope' );    
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'flexslider' );
	wp_enqueue_script( 'instafeed' ); 
	wp_enqueue_script( 'functions' );
	wp_enqueue_script( 'iso' );	
	wp_enqueue_script( 'current', $deps = array( 'jquery', 'instafeed' ) );

	if (!file_exists( dirname( __FILE__ ) . '/env_prod' )){
		wp_register_script( 'cssrefresh', get_template_directory_uri() . '/_/js/cssrefresh.js');
		wp_enqueue_script( 'cssrefresh' );		
	}

}
add_action('wp_enqueue_scripts', 'theme_scripts');

function theme_styles() { 
	wp_register_style( 'fonts', get_template_directory_uri() . '/_/fonts/fonts.css');    
	wp_register_style( 'main', get_template_directory_uri() . '/_/css/main.css');

	wp_enqueue_style( 'fonts' );    
	wp_enqueue_style( 'main' );    
}
add_action('wp_enqueue_scripts', 'theme_styles');

function enqueue_less_styles($tag, $handle) {
	global $wp_styles;
	$match_pattern = '/\.less$/U';
	if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
		$handle = $wp_styles->registered[$handle]->handle;
		$media = $wp_styles->registered[$handle]->args;
		$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
		$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
		$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

		$tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
	}
	return $tag;
}
add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 300, 183, true ); 
}
if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'menu', 250, 153, true );  	
	add_image_size( 'square', 720, 720, true );  
	add_image_size( 'person', 720, 834, true );  			
	add_image_size( 'project', 720, 440, true );  	
	add_image_size( 'facebook', 1200, 630, true );  
	add_image_size( 'slideshow', 1440, 878, true );  
	add_image_size( 'slideshow-project', 1440, 720, true );
}

// Remove post formats support
add_action('after_setup_theme', 'remove_post_formats', 11);
function remove_post_formats() {
	remove_theme_support('post-formats');
}

function login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/_/css/login.css' );
}
add_action('login_head', 'login_css');

function customAdmin() {
	wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/_/css/admin.css' );}
	add_action('admin_head', 'customAdmin');

	function remove_menus () {
		global $menu;
		$restricted = array( __('Comments'),/*__('Tools') ,__('Posts'),__('Settings') */ );
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
	}
	add_action('admin_menu', 'remove_menus');

	function remove_acf_menu(){
    // provide a list of usernames who can edit custom field definitions here
		$admins = array( 
			'dev','greg','nic'
			);

    // get the current user
		$current_user = wp_get_current_user();

    // match and remove if needed
		if( !in_array( $current_user->user_login, $admins ) )
		{
			remove_menu_page('edit.php?post_type=acf');
		}

	}
	add_action( 'admin_menu', 'remove_acf_menu' );

	show_admin_bar(false);

	function cc_mime_types( $mimes ){
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter( 'upload_mimes', 'cc_mime_types' );

	function get_template_parts( $parts = array() ) {
		foreach( $parts as $part ) {
			get_template_part( $part );
		};
	}

	function is_child( $parent = '' ) {
		global $post;

		$parent_obj = get_page( $post->post_parent, ARRAY_A );
		$parent = (string) $parent;
		$parent_array = (array) $parent;

		if ( in_array( (string) $parent_obj['ID'], $parent_array ) ) {
			return true;
		} elseif ( in_array( (string) $parent_obj['post_title'], $parent_array ) ) {
			return true;    
		} elseif ( in_array( (string) $parent_obj['post_name'], $parent_array ) ) {
			return true;
		} else {
			return false;
		}
	}

	?>