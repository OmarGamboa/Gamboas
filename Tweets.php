<!DOCTYPE html>
<html ng-app="">
<head>
    <link rel="stylesheet" href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script src= "http://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>   

    <style type="text/css">
        body{ font:20px/1.3 arial; }
        
        #mainText{ width:50%; xmin-width:500px; margin:50px auto; }
        
        word{ display:inline-block; }
        
        a letter{ color:inherit; }
        letter{ display:inline-block; white-space:pre; background:none; transition:.4s; }
        letter.initial{ opacity:0; text-shadow:0 0 9px; color:#FFF; -webkit-transform:scale(8); -webkit-transform-origin:150% 50%; transform:scale(8); transform-origin:150% 50%; }
            
        .credit{ position:absolute; bottom:10px; left:10px; padding:10px 20px; color:#777; font-size:11px; text-align:center; background:#EEE; border-radius:10px;  }
    </style>
<title>Tweets</title>

</head>
<div class="container">
<body>
<?php include_once("lib/analyticstracking.php") ?>
<h1>#ColombianEnglish</h1>
    <div id='mainText'>
        
        <p>RT @ColombianEng: And with that mouth you drink milk, mijita? #ColombianEnglish http://t.co/Y53TA2V5FR</p>
    </div>
<!--    
    <footer class='credit'>
        <span>A demo by <em>Yair Even-Or</em></span><br />
        <a href='http://dropthebit.com' title='cool client-side stuff'>dropthebit.com</a>
    </footer>
-->
    <script src="js/letterer.js"></script>
    <script>
        var lettersContainer = document.getElementById('mainText'),
            letters, 
            delay = 200,
            delayJump = 33,
            totalLetters;
        
        // Break to letters
        letterer( lettersContainer );
        // get all "letter" elements
        
        letters = lettersContainer.getElementsByTagName('letter');
        totalLetters = letters.length;
        
        for( var i=0; i < totalLetters; i++ ){
            doTimer(letters[i], delay);
            delay += delayJump;
            // if the letter is a "space" then pause for a little more, to have some delay between words 
            if( letters[i].innerHTML == ' ' )
                delay += delayJump * 3;
        }
        
        function doTimer(letter, delay){
            setTimeout(function(){ 
                letter.removeAttribute('class');
            }, delay);
        }
    </script>
</body>
</html>

