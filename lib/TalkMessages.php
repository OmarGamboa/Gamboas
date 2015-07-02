<?php

// echo json_encode(ReturnFrequentWords());
// echo ReturnMessages();
// echo ReturnFrequentWords();
// echo getTalkID();
// echo FakeData();
// echo ReturnFrequentHashtags();
// echo ReturnActiveUsers();
// echo ReturnUsersFollowers();//
// IsOwnerData("colombianenglish");

//**************************************//
// GET MESSAGES INFO FROM THE DATABASE  //
// JAN 20TH - 2015                      //
//**************************************//

//Return Distinct Users and Followers
function ReturnUsersFollowers(){
	// Includes
	include "db.php";
	
	//Gets the Session Variable
	//session_start();
	//$idTalk = 0;
	//if (isset($_SESSION['TalkID'])) {
	//	$idTalk = ($_SESSION['TalkID']);
	//}

	$idTalk = getTalkID();
	
	 //$idTalk = 1; // Testing variable

	// Declaring variables
	//$sql = "SELECT ScreenNameUser, UserFollowersCount FROM Messages WHERE Talk_ID = " . $idTalk . " LIMIT 8";
	$sql = "SELECT ScreenNameUser, MAX(UserFollowersCount) UserFollowersCount FROM messages WHERE Talk_ID = " . $idTalk . " GROUP BY ScreenNameUser ORDER BY UserFollowersCount DESC";
	$i = 0;
	$last = ',';
	$data = '[';
	
	// Getting data
	if ($result = $con->query($sql)) {
		$count = mysqli_num_rows($result);
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$i++;
			if($i == $count) { 
				$last = ''; 
			}
			$data = $data . "['@". $row['ScreenNameUser'] ."',". $row['UserFollowersCount'] ."]" . $last;
		}		
		// Closing connection
		$result->close();
		mysqli_close($con);
	}
	$data = $data . ']';
	
	return $data;
}

// Returns the most frequent words in the messages of the actual Talk
function ReturnFrequentWords(){
	// Includes
	include "db.php";
	//Gets the Session Variable
	// session_start();
	// $idTalk = 0;
	
	// if (isset($_SESSION['TalkID'])) {
	// 	$idTalk = ($_SESSION['TalkID']);
	// }
	
	$idTalk = getTalkID();

	 //$idTalk = 1; // Testing Variable

	// Declaring variables
	$sql = "SELECT Text FROM messages WHERE Talk_ID = " . $idTalk;

	$stack = array(); // The stack of arrays of words for each message
	
	// Getting data
	if ($result = $con->query($sql)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			// Separate every word into an array
			$keywords = keywords_extract($row['Text']);
			// Count the frequency of the words
			foreach($keywords as $palabra){
				// if (IsOwnerData($palabra)) continue;
				if (array_key_exists($palabra, $stack)) {
					$stack[$palabra]++;
				}
				else{
					$stack[$palabra] = 1;
				}

			}
		}
		// Closing connection
		$result->close();
		mysqli_close($con);
	}

	if (count($stack) == 0) {
		return '[]';
	}
	else{
		return arrayToGoogleDataTable($stack, 'yes');
	}
}

// Returns the messages of the actual Talk to paint them in a Word Cloud
function ReturnMessages(){
	// Includes
	include "db.php";
	//Gets the Session Variable

	$idTalk = getTalkID();

	 //$idTalk = 1; // Testing Variable

	// Declaring variables
	$sql = "SELECT Text FROM messages WHERE Talk_ID = " . $idTalk;

	$stack = array(); // The stack of arrays of words for each message
	
	// Getting data
	if ($result = $con->query($sql)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			// Separate every word into an array
			// $keywords = keywords_extract($row['Text']);
			
			$keywords = CleanMessage($row['Text']);

			 // CleanMessage($keywords);

			// echo json_encode($keywords);
			// echo "<p>";


			array_push($stack, $keywords);
			// echo json_encode($keywords);
			// echo '<p>';
			// echo json_encode($stack);
			// echo '<p>';

			// // Count the frequency of the words
			// foreach($keywords as $palabra){
			// 	if (array_key_exists($palabra, $stack)) {
			// 		$stack[$palabra]++;
			// 	}
			// 	else{
			// 		$stack[$palabra] = 1;
			// 	}

			// }
		}
		// Closing connection
		$result->close();
		mysqli_close($con);
	}

	if (count($stack) == 0) {
		return '[]';
	}
	else{
		return TempoarrayToGoogleDataTable($stack, 'no');
	}
}	   

