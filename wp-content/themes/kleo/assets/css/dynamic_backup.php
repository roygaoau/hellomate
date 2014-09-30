<?php

/* ----------------------------------------------------------------
    Element definitions here
-----------------------------------------------------------------*/

global $kleo_config, $kleo_theme;
$style_sets = $kleo_config['style_sets'];

$sections = kleo_style_options();

if(!empty($sections)) {
foreach ($sections as $name => $section) {


//checks if we have a dark or light background and then creates a stronger version of the main font color for headings
$section['heading'] = kleo_calc_similar_color($section['text'], (kleo_calc_perceived_brightness($section['bg'], 100) ? 'lighter' : 'darker'), 3);

//check if we have a dark or lighht background and then creates a lighter version of the main font color
$section['lighter'] = kleo_calc_similar_color($section['bg'], (kleo_calc_perceived_brightness($section['bg'], 100) ? 'lighter' : 'darker'), 4);

// Highlight background color in RBG
$section["high_bg_rgb"] = kleo_hex_to_rgb($section['high_bg']);

// Alternate background color in RBG
$section["alternate_bg_rgb"] = kleo_hex_to_rgb($section['alt_bg']);

// Text color in RBG
$section["text_color_rgb"] = kleo_hex_to_rgb($section['text']);

/* Use like this
 * 
 * .<?php echo $name; ?>-color .rgb-element {
 *	background-color: rgba(<?php echo $section['high_bg_rgb']['r']; ?>,<?php echo $section['high_bg_rgb']['g']; ?>,<?php echo $section['high_bg_rgb']['b']; ?>,0.4);
 * }
 */

?>

  


/*** TEXT COLOR ***/
.<?php echo $name; ?>-color,
.<?php echo $name; ?>-color .logo a,
.<?php echo $name; ?>-color .breadcrumb a,
.<?php echo $name; ?>-color .pager li > a,
.<?php echo $name; ?>-color .pager li > span,
.<?php echo $name; ?>-color .nav-pills > li > a,
.<?php echo $name; ?>-color .nav-pills > li.active > a,
.<?php echo $name; ?>-color .nav-tabs > li > a,
.<?php echo $name; ?>-color .kleo-tabs .nav-tabs li a i,
.<?php echo $name; ?>-color .sidebar ul li a,
.<?php echo $name; ?>-color .sidebar .widget-title,
.<?php echo $name; ?>-color .sidebar h4.widget-title a,
.<?php echo $name; ?>-color .widget_tag_cloud a,
.<?php echo $name; ?>-color #wp-calendar tbody td:hover,



/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.item-list-tabs a,
.<?php echo $name; ?>-color #bp-login-widget-submit,
.<?php echo $name; ?>-color .widget_bp_groups_widget .item-options a,
.<?php echo $name; ?>-color .widget_bp_core_members_widget .item-options a,
.<?php echo $name; ?>-color .widget_bp_core_friends_widget .item-options a,
.<?php echo $name; ?>-color .widget_bp_groups_widget,
.<?php echo $name; ?>-color .widget_bp_core_members_widget,
.<?php echo $name; ?>-color .widget_bp_core_friends_widget,
.<?php echo $name; ?>-color .bp-login-widget-user-logout a,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a:hover,
.<?php echo $name; ?>-color .bbp-pagination-links span.current {
	color: <?php echo $section['text']; ?>;
}

.<?php echo $name; ?>-color .navbar-toggle .icon-bar {
	background-color: <?php echo $section['text']; ?>;
}







/*** BACKGROUND COLOR ***/
.<?php echo $name; ?>-color,
.<?php echo $name; ?>-color .hr-title abbr,
.<?php echo $name; ?>-color.social-header, /* without space between classes*/
.<?php echo $name; ?>-color code,
.<?php echo $name; ?>-color .tabs-style-square > li.active > a,
.<?php echo $name; ?>-color .kleo-main-header,
.<?php echo $name; ?>-color .theme-select,

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress .activity-read-more a,
.<?php echo $name; ?>-color #wp-calendar caption,
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count,
.<?php echo $name; ?>-color #buddypress #friend-list .friend-inner-list,
.<?php echo $name; ?>-color #buddypress #member-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #members-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress div#item-header .toggle-header,
.<?php echo $name; ?>-color #buddypress #groups-list .group-inner-list,

/*bbPress*/
.<?php echo $name; ?>-color .bbp-pagination-links a,
.<?php echo $name; ?>-color .bbp-pagination-links span {
	background-color: <?php echo $section['bg']; ?>;
}

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress #item-header-avatar,
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count {
	color: <?php echo $section['bg']; ?>;
}

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count {
	border-color: <?php echo $section['bg']; ?>;
}










/*** LINK COLOR ***/
.<?php echo $name; ?>-color a,
.<?php echo $name; ?>-color .icon-colored i,
.<?php echo $name; ?>-color .dropdown-menu > .active > a,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:focus,

.<?php echo $name; ?>-color .navbar-nav > li > a,
.<?php echo $name; ?>-color .dropdown-menu > li > a,
.<?php echo $name; ?>-color .top-menu li > a:hover,
.<?php echo $name; ?>-color #top-social li a:hover,
.<?php echo $name; ?>-color .dropdown-menu > li > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > li > a:focus,
.<?php echo $name; ?>-color .dropdown-submenu:hover > a,
.<?php echo $name; ?>-color .dropdown-submenu:focus > a,



/*Buddypress*/
.<?php echo $name; ?>-color #buddypress a.button.unfav,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs li.selected a,
.<?php echo $name; ?>-color .widget_bp_groups_widget .item-options a.selected,
.<?php echo $name; ?>-color .widget_bp_core_members_widget .item-options a.selected,
.<?php echo $name; ?>-color .widget_bp_core_friends_widget .item-options a.selected,
.<?php echo $name; ?>-color .tabs-style-line > li.active > a {
	color: <?php echo $section['link']; ?>;
}

/*Buddypress*/
.<?php echo $name; ?>-color .checkbox-mark:before,
.<?php echo $name; ?>-color .checkbox-cb:checked ~ .checkbox-mark,

/*bbPress*/
.<?php echo $name; ?>-color #bbpress-forums .bbp-forums-list {
	border-color: <?php echo $section['link']; ?>;
}
/*Buddypress*/
.<?php echo $name; ?>-color #buddypress li span.unread-count,
.<?php echo $name; ?>-color #buddypress #groups-list .item-avatar .member-count {
	background-color: <?php echo $section['link']; ?>;
}

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress div.item-list-tabs#subnav ul li.current a {
	border-bottom-color: <?php echo $section['link']; ?>;
}







