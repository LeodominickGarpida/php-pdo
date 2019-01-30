<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    // Include files
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Post Object
    $post = new Post($db);

     // Get ID
     $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->readSingle();

    $post_arr = array(
        'id' => $post->id,
        'body' => $post->body,
        'author' => $post->author,
        'category_name' => $post->category_name,
        'created_at' => $post->created_at,
    );

    print_r(json_encode($post_arr));
?>