<?php
/**
 * For development use, loads all javascriptfiles.
 *
 */
 
$scripts = "";
$templates = "";

$lib_path = 'js/libs/';
$model_path = 'js/models/';
$collection_path = 'js/collections/';
$view_path = 'js/views/';
$js_path = 'js/';

$rel_template_path = 'templates/';

$javascript = array(
    'libs' => array(
        'jquery-1.7.2.min',
        'underscore-min',
        'backbone-min',
        'jquery.iframe-transport'
    ),
    'collections' => array(
        'user_pictures', // soon to be obsolete
		'users',
		'pictures'
    ),
    'models' => array(
        'picture',
		'user',
    ),
    'views' => array(
        'pictures/list',
        'pictures/management_list',
        'pictures/management_single',
		'pictures/management_edit',
        'pictures/management',
        'pictures/map',
        'pictures/single',
		'pictures/find',
		'pictures/user_list',
		'pictures/user_single',
		
    ),
    'templates' => array(
        'pictures/list',
        'pictures/map',
        'pictures/picture_management',
        'pictures/single',
        'pictures/management_list',
        'pictures/management_single',
		'pictures/management_edit',
		'pictures/find',
		'pictures/user_list',
		'pictures/user_single',
		'pictures/tag_list',
		'pictures/tag_single',
    ),
    'js' => array(
        'router',
        'app',
        'bootstrap.min'
    ),
    'url' => array(
        'http://maps.googleapis.com/maps/api/js?key=AIzaSyAPJ4AnTVVdpxwsdzdFzjs-7BwDUbWzuyk&sensor=false'
    )
);

foreach ($javascript['templates'] as $template) {
    $templates .= '<script type="text/template" id="' . 
        str_replace('/', '', $template). 'template' .'">' . 
        file_get_contents($rel_template_path . $template . '.html') . '</script>' . PHP_EOL;
}

foreach ($javascript['libs'] as $lib) {
    $scripts .= '<script type="text/javascript" src="' . $lib_path . $lib . '.js"></script>' . PHP_EOL;
}
foreach ($javascript['models'] as $model) {
    $scripts .= '<script type="text/javascript" src="' . $model_path . $model . '.js"></script>' . PHP_EOL;
}
foreach ($javascript['collections'] as $collection) {
    $scripts .= '<script type="text/javascript" src="' . $collection_path . $collection . '.js"></script>' . PHP_EOL;
}
foreach ($javascript['views'] as $view) {
    $scripts .= '<script type="text/javascript" src="' . $view_path . $view . '.js"></script>' . PHP_EOL;
}
foreach ($javascript['js'] as $js) {
    $scripts .= '<script type="text/javascript" src="' . $js_path . $js . '.js"></script>' . PHP_EOL;
}
foreach ($javascript['url'] as $url) {
    $scripts .= '<script type="text/javascript" src="' . $url . '"></script>' . PHP_EOL;
}