/*** HOVER LINK COLOR ***/
.<?php echo $name; ?>-color a:hover,
.<?php echo $name; ?>-color .sidebar ul li a:hover,
.<?php echo $name; ?>-color .nav-collapse ul:first-child > li > a:hover,
.<?php echo $name; ?>-color .post-meta a:hover,
.<?php echo $name; ?>-color .post-footer a:hover,
.<?php echo $name; ?>-color .tabs-style-line > li.active > a:hover,
.<?php echo $name; ?>-color .tabs-style-line > li.active > a:focus {
	color: <?php echo $section['link_hover']; ?>;
}


/*** BORDER COLOR ***/
.<?php echo $name; ?>-color.container-wrap, /* without space between classes*/
.<?php echo $name; ?>-color .btn-default,
.<?php echo $name; ?>-color#footer, /* without space between classes*/
.<?php echo $name; ?>-color#socket, /* without space between classes*/
.<?php echo $name; ?>-color.social-header,
.<?php echo $name; ?>-color .kleo-main-header,
.<?php echo $name; ?>-color .template-page,
.<?php echo $name; ?>-color .sidebar-right,
.<?php echo $name; ?>-color .sidebar-left,
.<?php echo $name; ?>-color .sidebar-extra,
.<?php echo $name; ?>-color .sidebar-main,
.<?php echo $name; ?>-color .hr-title,
.<?php echo $name; ?>-color .testimonial-image img,
.<?php echo $name; ?>-color #top-social li a,
.<?php echo $name; ?>-color .top-menu li > a,
.<?php echo $name; ?>-color .list-divider li,
.<?php echo $name; ?>-color .tooltip-inner,
.<?php echo $name; ?>-color .callout-blockquote blockquote,
.<?php echo $name; ?>-color .pager li > a,
.<?php echo $name; ?>-color .pager li > span,
.<?php echo $name; ?>-color .nav-tabs,
.<?php echo $name; ?>-color .nav-pills > li > a,
.<?php echo $name; ?>-color .theme-select,

