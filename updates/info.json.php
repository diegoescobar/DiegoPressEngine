<?php

// $data = /** whatever you're serializing **/;

// echo json_encode($data);


// $sql="select * from Posts limit 20"; 
// $result = $db->query($sql);
// $posts = $result->fetch_all(MYSQLI_ASSOC);


// echo json_encode($posts);

// $response = json_encode([
//     'posts' => $posts,
// ]);


// file_put_contents('myfile.json', json_encode( $response ));

$array = array( 
	"name" => "_magazine",
	"slug" => "_mag",
	"author" => "<a href='http://punkworks.local'>punkworks</a>",
	"author_profile" => "http://diegoescobar.github.io/",
	"version" => _S_VERSION,
	"download_url" => "http://stage.diegoescobar.ca/wp-content/uploads/2022/12/mag.zip",	
	"details_url" => "http://stage.diegoescobar.ca/blog/2022/12/17/magazine-theme/",

	"requires" => "3.0",
	"tested" => "5.8",
	"requires_php" => "5.3",
	"last_updated" => "2022-10-30 02:10:00",
	"sections" => array(
		"description" => "Updates The Magazine Theeme",
		"installation" => "Click the activate button and that's it.",
		"changelog" => "<h4>1.0 –  1 august 2022</h4><ul><li>Bug fixes.</li><li>Initital release.</li></ul>"
    ),
	"banners" => array (
		"low" => "http://punkworks.local/wp-content/uploads/updater/banner-772x250.jpg",
		"high" => "http://punkworks.local/wp-content/uploads/updater/banner-1544x500.jpg"
    ),
    );
    
    header('Content-Type: application/json; charset=utf-8');

    echo json_encode($array);