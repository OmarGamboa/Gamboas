<?php
	
	//session_start();
	$idTalk = 'not set';
	if (isset($_SESSION['TalkID'])) {
		$idTalk = ($_SESSION['TalkID']);
	}
	
	$idGraph = 'not set';
	if (isset($_SESSION['GraphicID'])) {
		$idGraph = ($_SESSION['GraphicID']);
	}
?>
<html>
  <head>
  	<meta http-equiv="refresh" content="30" >
    <!--Load the AJAX API-->
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script> 
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

    <link rel="stylesheet" type="text/css" href="http://visapi-gadgets.googlecode.com/svn/trunk/wordcloud/wc.css"/>
	<script type="text/javascript" src="http://visapi-gadgets.googlecode.com/svn/trunk/wordcloud/wc.js"></script>

    <script type="text/javascript">
	
		// Load the Visualization API and the piechart package.
      	google.load('visualization', '1.0', {'packages':['corechart']});
	
      	// Set a callback to run when the Google Visualization API is loaded.
      	google.setOnLoadCallback(drawChart);

		// Callback that creates and populates a data table,
		// instantiates the pie chart, passes in the data and
		// draws it.
      	function drawChart() {
	  
	    // var lastSlash = window.location.href.lastIndexOf('/');
	    // var location = window.location.href.substr(0, lastSlash);
	    
	    <?php
		if($idGraph == 1){
		  $options = "'title':'Usuarios Activos','width':1000,'height':300";
		  $ColName = "Usuario";
		  $dataColName = "Publicaciones";
		}
		elseif($idGraph == 2){
		  $options = "'title':'Palabras mas usadas','width':1000,'height':300";
		  $ColName = "Palabra";
		  $dataColName = "Total";
		}
		elseif($idGraph == 3){
		  $options = "'title':'Hashtag mas usados','width':1000,'height':300";
		  $ColName = "Hashtag";
		  $dataColName = "Total";
		}
		else{
		  $options = "'title':'Influenciadores','width':1000,'height':300";
		  $ColName = "Usuario";
		  $dataColName = "Seguidores";
		}
	    ?>

	    // Create the data table
	    var data = new google.visualization.DataTable();
	    data.addColumn('string', '<?php echo $ColName ?>');
	    data.addColumn('number', '<?php echo $dataColName ?>');
	    data.addRows(
	      <?php
			require_once "lib/TalkMessages.php";
			if($idGraph == 1){
			  echo ReturnActiveUsers();
			}
			elseif($idGraph == 2){
			  // echo ReturnFrequentWords();
			  echo ReturnMessages();
			}
			elseif($idGraph == 3){
			  echo ReturnFrequentHashtags();
			}
			else{
			  echo ReturnUsersFollowers();
			}
	      ?>
	    );
    
	    // Set chart options
	    var options = {<?php echo $options; ?>};
	    
	    <?php 
		    if($idGraph == 2){
		    	echo 
		        "var wc = new WordCloud(document.getElementById('chart_div'));
		        wc.draw(data, options);";
		    }
		    else{
			    // Instantiate and draw our chart, passing in some options.
			    echo 
			    "var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
			    chart.draw(data, options);";
		    }
	    ?>		
	}
	</script>
  
  </head>

  <body>
    <!--Div that will hold the column chart-->
    <div id="chart_div"> 
    </div>
  </body>
</html>