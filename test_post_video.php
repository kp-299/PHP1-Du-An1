<?php

require_once __DIR__ . '/models/Post.php';
require_once __DIR__ . '/models/Video.php';

$postModel = new Post();
$videoModel = new Video();

echo '<pre>';

echo "Posts:\n";
print_r($postModel->getAll());

echo "\nVideos:\n";
print_r($videoModel->getAll());

echo '</pre>';