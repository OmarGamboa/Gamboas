<html>
  <head>
    <link rel="stylesheet" type="text/css" href="http://visapi-gadgets.googlecode.com/svn/trunk/wordcloud/wc.css"/>
    <script type="text/javascript" src="http://visapi-gadgets.googlecode.com/svn/trunk/wordcloud/wc.js"></script>
    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  </head>
  <body>
    <div id="wcdiv"></div>
    <script type="text/javascript">
      google.load("visualization", "1");
      google.setOnLoadCallback(draw);
      function draw() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'colname');
        data.addColumn('number', 'some');
        data.addRows(
          <?php 
          // require_once "lib/TalkMessages.php";
          // echo ReturnMessages();

          ?>
          
          [
            ['RT @Kdt_92: Stand me up balls @ColombianEng #ColombianEnglish', 2],
            ['RT @ColombianEng: To another dog with that bone! #ColombianEnglish No 64', 2],
            ['RT @croppel8: The quest for a perfect season has a chance to be done tonight. 730 @ St. Agnes. Be there. Be loud. #HT', 1]
          ]
        );
        
        // data.addColumn('string', 'Text1');
        // data.addColumn('number', 'seguidores');
        // data.addRows(3);
        // data.setCell(0, 0, 'This is a test');
        // data.setCell(1, 0, 'A hard test or not? La semana pasada vi varios de mis amigo');
        // data.setCell(2, 0, 'Hard hard hard this is so hard, La semana pasada vi como varios de mis amigo !!!');

        // data.setCell(0, 1, '1111123');
        // data.setCell(1, 1, '543');
        // data.setCell(2, 1, '444');



        var outputDiv = document.getElementById('wcdiv');
        var wc = new WordCloud(outputDiv);
        wc.draw(data, null);
      }
    </script>
  </body>
</html>