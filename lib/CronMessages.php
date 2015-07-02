<?php
//********************************************************************//
// THIS FILE CONTAINS FUNCTIONS TO ...
// FEB 20, 2015
//********************************************************************//

include "db.php";

$sql = 'SELECT hashtag, twitter_account FROM talks WHERE (now() BETWEEN start_date AND end_date)';
$url = 'getTWMessages.php';

// Getting data
if ($result = $con->query($sql)) {

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
        $params = '?h=' . $row['hashtag'] . '&ta=' . $row['twitter_account'];
        echo $url . $params . ' --- ';
    }
}
$result->close();

// Closing connection
mysqli_close($con);

?>