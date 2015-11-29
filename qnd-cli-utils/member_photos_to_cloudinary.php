<?php
require 'bootstrap.php';

set_time_limit(0);
\Cloudinary::config($container['settings']['cloudinary']);

$env_mode = $container['settings']['mode'];
$cdn_upload_path = 'phpindonesia/'.$env_mode.'/';
$user_photo_path = $container['settings']['upload_photo_profile_path'];
$files = scandir(rtrim($user_photo_path, _DS_));

echo "Upload user photos...\n\n";

$num = 1;
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        $file_noext = explode('.', $file)[0];
        $options = [
            'public_id' => $cdn_upload_path.$file_noext,
            'tags' => ['user-avatar'],
        ];

        // Upload file
        echo "Uploading ".$num.".".$file."\n";
        \Cloudinary\Uploader::upload($user_photo_path.$file, $options);
    }

    $num++;
}

echo "Done!\n\n";