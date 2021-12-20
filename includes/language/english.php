<?php
function lang($pharse) {
static $arr = array(
    'home' => 'home',
    'catg' => 'catgeories',
    'items' => 'members',
    'logs' => 'logs',
    'staticas' => 'statics'
);
return $arr[$pharse];
}