// Returns the most active users in the actual Talk
function ReturnActiveUsers(){
	// Includes
	include "db.php";
	// //Gets the Session Variable
	// session_start();
	// $idTalk = 0;
	
	// if (isset($_SESSION['TalkID'])) {
	// 	$idTalk = ($_SESSION['TalkID']);
	// }
	
	$idTalk = getTalkID();
	// $idTalk = 1; // Testing Variable

	// Declaring variables
	$sql = "SELECT DISTINCT NameUser, ScreenNameUser, COUNT(NameUser) AS Conteo FROM messages WHERE Talk_ID = " . $idTalk 
			. " GROUP BY NameUser ORDER BY Conteo DESC";

	$i = 0;
	$last = ',';
	$data = '[';
	
	// Getting data
	if ($result = $con->query($sql)) {
		$count = mysqli_num_rows($result);
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			$i++;
			if($i == $count) { 
				$last = ''; 
			}
			$data = $data . "['@". $row['ScreenNameUser'] ."',". $row['Conteo'] ."]" . $last;
		}		
		// Closing connection
		$result->close();
		mysqli_close($con);
	}
	$data = $data . ']';
	
	return $data;
}

// Returns the most used hashtags in the actual Talk
function ReturnFrequentHashtags(){
	// Includes
	include "db.php";

	$idTalk = getTalkID();

	// Declaring variables
	$sql = "SELECT hashtags FROM messages WHERE Talk_ID = " . $idTalk;

	$stack = array(); // The stack of arrays of words for each message
			
	// Getting data
	if ($result = $con->query($sql)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			// Separate every word into an array
			$keywords = explode(",", $row['hashtags']);

			// Count the frequency of the words
			foreach($keywords as $hashtag){
				// Basic Validation
				if ($hashtag == "") continue; 
				if (IsOwnerData($hashtag)) continue;
				
				$hashtag = "#" . strtolower($hashtag);

				if (array_key_exists($hashtag, $stack)) {
					$stack[$hashtag]++;
				}
				else{
					$stack[$hashtag] = 1;
				}
			}
		}
		// Closing connection
		$result->close();
		//mysqli_close($con);
	}
	if (count($stack) == 0) {
		return '[]';
	}
	else{
		return arrayToGoogleDataTable($stack, 'yes');
	}
}

// Returns the array of words in a text
function keywords_extract($text) {
    $text = strtolower($text); // to lower case
    
    $text = strip_tags($text); // Remove the php and html tags

    $text = CleanText($text); // remove all non-word characters

    $commonWordsEnglish = "'tis,'twas,a,able,about,across,after,ain't,all,almost,also,am,among,an,and,any,are,aren't," .
        "as,at,be,because,been,but,by,can,can't,cannot,could,could've,couldn't,dear,did,didn't,do,does,doesn't," .
        "don't,either,else,ever,every,for,from,get,got,had,has,hasn't,have,he,he'd,he'll,he's,her,hers,him,his," .
        "how,how'd,how'll,how's,however,i,i'd,i'll,i'm,i've,if,in,into,is,isn't,it,it's,its,just,least,let,like," .
        "likely,may,me,might,might've,mightn't,most,must,must've,mustn't,my,neither,no,nor,not,o'clock,of,off," .
        "often,on,only,or,other,our,own,rather,said,say,says,shan't,she,she'd,she'll,she's,should,should've," .
        "shouldn't,since,so,some,than,that,that'll,that's,the,their,them,then,there,there's,these,they,they'd," .
        "they'll,they're,they've,this,tis,to,too,twas,us,wants,was,wasn't,we,we'd,we'll,we're,were,weren't,what," .
        "what'd,what's,when,when,when'd,when'll,when's,where,where'd,where'll,where's,which,while,who,who'd," .
        "who'll,who's,whom,why,why'd,why'll,why's,will,with,won't,would,would've,wouldn't,yet,you,you'd,you'll,";

	$commonWordsSpanish = "ante,bajo,cabe,con,contra,desde,durante,entre,hacia,hasta,mediante,para,por,segun,sin,sobre,tras," .
		"que,los,http,esto,las,los,son,del,";

	$allCommonWords = $commonWordsEnglish . $commonWordsSpanish;
    $commonWords = explode(",", $allCommonWords); // convert to array of words
    
    foreach($commonWords as $commonWord)
    	$hashWord[$commonWord] = $commonWord;
        
    $words = preg_split("/[\s\n\r]/", $text); // Skip if it is a URL

    foreach ($words as $value) 
    {
    	// Skip if it is a URL
    	$pos = strpos($value,'//');
        if ($pos === 0) continue;
        
        if (strlen($value) < 3) continue; // Skip if word contains less than 4 digits
        
        if (array_key_exists($value, $hashWord)) continue; // Skip if it is common word

        $keywords[] = preg_replace('/[^a-zA-Z0-9#@\s].+/', '', $value);  // format word      
    }

    return $keywords;
}

