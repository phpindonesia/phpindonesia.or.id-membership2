<?php
require 'bootstrap.php';

set_time_limit(0);
\Cloudinary::config($container['settings']['cloudinary']);
$api = new \Cloudinary\Api;
$api->delete_resources_by_tag('user-avatar');
