<?php

/**
 * @package   Astroid Framework
 * @author    Astroid Framework Team https://astroidframe.work
 * @copyright Copyright (C) 2023 AstroidFrame.work.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 * DO NOT MODIFY THIS FILE DIRECTLY AS IT WILL BE OVERWRITTEN IN THE NEXT UPDATE
 * You can easily override all files under /astroid/ folder.
 * Just copy the file to JROOT/templates/YOUR_ASTROID_TEMPLATE/astroid/elements/module_position/module_position.php folder to create and override
 */

// No direct access.
defined('_JEXEC') or die;
extract($displayData);
$title          = $params->get('title', '');
$image          = $params->get('image', '');
$image_dark     = $params->get('image_dark', '');
$use_link       = $params->get('use_link', 0);
$link           = $params->get('link', '');
$target         = $params->get('target', '');
$target         = $target !== '' ? ' target="'.$target.'"' : '';

$border_radius      =   $params->get('border_radius', '');
$rounded_size       =   $params->get('image_rounded_size', '3');
if ($border_radius == 'rounded') {
    $border_radius  =   ' ' . $border_radius . '-' . $rounded_size;
} else {
    $border_radius  =   $border_radius !== '' ? ' ' . $border_radius : '';
}
$box_shadow     = $params->get('box_shadow', '');
$box_shadow     = $box_shadow !== '' ? ' ' . $box_shadow : '';
$hover_effect   = $params->get('hover_effect', '');
$hover_effect   = $hover_effect !== '' ? ' as-effect-' . $hover_effect : '';
$transition     = $params->get('hover_transition', '');
$transition     = $transition !== '' ? ' as-transition-' . $transition : '';
$max_width      = $params->get('max_width', '');
$max_width      = $max_width !== '' ? ' style="max-width:'.$max_width.'"' : '';
if (!empty($image)) {
    if ($use_link) {
        echo '<a href="'.$link.'" title="'.$title.'"'.$target.'>';
    }
    echo '<div class="as-image position-relative overflow-hidden' . $border_radius . $box_shadow . $hover_effect . $transition . '"'.$max_width.'>';
    echo '<img src="'. Astroid\Helper\Media::getPath() . '/' . $image.'" alt="'.$title.'">';
    echo '</div>';
    if (!empty($image_dark)) {
        echo '<div class="as-image-dark d-none position-relative overflow-hidden' . $border_radius . $box_shadow . $hover_effect . $transition . '"'.$max_width.'>';
        echo '<img src="'. Astroid\Helper\Media::getPath() . '/' . $image_dark.'" alt="'.$title.'">';
        echo '</div>';
        $element->style_dark->child('.as-image')->addCss('display', 'none !important');
        $element->style_dark->child('.as-image-dark')->addCss('display', 'inline-block !important');
    }
    if ($use_link) {
        echo '</a>';
    }
}