// Removes all the non-word characters
function CleanText($text){
	$text = str_replace("¿", " ", $text);
	$text = str_replace("?", " ", $text);
	$text = str_replace("¡", " ", $text);
	$text = str_replace("!", " ", $text);
	$text = str_replace(":", " ", $text);
	$text = str_replace(";", " ", $text);
	$text = str_replace(",", " ", $text);
	$text = str_replace("(", " ", $text);
	$text = str_replace(")", " ", $text);
	// $text = str_replace(".", " ", $text);
	return $text;
}


//Mock function
function FakeData(){
	// $array = array(1, "hello", 1, "world", "hello");
 //    print_r(array_count_values($array));
	// return "[
	// 	['This is a test, 1], 
	// 	['Dos', 2],
	// 	['Alice', 3],
	// 	['Frank', 4],
	// 	['Floyd', 5],
	// 	['Fritz', 6]
	// 	]
	// 	";
	// return "[
 //            ['RT @Kdt_92: Stand me up balls @ColombianEng #ColombianEnglish'],
 //            ['RT @ColombianEng: To another dog with that bone! #ColombianEnglish No 64'],
 //            ['RT @croppel8: The quest for a perfect season has a chance to be done tonight. 730 @ St. Agnes. Be there. Be loud. #HT']
 //          ]";
	return "[
		['This is a test, 'This test is quite hard'], 
		['A hard test or not?', 'This was not too hard'],
		['Hard hard hard this is so hard !!!', 'For every test there is a solution. For every one']
		]
		";
}

// Formats an array to a database readable by Google Charts
function arrayToGoogleDataTable(array $theArray, $ordered) {
	
	if (!empty($theArray)) {

		// If ordered
		if ($ordered == 'true' || $ordered == 'yes' ) {
			ksort($theArray); // Order alphabetically
			arsort($theArray); // Order by value
		}

		// Variables declaration
		$i = 0;
		$last = ',';
		$data = '[';		
		$count = count($theArray);

		// Format the datatable
		foreach ($theArray as $key => $value) {
			$i++;
			if ($i == $count) {
				$last = '';
			}
			$data = $data . "['" . $key . "'," . $value . "]" . $last;
			
			// echo json_encode($value);
			// echo '<p>';
		}
		$data = $data . ']';

		return $data;
	}
	else {
		// We can't work without something to work on
		throw new IllegalArgumentException('Unable to process empty arrays');
	}
}

function IsOwnerData($word){
	include "db.php";
	//Gets the Session Variable
	//session_start();
	$idTalk = 0;
	
	if (isset($_SESSION['TalkID'])) {
		$idTalk = ($_SESSION['TalkID']);
	}

	// $idTalk = 1; // Testing Variable

	$sql = "SELECT Hashtag FROM talks WHERE ID = " . $idTalk;
	$return = false;
			
	// Getting data
	if ($result = $con->query($sql)) {
		while($row = $result->fetch_array(MYSQL_ASSOC)) {
			// Compare data
			$ActualHashtag = $row['Hashtag'];
			
			if (strtolower($ActualHashtag) == strtolower($word)) {
				$return = true;
			}
		}
		// Closing connection
		$result->close();
		mysqli_close($con);
	}
	// echo $return;
	return $return;
}