/* Buddypress */
.<?php echo $name; ?>-color .activity-timeline,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs ul li a span,
.<?php echo $name; ?>-color #buddypress button,
.<?php echo $name; ?>-color #buddypress a.button,
.<?php echo $name; ?>-color #buddypress input[type=submit],
.<?php echo $name; ?>-color #buddypress input[type=button],
.<?php echo $name; ?>-color #buddypress input[type=reset],
.<?php echo $name; ?>-color #buddypress ul.button-nav li a,
.<?php echo $name; ?>-color #buddypress div.generic-button a,
.<?php echo $name; ?>-color #buddypress .comment-reply-link,
.<?php echo $name; ?>-color #buddypress div.activity-comments form .ac-textarea,
.<?php echo $name; ?>-color #buddypress #whats-new,
.<?php echo $name; ?>-color #buddypress div.message-search,
.<?php echo $name; ?>-color #buddypress div.dir-search,
.<?php echo $name; ?>-color #buddypress .activity-read-more,
.<?php echo $name; ?>-color #bp-login-widget-submit,
.<?php echo $name; ?>-color .bbp_widget_login .button.user-submit,
.<?php echo $name; ?>-color #wp-calendar caption,
.<?php echo $name; ?>-color .wp-caption,
.<?php echo $name; ?>-color .widget form#bbp-search-form > div,
.<?php echo $name; ?>-color .widget_search #searchform > div,
.<?php echo $name; ?>-color #bp-login-widget-form input[type="text"],
.<?php echo $name; ?>-color #bp-login-widget-form input[type="password"],
.<?php echo $name; ?>-color .bbp-login-form input[type="text"],
.<?php echo $name; ?>-color #buddypress #friend-list .friend-inner-list,
.<?php echo $name; ?>-color #buddypress #member-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #members-list .member-inner-list,
.<?php echo $name; ?>-color #buddypress #groups-list .group-inner-list,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a,
.<?php echo $name; ?>-color .bbp-pagination-links span {
  border-color: <?php echo $section['border']; ?>;
}







/*** ALTERNATE BACKGROUND COLOR ***/
.<?php echo $name; ?>-color .static-caption,
.<?php echo $name; ?>-color .btn-default,
.<?php echo $name; ?>-color .pager li > a,
.<?php echo $name; ?>-color .pager li > span,
.<?php echo $name; ?>-color .nav-pills > li.active > a,
.<?php echo $name; ?>-color .nav-pills > li.active > a:hover,
.<?php echo $name; ?>-color .nav-pills > li.active > a:focus,
.<?php echo $name; ?>-color .tabs-style-square > li > a,
.<?php echo $name; ?>-color #wp-calendar thead th,
.<?php echo $name; ?>-color #wp-calendar tbody td a,
.<?php echo $name; ?>-color .widget_tag_cloud a,
.<?php echo $name; ?>-color .widget_nav_menu li.active > a,
.<?php echo $name; ?>-color #wp-calendar tbody td:hover,
.<?php echo $name; ?>-color .dropdown-menu > .active > a,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:hover,
.<?php echo $name; ?>-color .dropdown-menu > .active > a:focus,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.item-list-tabs ul li a span,
.<?php echo $name; ?>-color #bp-login-widget-submit,
.<?php echo $name; ?>-color .bbp_widget_login .button.user-submit,
.<?php echo $name; ?>-color .rtmedia-container #rtMedia-queue-list tr > td.close,
.<?php echo $name; ?>-color .rtmedia-activity-container #rtMedia-queue-list tr > td.close,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a:hover,
.<?php echo $name; ?>-color .bbp-pagination-links span.current,
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic.sticky {
	background-color: <?php echo $section['alt_bg']; ?>;
}
/* Buddypress */
.<?php echo $name; ?>-color .bbp_widget_login .bbp-logged-in .user-submit,
.<?php echo $name; ?>-color #buddypress #item-header-avatar,
.<?php echo $name; ?>-color #buddypress .activity-list .activity-avatar,
.<?php echo $name; ?>-color .bp-login-widget-user-avatar,
.<?php echo $name; ?>-color #buddypress #friend-list li div.item-avatar img.avatar,
.<?php echo $name; ?>-color #buddypress #member-list li div.item-avatar img.avatar,
.<?php echo $name; ?>-color #buddypress #members-list li div.item-avatar img.avatar {
	border-color: <?php echo $section['alt_bg']; ?>;
}






