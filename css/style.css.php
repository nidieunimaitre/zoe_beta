<?php

  header("Content-type: text/css; charset: UTF-8");

  session_start();
  $page = $_SESSION["page"];
  $showtext = $_SESSION["showtext"];
  $dir = $_SESSION["dir"];
  $colors = $_SESSION["colors"];
  $prevpage = $_SESSION["prevpage"];
  $contentmargin = $_SESSION["contentmargin"];

  //$colors = array("#FF00FF","#00FFFF","#FFFF00","#FF0000","#00FF00","#0000FF");
  shuffle($colors);

  $imagecols = 2;
  $imagecols = file_get_contents("../$dir/$page/spalten.txt");

  $hidetextprop = "display: none;";
  $transbgprop = "";
  if ($showtext) {
    $hidetextprop = "";
    $transbgprop = "opacity: 0.3";
    $imgblurprop = "-webkit-filter: blur(3px); \n".
                   "filter: blur(3px); \n";
  }

  // set keyframes for animation
  // backgroundanimation
  $step = (100/((count($colors)*2)+1));

  for ($i=0; $i < 2; $i++) {

    if ($i == 0) {
      echo "@-webkit-keyframes backgroundanimation { \n";
    };

    if ($i == 1) {
      echo "@keyframes backgroundanimation { \n";
    };

    if (count($colors)<=1) {
      if ($prevpage == $page) {
        echo "0% {background-color: ".$colors[0].";}\n";
        echo "100% {background-color: ".$colors[0].";}\n";
      } else {
        echo "0% {background-color: white;}\n";
        echo "100% {background-color: ".$colors[0].";}\n";
      };
    } else {
      foreach ($colors as $colornr => $value) {
        $steptemp = ($step * 2) * ($colornr+1);
        if ($colornr == 0) {
          echo "0% {background-color: white;}\n";
          echo ($step)."% {background-color: $value;}\n";
        } elseif ($colornr == (count($colors)-1)) {
          echo $steptemp-($step)."% {background-color: white;}\n";
          echo $steptemp."% {background-color: $value;}\n";
          echo $steptemp+($step)."% {background-color: white;}\n";
        } else {
          echo $steptemp-($step)."% {background-color: white;}\n";
          echo $steptemp."% {background-color: $value;}\n";
        };
      };
    };

    echo "} \n";

  };

  echo "\n";

  // fadein
  for ($i=0; $i < 2; $i++) {

    if ($i == 0) {
      echo "@-webkit-keyframes fadein { \n";
    };

    if ($i == 1) {
      echo "@keyframes fadein { \n";
    };

    echo "0% {opacity: 0.0;}\n";
    echo "100% {opacity: 1.0;}\n";

    echo "} \n";
  };

  echo "\n";
?>

/* fonts */
@font-face {
  font-family: 'suisse';
  src: url('../fonts/SuisseIntl-Medium.otf');
}

body {
  font-family: "suisse", "Helvetica Neue", Helvetica, Arial, sans-serif;
  line-height: 1.6;
  color: #000000;

  -webkit-animation-name: backgroundanimation; /* Chrome, Safari, Opera */
  -webkit-animation-duration: <?php echo count($colors)*10; ?>s; /* Chrome, Safari, Opera */
  -webkit-animation-iteration-count: <?php if (count($colors)<=1) {echo "1";} else {echo "infinite";} ?>; /* Chrome, Safari, Opera */
  -webkit-animation-fill-mode: forwards;
  animation-name: backgroundanimation;
  animation-duration: <?php echo count($colors)*10; ?>s;
  animation-iteration-count: <?php if (count($colors)<=1) {echo "1";} else {echo "infinite";} ?>;
  animation-fill-mode: forwards;
}

/* links */
a, a:focus {
  color: #000000;
  text-decoration: none;
}
a:hover {
  /*text-decoration: underline;
  color: transparent;
  text-shadow: 0 0 5px rgba(0,0,0,0.5);*/
}

h1, h2, h3, h4, h5, h6 {
  font-family: inherit;
  font-weight: 500;
  line-height: 1.0;
  color: inherit;
  margin-top: 5px;
  margin-bottom: 5px;
}

p {
  margin-top: 0;
  margin-bottom: 0;
}

.contactform {
  margin-right: 0;
  opacity: 0.9;
  overflow: hidden;
}
.contactform textarea {
  height: 350px;
  width: 100%;
  resize: none;
  background-color: inherit;
  border: 0 none;
  overflow: hidden;
}
.contactform input[type=text] {
  padding: 0;
  margin-top: 0;
  height: 19.6px;
  width: 50%;
  background-color: inherit;
  border: 0 none;
}
.contactform input[type=submit] {
  width: 10%;
  border: 0 none;
  background-color: inherit;
  text-align: left;
  margin-left: 0;
  padding-left: 0;
}

/* inline-block width fix */
div {
  margin-right: -4px;
}

.container {
  width: 95%;
  margin-left: 2.5%;  /* (100% - 95%) / 2 = 2.5%  */
  overflow: auto;
}

.header {
  position: fixed;
  width: 95%;
  top: 0;
}

.headertitle {
  width: 20%;
  display: inline-block;
}

.headersubtitle {
  width: 40%;
  display: inline-block;
}