function getTalkID(){
	// Declaring variables
	$talkID = $_GET['t'];
	// Validation
	if(is_null($talkID))
		$talkID = 0;
		
	return $talkID;
}

// Formats an array to a database readable by Google Charts
function TempoarrayToGoogleDataTable(array $theArray, $ordered) {
	
	if (!empty($theArray)) {

		// If ordered
		if ($ordered == 'true' || $ordered == 'yes' ) {
			ksort($theArray); // Order alphabetically
			arsort($theArray); // Order by value
		}

		// Variables declaration
		$i = 0;
		$last = ',';
		$data = '[';		
		$count = count($theArray);

		// Format the datatable
		foreach ($theArray as $key => $value) {
			$i++;
			if ($i == $count) {
				$last = '';
			}
			$data = $data . "['" . $value . "'," . $key . "]" . $last;
			
			// echo json_encode($value);
			// echo '<p>';
		}
		$data = $data . ']';
		return $data;
	}
	else {
		// We can't work without something to work on
		throw new IllegalArgumentException('Unable to process empty arrays');
	}
}

function CleanMessage($text) {
    $text = strtolower($text); // to lower case
    $text = strip_tags($text); // Remove the php and html tags
    $text = CleanText($text); // remove all non-word characters

    $commonWordsEnglish = "'tis,'twas,a,able,about,across,after,ain't,all,almost,also,am,among,an,and,any,are,aren't," .
        "as,at,be,because,been,but,by,can,can't,cannot,could,could've,couldn't,dear,did,didn't,do,does,doesn't," .
        "don't,either,else,ever,every,for,from,get,got,had,has,hasn't,have,he,he'd,he'll,he's,her,hers,him,his," .
        "how,how'd,how'll,how's,however,i,i'd,i'll,i'm,i've,if,in,into,is,isn't,it,it's,its,just,least,let,like," .
        "likely,may,me,might,might've,mightn't,most,must,must've,mustn't,my,neither,no,nor,not,o'clock,of,off," .
        "often,on,only,or,other,our,own,rather,said,say,says,shan't,she,she'd,she'll,she's,should,should've," .
        "shouldn't,since,so,some,than,that,that'll,that's,the,their,them,then,there,there's,these,they,they'd," .
        "they'll,they're,they've,this,tis,to,too,twas,us,wants,was,wasn't,we,we'd,we'll,we're,were,weren't,what," .
        "what'd,what's,when,when,when'd,when'll,when's,where,where'd,where'll,where's,which,while,who,who'd," .
        "who'll,who's,whom,why,why'd,why'll,why's,will,with,won't,would,would've,wouldn't,yet,you,you'd,you'll,";

	$commonWordsSpanish = "ante,bajo,cabe,con,contra,desde,durante,entre,hacia,hasta,mediante,para,por,segun,sin,sobre,tras," .
		"que,los,http,esto,las,los,son,del,https,sus,quien,han";

	$allCommonWords = $commonWordsEnglish . $commonWordsSpanish;
    $commonWords = explode(",", $allCommonWords); // convert to array of words
    
    foreach($commonWords as $commonWord)
 	  	$hashWord[$commonWord] = $commonWord;

    $words = preg_split("/[\s\n\r]/", $text); // Skip if it is a URL
    $phrase = "";

    foreach ($words as $value) 
    {
    	// Skip if it is a URL
    	$pos = strpos($value,'//');
        if ($pos === 0) continue;
        
        if (strlen($value) < 3) continue; // Skip if word contains less than 4 digits
        
        if (array_key_exists($value, $hashWord)) continue; // Skip if it is common word

        if (strstr($value, '@')) continue; // Skip if its a Twitter user (@user)

		$phrase = $phrase . " " . $value;
        
        // echo $phrase;
        // echo '<p>';

        // $keywords[] = preg_replace('/[^a-zA-Z0-9#@\s].+/', '', $value);  // format word      
    }
    // echo '++++++++++++++++';
    return $phrase;
    // echo '<p>';    

    // echo json_encode($keywords);
    //     echo '<p>';


 //    return $keywords;
}


?>