/*** ALTERNATE BORDER COLOR ***/
.<?php echo $name; ?>-color .static-caption:before {
	border-color: <?php echo $section['alt_bg']; ?>;
}
.<?php echo $name; ?>-color .nav-pills > li.active > a,
.<?php echo $name; ?>-color .nav-pills > li.active > a:hover,
.<?php echo $name; ?>-color .nav-pills > li.active > a:focus,
.<?php echo $name; ?>-color .tabs-style-square > li > a,
.<?php echo $name; ?>-color .nav-tabs > li.active > a,
.<?php echo $name; ?>-color .nav-tabs > li.active > a:hover,
.<?php echo $name; ?>-color .nav-tabs > li.active > a:focus,
.<?php echo $name; ?>-color #wp-calendar thead th,
.<?php echo $name; ?>-color #wp-calendar tbody td,
.<?php echo $name; ?>-color .widget_tag_cloud a,

/* bbPress */
.<?php echo $name; ?>-color .bbp-topics ul.sticky {
	border-color: <?php echo $section['alt_border']; ?>;
}
.<?php echo $name; ?>-color .widget_nav_menu a,
.<?php echo $name; ?>-color .wpex-widget-recent-posts-li,
.<?php echo $name; ?>-color .widget_categories li,
.<?php echo $name; ?>-color .widget_recent_entries li,
.<?php echo $name; ?>-color .widget_archive li,
.<?php echo $name; ?>-color .widget_display_views li,
.<?php echo $name; ?>-color .widget_recent_comments li,
.<?php echo $name; ?>-color .widget_product_categories li,
.<?php echo $name; ?>-color .widget_layered_nav li {
	border-bottom-color: <?php echo $section['alt_border']; ?>;
}
.<?php echo $name; ?>-color .widget_nav_menu li:first-child > a,
.<?php echo $name; ?>-color .kleo-widget-recent-posts-li:first-child,
.<?php echo $name; ?>-color .widget_categories li:first-child,
.<?php echo $name; ?>-color .widget_recent_entries li:first-child,
.<?php echo $name; ?>-color .widget_archive li:first-child,
.<?php echo $name; ?>-color .widget_display_views li:first-child,
.<?php echo $name; ?>-color .widget_recent_comments li:first-child,
.<?php echo $name; ?>-color .widget_product_categories li:first-child,
.<?php echo $name; ?>-color .widget_layered_nav li:first-child {
	border-top-color: <?php echo $section['alt_border']; ?>;
}

/* bbPress */
.<?php echo $name; ?>-color .bbp-topics ul.sticky:after,
.<?php echo $name; ?>-color .bbp-forum-content ul.sticky:after,
.<?php echo $name; ?>-color #buddypress div#item-nav ul li a:before {
	color: <?php echo $section['alt_border']; ?>;
}




/*** HIGHLIGHT COLOR ***/
.<?php echo $name; ?>-color .btn-buy.btn-default,
.<?php echo $name; ?>-color code,
.<?php echo $name; ?>-color .default-color,
.<?php echo $name; ?>-color #top-menu li.test a:hover,
.<?php echo $name; ?>-color .nav-tabs > li > a i,

.<?php echo $name; ?>-color .panel-primary,
.<?php echo $name; ?>-color .panel-primary > .panel-heading,
.<?php echo $name; ?>-color .popover-title,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress li span.unread-count,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group,
.<?php echo $name; ?>-color #footer .widget-title {
	color: <?php echo $section['high_color']; ?>;
}




