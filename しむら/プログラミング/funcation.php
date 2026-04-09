<?php
if (!defined('ABSPATH')) {
	exit;
}

/************************************************************
 * メニュー
 ************************************************************/

add_action('after_setup_theme', function () {
	register_nav_menus(array(
		'primary' => __('グローバルナビゲーション', 'theme'),
		'sub'     => __('フッターナビゲーション', 'theme'),
	));
});

add_action('widgets_init', function () {
	register_sidebar(array(
		'name'          => 'サイドバー1',
		'id'            => 'sidebar1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => 'サイドバー2',
		'id'            => 'sidebar2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => '記事ページ専用',
		'id'            => 'single',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));

	register_sidebar(array(
		'name'          => '固定ページ専用',
		'id'            => 'page',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	));
});

/**
 * Walker for the navigation
 * Modern signature for WordPress/PHP compatibility.
 */
if (!class_exists('Description_Walker')) {
	class Description_Walker extends Walker_Nav_Menu {
		public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
			$indent = ($depth) ? str_repeat("\t", $depth) : '';

			$classes = empty($item->classes) ? array() : (array) $item->classes;
			$class_names = implode(' ', array_filter($classes));
			$class_attr = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

			$output .= $indent . '<li id="menu-item-' . esc_attr($item->ID) . '"' . $class_attr . '>';

			$attributes  = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
			$attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
			$attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
			$attributes .= !empty($item->url) ? ' href="' . esc_url($item->url) . '"' : '';

			$prepend = '<strong>';
			$append = '</strong>';
			$description = !empty($item->description) ? '<span>' . esc_html($item->description) . '</span>' : '';

			if ($depth !== 0) {
				$prepend = '';
				$append = '';
				$description = '';
			}

			$item_output  = isset($args->before) ? $args->before : '';
			$item_output .= '<a' . $attributes . '>';
			$item_output .= (isset($args->link_before) ? $args->link_before : '') . $prepend . apply_filters('the_title', $item->title, $item->ID) . $append;
			$item_output .= $description . (isset($args->link_after) ? $args->link_after : '');
			$item_output .= '</a>';
			$item_output .= isset($args->after) ? $args->after : '';

			$output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
		}
	}
}


/************************************************************
 * 不要機能
 ************************************************************/

add_action('init', function () {
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);
});

function remove_recent_comments_style_custom() {
	global $wp_widget_factory;

	if (
		isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments']) &&
		is_object($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])
	) {
		remove_action(
			'wp_head',
			array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style')
		);
	}
}
add_action('widgets_init', 'remove_recent_comments_style_custom');

function my_search_form_custom($form) {
	$form = '<form role="search" method="get" id="searchform" action="' . esc_url(home_url('/')) . '">
		<input type="text" value="' . esc_attr(get_search_query()) . '" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="' . esc_attr__('Search', 'theme') . '" />
	</form>';

	return $form;
}
add_filter('get_search_form', 'my_search_form_custom');


/************************************************************
 * 管理画面カスタマイズ
 ************************************************************/

function custom_login_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . esc_url(get_template_directory_uri() . '/css/custom-login.css') . '">';
}
add_action('login_head', 'custom_login_css');

function custom_admin_css() {
	echo '<link rel="stylesheet" type="text/css" href="' . esc_url(get_template_directory_uri() . '/css/custom-admin.css') . '">';
	echo '<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">';
}
add_action('admin_head', 'custom_admin_css');

function remove_admin_bar_menu_custom($wp_admin_bar) {
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('new-post');
	$wp_admin_bar->remove_menu('new-media');
	$wp_admin_bar->remove_menu('new-link');
	$wp_admin_bar->remove_menu('new-page');
	$wp_admin_bar->remove_menu('new-user');
	$wp_admin_bar->remove_menu('user-info');
	$wp_admin_bar->remove_menu('edit-profile');
	$wp_admin_bar->remove_menu('logout');
	$wp_admin_bar->remove_menu('search');
	$wp_admin_bar->remove_menu('wpseo-menu');
}
add_action('admin_bar_menu', 'remove_admin_bar_menu_custom', 201);

function add_new_item_in_admin_bar_custom() {
	global $wp_admin_bar;

	if (!is_object($wp_admin_bar)) {
		return;
	}

	$wp_admin_bar->add_menu(array(
		'id'    => 'custom_logout_link',
		'title' => __('ログアウト', 'theme'),
		'href'  => wp_logout_url(),
	));
}
add_action('wp_before_admin_bar_render', 'add_new_item_in_admin_bar_custom');

