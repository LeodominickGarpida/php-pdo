<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    // Include Files
    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB and Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Post Object
    $post = new Post($db);
    
    // Post Query
    $result = $post->read();

    // Row Count
    $num = $result->rowCount();

    // check if any post
    if($num > 0) {
        // Post array
        $post_arr = array();
        $post_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $post_item = array(
                'id' => $id,
                'title' => $title,
                'category_id' => $category_id,
                'category_name' => $category_name,
                'body' => html_entity_decode($body),
                'author' => $author,
                'created-_at' => $created_at
            );

            // Pust to data
            array_push($post_arr['data'], $post_item);
        }// End of while loop

        // turn to json
        echo json_encode($post_arr);
    } 
    else {
        // No Post
        echo json_encode(
            array('message' => 'No Post Found')
        );
    }
?>