.headercontact {
  width: 40%;
  display: inline-block;
  text-align: right;
}

.menu {
  position: fixed;
  width: 20%;
  margin-top: 10px;
}

.menu ul {
  margin: 0;
  padding: 0;
  list-style: none;
}

.menuitem {
  display: inline-block;
  min-width: 110px;
}

.showtextitem {
  display: inline-block;
  width: 5%;
  text-align: center;
}

.rotate {
  -webkit-transform: rotate(45deg);
  transform: rotate(45deg);
}

.content {
  display: inline-block;
  margin-left: 20%;
  margin-top: <?php echo $contentmargin+52; ?>px;
  width: 80%;
}

.contenttext {
  position: fixed;
  margin-right: 2.5%;
  margin-left: 2px;
  z-index: 1000;
  <?php echo $hidetextprop; ?>
  <?php if ($showtext): ?>
    -webkit-animation-name: fadein;
    -webkit-animation-duration: 2s;
    -webkit-animation-fill-mode: forwards;

    animation-name: fadein;
    animation-duration: 2s;
    animation-fill-mode: forwards;
  <?php endif; ?>

}

.masonry { /* Masonry container */
  -webkit-column-count: <?php echo $imagecols; ?>; /* Chrome, Safari, Opera */
  -moz-column-count: <?php echo $imagecols; ?>; /* Firefox */
  column-count: <?php echo $imagecols; ?>;

  -webkit-column-gap: 1px; /* Chrome, Safari, Opera */
  -moz-column-gap: 1px; /* Firefox */
  column-gap: 1px;

  <?php if ($showtext): ?>
    margin-right: 3px;
  <?php endif; ?>

  margin-top: 5px;
  z-index: 900;

  <?php echo $imgblurprop; ?>
  <?php echo $transbgprop; ?>

}

.item { /* Masonry bricks or child elements */
  display: inline-block;
  width: 100%;
  margin-bottom: 0px;
  margin-top: -5px;

<?php if (!$showtext): ?>
  -webkit-animation-name: fadein;
  -webkit-animation-duration: 2s;
  -webkit-animation-fill-mode: forwards;

  animation-name: fadein;
  animation-duration: 2s;
  animation-fill-mode: forwards;
<?php endif; ?>

}

.item img {
  width: 100%;
}

.footer {
  font-size: 80%;
  position: fixed;
  bottom: 4px;
}

/* responsive */
@media only screen and (max-width: 768px) {

  .header {
    position: relative;
    width: 100%;
  }
  .headertitle {
    width: 100%;
  }
  .headersubtitle {
    width: 100%;
  }
  .headercontact {
    width: 100%;
    text-align: left;
  }

  .menu {
    position: relative;
    width: 100%;
  }
  .menuitem {
    width: 94%;
  }
  .showtextitem {
    width: 6%;
  }

  .content {
    width: 97.5%;
    margin-left: 0;
    margin-top: 15px;
  }
  .contenttext {
    margin-right: 5%;
  }
  .masonry { /* Masonry container */
    -webkit-column-count: 1; /* Chrome, Safari, Opera */
    -moz-column-count:1; /* Firefox */
    column-count: 1;

    <?php if ($showtext): ?>
      margin-left: 3px;
    <?php endif; ?>
  }

  .footer {
    position: relative;
    width: 97.5%;
  }

};

/* Wobble Skew */
@-webkit-keyframes hvr-wobble-skew {
  16.65% {
    -webkit-transform: skew(-12deg);
    transform: skew(-12deg);
  }

  33.3% {
    -webkit-transform: skew(10deg);
    transform: skew(10deg);
  }

  49.95% {
    -webkit-transform: skew(-6deg);
    transform: skew(-6deg);
  }

  66.6% {
    -webkit-transform: skew(4deg);
    transform: skew(4deg);
  }

  83.25% {
    -webkit-transform: skew(-2deg);
    transform: skew(-2deg);
  }

  100% {
    -webkit-transform: skew(0);
    transform: skew(0);
  }
}

@keyframes hvr-wobble-skew {
  16.65% {
    -webkit-transform: skew(-12deg);
    transform: skew(-12deg);
  }

  33.3% {
    -webkit-transform: skew(10deg);
    transform: skew(10deg);
  }

  49.95% {
    -webkit-transform: skew(-6deg);
    transform: skew(-6deg);
  }

  66.6% {
    -webkit-transform: skew(4deg);
    transform: skew(4deg);
  }

  83.25% {
    -webkit-transform: skew(-2deg);
    transform: skew(-2deg);
  }

  100% {
    -webkit-transform: skew(0);
    transform: skew(0);
  }
}

.hvr-wobble-skew {
  -webkit-transform: translateZ(0);
  transform: translateZ(0);
  box-shadow: 0 0 1px rgba(0, 0, 0, 0);
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  -moz-osx-font-smoothing: grayscale;
}
.hvr-wobble-skew:hover, .hvr-wobble-skew:focus, .hvr-wobble-skew:active {
  -webkit-animation-name: hvr-wobble-skew;
  animation-name: hvr-wobble-skew;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-timing-function: ease-in-out;
  animation-timing-function: ease-in-out;
  -webkit-animation-iteration-count: 1;
  animation-iteration-count: 1;
}