function example_remove_dashboard_widgets_custom() {
	if (!current_user_can('administrator')) {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	}
}
add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets_custom');

remove_action('welcome_panel', 'wp_welcome_panel');

function remove_admin_menu_links_custom() {
	remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'remove_admin_menu_links_custom');

function remove_menus_custom() {
	if (!current_user_can('administrator')) {
		remove_menu_page('wpcf7');
		remove_menu_page('wpseo_dashboard');

		global $menu;
		if (is_array($menu)) {
			unset($menu[15]); // リンク
			unset($menu[20]); // ページ
			unset($menu[25]); // コメント
			unset($menu[70]); // プロフィール
			unset($menu[75]); // ツール
		}
	}
}
add_action('admin_menu', 'remove_menus_custom');

if (!current_user_can('edit_users')) {
	function wphidenag_custom() {
		remove_action('admin_notices', 'update_nag', 3);
	}
	add_action('admin_menu', 'wphidenag_custom');
}

function disable_quick_press_custom() {
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
}
add_action('wp_dashboard_setup', 'disable_quick_press_custom');


/************************************************************
 * 投稿・固定ページカスタマイズ
 ************************************************************/

function my_default_editor_custom($can_edit) {
	if (is_admin() && function_exists('get_current_screen')) {
		$screen = get_current_screen();
		if ($screen && isset($screen->id) && $screen->id === 'page') {
			return false;
		}
	}
	return $can_edit;
}
add_filter('user_can_richedit', 'my_default_editor_custom');

function disable_autosave_custom() {
	wp_deregister_script('autosave');
}
add_action('wp_print_scripts', 'disable_autosave_custom');

remove_action('pre_post_update', 'wp_save_post_revision');

function new_excerpt_mblength_custom($length) {
	return 60;
}
add_filter('excerpt_mblength', 'new_excerpt_mblength_custom');

function new_excerpt_more_custom($more) {
	global $post;
	$link = $post ? get_permalink($post->ID) : '#';
	return ' .. <a class="more" href="' . esc_url($link) . '"><i class="fa fa-angle-double-right"></i> 続きを読む</a>';
}
add_filter('excerpt_more', 'new_excerpt_more_custom');

remove_filter('the_excerpt', 'wpautop');

function custom_columns_custom($columns) {
	unset($columns['author']);
	unset($columns['comments']);
	return $columns;
}
add_filter('manage_posts_columns', 'custom_columns_custom');
add_filter('manage_pages_columns', 'custom_columns_custom');

function rkv_remove_columns_custom($columns) {
	unset($columns['wpseo-score']);
	unset($columns['wpseo-title']);
	unset($columns['wpseo-metadesc']);
	unset($columns['wpseo-focuskw']);
	return $columns;
}
add_filter('manage_edit-post_columns', 'rkv_remove_columns_custom');
add_filter('manage_edit-page_columns', 'rkv_remove_columns_custom');

function remove_post_metaboxes_custom() {
	remove_meta_box('postcustom', 'post', 'normal');
	remove_meta_box('postexcerpt', 'post', 'normal');
	remove_meta_box('commentstatusdiv', 'post', 'normal');
	remove_meta_box('trackbacksdiv', 'post', 'normal');
	remove_meta_box('revisionsdiv', 'post', 'normal');
	remove_meta_box('formatdiv', 'post', 'normal');
	remove_meta_box('authordiv', 'post', 'normal');
}
add_action('admin_menu', 'remove_post_metaboxes_custom');

function posts_columns_id_custom($defaults) {
	$defaults['wps_post_id'] = __('ID', 'theme');
	return $defaults;
}
function posts_custom_id_columns_custom($column_name, $id) {
	if ($column_name === 'wps_post_id') {
		echo (int) $id;
	}
}
add_filter('manage_pages_columns', 'posts_columns_id_custom', 5);
add_action('manage_pages_custom_column', 'posts_custom_id_columns_custom', 5, 2);

function add_page_columns_name_custom($columns) {
	$columns['slug'] = 'スラッグ';
	return $columns;
}
function add_page_column_custom($column_name, $post_id) {
	if ($column_name === 'slug') {
		$post = get_post($post_id);
		if ($post) {
			echo esc_attr($post->post_name);
		}
	}
}
add_filter('manage_pages_columns', 'add_page_columns_name_custom');
add_action('manage_pages_custom_column', 'add_page_column_custom', 10, 2);