/*** HIGHLIGHT BACKGROUND ***/
.<?php echo $name; ?>-color .top-menu .label,

.<?php echo $name; ?>-color .btn-buy.btn-default,
/*.logo img,*/
.<?php echo $name; ?>-color .tp-rightarrow.default:hover,
.<?php echo $name; ?>-color .tp-leftarrow.default:hover,
.<?php echo $name; ?>-color .botton_gray,

.<?php echo $name; ?>-color .kleo-quick-contact-link:hover,
.<?php echo $name; ?>-color .quick-contact-active,
.<?php echo $name; ?>-color .mejs-time-loaded,
.<?php echo $name; ?>-color .mejs-postroll-close,
/*.pin,*/
.<?php echo $name; ?>-color .kleo-pin-circle span,
.<?php echo $name; ?>-color .kleo-pin-icon span,
.<?php echo $name; ?>-color .bullet.selected,
.<?php echo $name; ?>-color .btn-highlight,
.<?php echo $name; ?>-color .popover-title,
.<?php echo $name; ?>-color .btn-group-or > .btn-highlight.btn:first-child:after,
.<?php echo $name; ?>-color .ordered-list.icon-colored li:before,
.<?php echo $name; ?>-color .panel-primary > .panel-heading,
.<?php echo $name; ?>-color .list-group-item.active,
.<?php echo $name; ?>-color .kleo-carousel-container .carousel-arrow .carousel-prev:hover,
.<?php echo $name; ?>-color .kleo-carousel-container .carousel-arrow .carousel-next:hover,
.<?php echo $name; ?>-color .kleo-carousel-container .gal-carrow .carousel-prev:hover,
.<?php echo $name; ?>-color .kleo-carousel-container .gal-carrow .carousel-next:hover,
.<?php echo $name; ?>-color .kleo-banner-slider .kleo-banner-prev:hover,
.<?php echo $name; ?>-color .kleo-banner-slider .kleo-banner-next:hover,
.<?php echo $name; ?>-color .carousel-pager a.selected,
.<?php echo $name; ?>-color .high-bg,
.<?php echo $name; ?>-color #wp-calendar td#today a,

/* Buddypress */
.<?php echo $name; ?>-color input[type="radio"]:checked + .radiobox-mark span,
.<?php echo $name; ?>-color #buddypress .kleo-online-status.high-bg,
.<?php echo $name; ?>-color #buddypress div.generic-button a.add,
.<?php echo $name; ?>-color #buddypress div.generic-button a.accept,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group {
	background-color: <?php echo $section['high_bg']; ?>;
}

.<?php echo $name; ?>-color .icon-colored i,
.<?php echo $name; ?>-color .standard-list.icon-colored li:before,
.<?php echo $name; ?>-color .icon-colored i,
.<?php echo $name; ?>-color .panel-kleo .icon-closed,

/*bbPress*/
.<?php echo $name; ?>-color .bbp-topics-front ul.super-sticky:after,
.<?php echo $name; ?>-color .bbp-topics ul.super-sticky:after,
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.super-sticky {
	color: <?php echo $section['high_bg']; ?>;
}

.<?php echo $name; ?>-color  #wp-calendar td#today,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div.generic-button a.add,
.<?php echo $name; ?>-color #buddypress div.generic-button a.join-group,

/* bbPress */
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.super-sticky {
	border-color: <?php echo $section['high_bg']; ?>;
}








/*** FOR DARKER COLORS ***/
#main .<?php echo $name; ?>-color h1,
#main .<?php echo $name; ?>-color h2,
#main .<?php echo $name; ?>-color h3,
#main .<?php echo $name; ?>-color h4,
#main .<?php echo $name; ?>-color h5,
#main .<?php echo $name; ?>-color h6,
.<?php echo $name; ?>-color .panel-title a,
#main .<?php echo $name; ?>-color h3 a,
.<?php echo $name; ?>-color .posts-listing .article-title a,
.<?php echo $name; ?>-color .entry-content .post-title a,

/*Buddypress*/
.<?php echo $name; ?>-color #buddypress #friend-list .item-title a,
.<?php echo $name; ?>-color #buddypress #member-list h5 a,
.<?php echo $name; ?>-color #buddypress #members-list .item-title a,
.<?php echo $name; ?>-color #buddypress li.unread div.thread-info a,
.<?php echo $name; ?>-color #buddypress #groups-list .item-title a,

