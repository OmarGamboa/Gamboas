<?php
//********************************************************************//
//THIS FILE CONTAINS FUNCTIONS TO GET AND STORE SEARCHES ON TWITTER
// JAN 22, 2015
//********************************************************************//

// Require the library file
require_once('TwitterAPIExchange.php');

include "db.php";

// Get the hashtag and twitter account from the active talks
$sql = 'SELECT id, hashtag, twitter_account FROM talks WHERE (now() BETWEEN start_date AND end_date)';

if ($result = $con->query($sql)) {

	// For each talk gets the tweets and save them into the database
	while($row = $result->fetch_array(MYSQL_ASSOC)) {
	
	    //GetAndSave($row['hashtag'], $row['twitter_account']);

	    $tweets = GetTweets($row['hashtag'], $row['twitter_account']);
	    
	    // Get only the statuses from twitter (Tweets)
	    $statuses = $tweets['statuses'];
	    // Get 
	    //// $search_metadata = $tweets['search_metadata'];
	    
	    // Make a count of the tweets
	    $statusCount = count($statuses);
	    
	    $Talk_ID = $row['id'];
	    
	    echo $Talk_ID . ' Count:' . $statusCount . '<br>';
	    
	    //Save function
	    SaveTWMessage($statuses, $statusCount, $con, $Talk_ID);
	}
}

// Closing connection
mysqli_close($con);



//function GetAndSave($hashtag, $TW_Account){
//	$tweets = GetTweets($hashtag, $TW_Account);
//	$statuses = $tweets['statuses'];
//	$search_metadata = $tweets['search_metadata'];
//	$statusCount = count($statuses);
//	
//	//Save function
//	SaveTWMessage($statuses, $statusCount, $con);
//}

//Get the tweets with a given hashtag and twitter account
function GetTweets($hashtag, $TW_Account){
	
	//Include Twitter tokens file
	include "TWInfo.php";
	
	// Setup the Get URL
	$url = 'https://api.twitter.com/1.1/search/tweets.json';

	if (strlen($TW_Account) > 0)
		$TW_Account = "%20%40" . $TW_Account; // %20 = SPACE, %40 = "AT" SYMBOL (@)
	
	$getfield = '?q=%23' . $hashtag . $TW_Account; // %23 = #
	
	$requestMethod = 'GET';
		
	// Create the object
	$twitter = new TwitterAPIExchange($settings);
	
	// Make the request and get the response into the $json variable
	$json =  $twitter->setGetfield($getfield)
					 ->buildOauth($url, $requestMethod)
					 ->performRequest();
	
	
	// It's json, so decode it into an array
	$result = json_decode($json, true);
	
	// Return the info from twitter
	return $result;
}

//Get the tweets with the hashtag from URL parameters
function GetTweetsByURL(){
	
	//Include Twitter tokens file
	include "TWInfo.php";
	
	// Setup the Get URL
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	
	// The request method, according to the docs, is GET, not POST
	$requestMethod = 'GET';
	
	// Get hashtag from URL and set up the string
	$hashtag = strval($_GET['h']);
	
	// Get twitter account from URL and set up the string
	$TW_Account = strval($_GET['ta']);
	if (strlen($TW_Account) > 0)
		$TW_Account = "%20%40" . $TW_Account; // %20 = SPACE, %40 = "AT" SYMBOL (@)
	
	$getfield = '?q=%23' . $hashtag . $TW_Account; // %23 = #
		
	// Create the object
	$twitter = new TwitterAPIExchange($settings);
	
	// Make the request and get the response into the $json variable
	$json =  $twitter->setGetfield($getfield)
					 ->buildOauth($url, $requestMethod)
					 ->performRequest();
	
	// It's json, so decode it into an array
	$result = json_decode($json, true);
	
	// Access the profile_image_url element in the array
	return $result;
	
	echo $getfield;
}

// Save the statuses (tweets) into the database
function SaveTWMessage($array, $Count, $connection, $Talk_ID){

	// For each message in the array get the info and store it in the proper field
	for ($i=0; $i<$Count; $i++){
	
		$returnMessage = ' - Success inserting Row' . $i;
		
		// Extract the message info from the array
		$message = $array[$i];
		
		// Get the User info
		$User = $message['user'];
			$IDUser = $User['id'];
			$NameUser = $User['name'];
			$ScreenNameUser = $User['screen_name'];;
			$UserImage = $User['profile_background_image_url'];
			$UserFollowersCount = $User['followers_count'];

		// Get the Hashtags info
		$Entities = $message['entities'];
		 	$HashtagsEntity = $Entities['hashtags'];

			$HashtagsChain = "";
			foreach ($HashtagsEntity as $key => $HashtagInfo) {
				$hashtag = $HashtagInfo['text'];
				$HashtagsChain .= $hashtag . ",";
			}

		$Hashtags = rtrim($HashtagsChain, ",");
		$TweetID = $message['id'];
		$MessageImage = $UserImage; // CHECK THIS!
		$MessageDate = $message['created_at'];
		$ConvertedDate = date("Y-m-d H:i:s", strtotime($MessageDate));
		
		//$Talk_ID = strval($_GET['tlk']);

		$Text = $message['text'];
		
		$sql = "INSERT INTO messages"
		 			. "(TweetID, IDTwitterUser, NameUser, ScreenNameUser, UserImage, MessageImage, MessageDate, Hashtags, UserFollowersCount, Talk_ID, Text, InsertDate)
		 		VALUES ('" . $TweetID
		 		. "', '" . $IDUser
				. "', '" . $NameUser
				. "', '" . $ScreenNameUser
				. "', '" . $UserImage
				. "', '" . $MessageImage
				. "', '" . $ConvertedDate
				. "', '" . $Hashtags
				. "', '" . $UserFollowersCount
				. "', '" . $Talk_ID
				. "', '" . $Text
				. "', now())";
		
		//echo $sql . " <br><br><br>";
		// Execute query
		if ($connection->query($sql) === TRUE) {
			echo $returnMessage;
		} else {
			echo "Error: " . $sql . "--->" . $connection->error;
		}
	}
}
?>