function sort_posts_columns_custom($columns) {
	return array(
		'cb'         => '<input type="checkbox" />',
		'title'      => 'タイトル',
		'tags'       => 'タグ',
		'categories' => 'カテゴリー',
		'date'       => '日時',
	);
}
add_filter('manage_posts_columns', 'sort_posts_columns_custom');

function sort_pages_columns_custom($columns) {
	return array(
		'cb'          => '<input type="checkbox" />',
		'title'       => 'タイトル',
		'wps_post_id' => 'ID',
		'slug'        => 'スラッグ',
		'date'        => '日時',
	);
}
add_filter('manage_pages_columns', 'sort_pages_columns_custom');


/************************************************************
 * 画像関連
 ************************************************************/

function catch_that_image_custom() {
	global $post;

	if (!$post || empty($post->post_content)) {
		return get_stylesheet_directory_uri() . '/images/common/no-thumb.png';
	}

	$first_img = '';
	preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

	if (!empty($matches[1][0])) {
		$first_img = $matches[1][0];
	}

	if (empty($first_img)) {
		$first_img = get_stylesheet_directory_uri() . '/images/common/no-thumb.png';
	}

	return esc_url($first_img);
}

function replaceImagePath_custom($content) {
	return str_replace('"images/', '"' . esc_url(get_stylesheet_directory_uri() . '/images/') , $content);
}
add_filter('the_content', 'replaceImagePath_custom');

function remove_hwstring_from_image_tag_custom($html, $id, $alt, $title, $align, $size) {
	$image = image_downsize($id, $size);
	if (!is_array($image) || count($image) < 3) {
		return $html;
	}

	list($img_src, $width, $height) = $image;
	$hwstring = image_hwstring($width, $height);
	return str_replace($hwstring, '', $html);
}
add_filter('get_image_tag', 'remove_hwstring_from_image_tag_custom', 10, 6);

function give_linked_images_class_custom($html, $id, $caption, $title, $align, $url, $size, $alt = '') {
	$classes = 'nivo-lightbox';

	if (preg_match('/<a.*? class=".*?">/', $html)) {
		$html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
	} else {
		$html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '">', $html);
	}

	return $html;
}
add_filter('image_send_to_editor', 'give_linked_images_class_custom', 10, 8);

function lightbox_gallery_custom($content) {
	$pattern = '/<a(.*?)href=(\'|")(.*?).(bmp|gif|jpeg|jpg|png)(\'|")(.*?)>/i';
	$replacement = '<a$1href=$2$3.$4$5 data-lightbox-gallery="gallery"$6>';
	return preg_replace($pattern, $replacement, $content);
}
add_filter('the_content', 'lightbox_gallery_custom');


/************************************************************
 * 記事内にphpファイルをインクルード
 * Security-hardened version
 ************************************************************/

function include_my_php_custom($params = array()) {
	$params = shortcode_atts(array(
		'file' => 'default',
	), $params, 'myphp');

	$file = sanitize_file_name($params['file']);
	$base = trailingslashit(get_template_directory()) . 'myphpfiles/';
	$path = $base . $file . '.php';

	if (!file_exists($path)) {
		return '';
	}

	ob_start();
	include $path;
	return ob_get_clean();
}
add_shortcode('myphp', 'include_my_php_custom');


/************************************************************
 * ソーシャルボタン
 ************************************************************/

function SocialButton() {
	?>
	<ul>
		<li class="gplusButton"></li>
		<li class="tweetButton">
			<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-url="<?php the_permalink(); ?>" data-text="<?php the_title(); ?>" data-via="" data-lang="ja">ツイート</a>
		</li>
		<li class="likeButton">
			<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
		</li>
	</ul>
	<?php
}


/************************************************************
 * favicon
 ************************************************************/

function admin_favicon_custom() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url(get_stylesheet_directory_uri() . '/images/common/favicon.png') . '" />';
}
add_action('admin_head', 'admin_favicon_custom');

function blog_favicon_custom() {
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url(get_stylesheet_directory_uri() . '/images/common/favicon.png') . '" />';
}
add_action('wp_head', 'blog_favicon_custom');


/************************************************************
 * for Plugin
 ************************************************************/

if (!function_exists('genesis')) {
	function genesis() {}
}