/*bbPress*/
.<?php echo $name; ?>-color li.bbp-forum-info .bbp-forum-title,
.<?php echo $name; ?>-color ul.topic.sticky .bbp-topic-permalink,
.<?php echo $name; ?>-color #bbpress-forums div.bbp-forum-author a.bbp-author-name,
.<?php echo $name; ?>-color #bbpress-forums div.bbp-topic-author a.bbp-author-name,
.<?php echo $name; ?>-color #bbpress-forums div.bbp-reply-author a.bbp-author-name {
	color: <?php echo $section['heading']; ?>;
}

/* Buddypress borders */
.<?php echo $name; ?>-color #buddypress button:hover,
.<?php echo $name; ?>-color #buddypress a.button:hover,
.<?php echo $name; ?>-color #buddypress a.button:focus,
.<?php echo $name; ?>-color #buddypress input[type=submit]:hover,
.<?php echo $name; ?>-color #buddypress input[type=button]:hover,
.<?php echo $name; ?>-color #buddypress input[type=reset]:hover,
.<?php echo $name; ?>-color #buddypress ul.button-nav li a:hover,
.<?php echo $name; ?>-color #buddypress ul.button-nav li.current a,
.<?php echo $name; ?>-color #buddypress div.generic-button a:hover,
.<?php echo $name; ?>-color #buddypress .comment-reply-link:hover,
.<?php echo $name; ?>-color #buddypress #whats-new:focus {
	border-color: <?php echo $section['lighter']; ?>;
}
/* Buddypress outlines */
.<?php echo $name; ?>-color  #buddypress #whats-new:focus {
	outline-color: <?php echo $section['lighter']; ?>;
}






/*** FOR LIGHTER COLORS ***/
.<?php echo $name; ?>-color .muted,
.<?php echo $name; ?>-color .post-meta,
.<?php echo $name; ?>-color .post-meta a,
.<?php echo $name; ?>-color .post-footer a,
.<?php echo $name; ?>-color .breadcrumb,
.<?php echo $name; ?>-color .breadcrumb .active,
.<?php echo $name; ?>-color .widget_nav_menu .parent > a:after,

/* Buddypress */
.<?php echo $name; ?>-color #buddypress div#item-nav ul li a:hover:before,
.<?php echo $name; ?>-color #buddypress div#item-nav ul li.current a:before,
.<?php echo $name; ?>-color #buddypress .activity-header .time-since,
.<?php echo $name; ?>-color .activity-timeline,
.<?php echo $name; ?>-color #buddypress div.item-list-tabs ul li a span,
.<?php echo $name; ?>-color #buddypress button,
.<?php echo $name; ?>-color #buddypress a.button,
.<?php echo $name; ?>-color #buddypress input[type=submit],
.<?php echo $name; ?>-color #buddypress input[type=button],
.<?php echo $name; ?>-color #buddypress input[type=reset],
.<?php echo $name; ?>-color #buddypress ul.button-nav li a,
.<?php echo $name; ?>-color #buddypress div.generic-button a,
.<?php echo $name; ?>-color #buddypress .comment-reply-link,
.<?php echo $name; ?>-color #rtMedia-queue-list tr td:first-child:before,
.<?php echo $name; ?>-color .sidebar .widget.buddypress div.item-meta,
.<?php echo $name; ?>-color .sidebar .widget.buddypress div.item-content,
.<?php echo $name; ?>-color #buddypress div#item-header div#item-meta,

/* bbPress */
.<?php echo $name; ?>-color .bbp-pagination-links a,
.<?php echo $name; ?>-color .bbp-pagination-links span {
	color: <?php echo $section['lighter']; ?>;
}







/*** SPECIFIC SCENARIO COLORS ***/

.footer-color .hr-title {
	color: <?php echo $section['border']; ?>;
}


/*** Specific Background Color ***/
.footer-color .ordered-list li:before {
	background-color: <?php echo $section['border']; ?>;
}
.<?php echo $name; ?>-color .carousel-pager a {
	background-color: <?php echo $section['alt_border']; ?>;
}

