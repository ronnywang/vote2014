<?php

include(__DIR__ . '/webdata/init.inc.php');

Pix_Controller::addCommonHelpers();
Pix_Controller::addDispatcher(function($uri){
    list(, $type) = explode('/', $uri);
    if ('judge' == $type) {
        return array('index', 'judge');
    }
});
Pix_Controller::dispatch(__DIR__ . '/webdata/');
