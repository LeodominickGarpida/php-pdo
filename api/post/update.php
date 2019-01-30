<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');

    // Include files
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Post Object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set Id to update and items
    $post->id = $data->id;
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    // Update Post
    if($post->update()) {
        echo json_encode(
            array('message' => 'Post Updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Updated')
        );
    }
?>