/*** Specific Border Color ***/
.footer-color .btn-app.btn-primary {
  border-color: <?php echo $section['border']; ?>;
}

.<?php echo $name; ?>-color .kleo-thumbs-images a,
.<?php echo $name; ?>-color .kleo-thumbs-animated a {
	border-color: <?php echo $section['bg']; ?>;
}

/*** Transparency ***/
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic.super-sticky {
 	background-color: rgba(<?php echo $section['high_bg_rgb']['r']; ?>,<?php echo $section['high_bg_rgb']['g']; ?>,<?php echo $section['high_bg_rgb']['b']; ?>, 0.1);
}
.<?php echo $name; ?>-color #bbpress-forums li.bbp-body ul.topic.sticky,
.<?php echo $name; ?>-color .navbar-toggle:hover,
.<?php echo $name; ?>-color .navbar-toggle:focus {
 	background-color: rgba(<?php echo $section['alternate_bg_rgb']['r']; ?>,<?php echo $section['alternate_bg_rgb']['g']; ?>,<?php echo $section['alternate_bg_rgb']['b']; ?>, 0.2);
}

.<?php echo $name; ?>-color .<?php echo $name; ?>-color .top-menu li > a,
.<?php echo $name; ?>-color #top-social li a,
.<?php echo $name; ?>-color .dropdown-submenu > a:after,
.<?php echo $name; ?>-color .widget_archive li:before,
.<?php echo $name; ?>-color .widget_categories li:before,
.<?php echo $name; ?>-color .widget_product_categories li:before,
.<?php echo $name; ?>-color .widget_layered_nav li:before,
.<?php echo $name; ?>-color .widget_display_views li:before,
.<?php echo $name; ?>-color .widget_recent_entries li:before,
.<?php echo $name; ?>-color .widget_recent_comments li:before {
 	color: rgba(<?php echo $section['text_color_rgb']['r']; ?>,<?php echo $section['text_color_rgb']['g']; ?>,<?php echo $section['text_color_rgb']['b']; ?>, 0.7);
}
  





/*** TEMPORARY ***/

.<?php echo $name; ?>-color .popover.bottom .arrow,
.<?php echo $name; ?>-color .popover.bottom .arrow:after,
.<?php echo $name; ?>-color .tooltip.top .tooltip-arrow,
.<?php echo $name; ?>-color .tooltip.right .tooltip-arrow,
.<?php echo $name; ?>-color .tooltip.bottom .tooltip-arrow,
.<?php echo $name; ?>-color .tooltip.left .tooltip-arrow {
	border-color: <?php echo $section['alt_border']; ?>;
}

.<?php echo $name; ?>-color .kleo-pin-poi {
	border-color: <?php echo $section['high_bg']; ?>;
}

/* Avoid important from app.css */
.tooltip.bottom .tooltip-arrow {
	border-left-color: transparent;
	border-right-color: transparent;
}
.tooltip.top .tooltip-arrow {
	border-left-color: transparent;
	border-right-color: transparent;
}
.tooltip.right .tooltip-arrow {
	border-top-color: transparent;
	border-bottom-color: transparent;
}
.tooltip.left .tooltip-arrow {
	border-top-color: transparent;
	border-bottom-color: transparent;
}

.nav-tabs > li.active > a,
.nav-tabs > li.active > a:hover,
.nav-tabs > li.active > a:focus {
	border-bottom-color: transparent !important;
}


/*** Responsive Colors Only ***/
@media (max-width: 991px) {
	

.dropdown-menu li.active a {
  background: transparent;
  color: #000;
}
  
  
}





<?php
}
}
/* Body Background */
echo $kleo_theme->get_bg_css('body_bg', 'body');

/* Sections background */
foreach($style_sets as $set) {
	if ($set == 'header') {
		$element = '.'.$set.'-color, .'.$set.'-color .kleo-main-header';
	} else {
		$element = '.'.$set.'-color';
	}
	echo $kleo_theme->get_bg_css('st__'.$set.'__bg_image', $element);
}

$extra_output = apply_filters('kleo_add_dynamic_style','');
echo $extra_output;
?>







