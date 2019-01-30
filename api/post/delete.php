<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    

    // Include Files
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Post Object
    $post = new Post($db);

    // Get raw posted data
    $data = json_decode(file_get_contents('php://input'));

    // Set Id to delete
    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Delete Post
    if($post->delete()) {
        echo json_encode(
            array('message' => 'Post Deleted')
        );
    } else {
        echo json_encode(
            array('message' => 'Post Not Deleted')
        );
    }
?>