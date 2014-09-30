<?php
$output = $color = $size = $icon = $target = $href = $el_class = $title = '';
extract(shortcode_atts(array(
    'style' => 'default',
    'size' => '',
    'type' => '',
    'icon' => 'none',
    'target' => '_self',
    'href' => '',
    'el_class' => '',
    'title' => __('Text on the button', "kleo_framework"),
    'title_alt' => "",
    'special' => '',
    'tooltip' => '',
    'tooltip_position' => '',
    'tooltip_title' => '',
    'tooltip_text' => '',
    'tooltip_action' => 'hover',
), $atts));

$before_title = '';
$after_title = '';
$before_title_alt = '';
$after_title_alt = '';

if($type == 'text-animated') {
	
	$before_title = '<span>';
	$after_title = '</span>';
	$before_title_alt = '<span>';
	$after_title_alt = '</span>';
} elseif($type == 'subtext') {
	
	$title_alt = '<small>'.$title_alt.'</small>';
} elseif($type == 'app') {
	
	$title = '<small>'.$title.'</small>';
	$before_title_alt = '<span>';
	$after_title_alt = '</span>';
}

if ( $target == 'same' || $target == '_self' ) { $target = ''; }
$target = ( $target != '' ) ? ' target="'.$target.'"' : '';

$style = ( $style != '' ) ? ' btn-'.$style : '';
$size = ( $size != '' ) ? ' btn-'.$size : '';
$icon = ( $icon != '' && $icon != 'none' ) ? '<i class="icon-'.$icon.'"></i> ' : '';
$type = $type != '' ? ' btn-'.$type : "";
$special = $special != '' ? " btn-special" : "";

$css_class = $el_class.$style.$size.$type.$special;

$title_alt = $title_alt != '' ? $title_alt : "";
$title_alt = $before_title_alt.$title_alt.$after_title_alt ;


$tooltip_class = '';
$tooltip_data = '';
if($tooltip != '') {
	if ($tooltip == 'popover') {
		$tooltip_class = ' '.$tooltip_action . '-pop';
        $tooltip_data .= ' data-toggle="popover" data-container="body" data-title="' . $tooltip_title . '" data-content="' . $tooltip_text . '" data-placement="'.$tooltip_position.'"';
	} else {
		$tooltip_class .= ' ' . $tooltip_action . '-tip';
        $tooltip_data .= ' data-toggle="tooltip" data-original-title="' . $tooltip_title . '" data-placement="' . $tooltip_position . '"';
	}
}
$css_class .= $tooltip_class;

$output .= $before_title . $icon . $title . $after_title . $title_alt;
$output = '<a class="btn'.$css_class.'" href="'.$href.'"'.$target.$tooltip_data.'>' . $output . '</a>';