<?php
function lang($pharse) {
static $arr = array(
    'MESSAGE' => 'اهلا يارجل',
    'name' => 'يوسف احمد فرج'
);
return $arr[$pharse];
}