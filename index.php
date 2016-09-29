<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>zoé - selected works</title>

    <link rel="icon" type="image/png" href="favicon.png">

    <link type='text/css' href="css/normalize.css" rel="stylesheet">
    <link type='text/css' href="css/style.css.php" rel="stylesheet">

  </head>
  <body>
    <?php
      session_start();
      // Standard variables
      $page = "zoe"; // zoe, contact, (projekte)...
      $page = $_GET["page"];
      $_SESSION["page"] = $page;

      $pagetype = "main"; // main oder project
      $pagetype = $_GET["pagetype"];
      $_SESSION["pagetype"];

      $showtext = true;
      $showtext = $_GET["showtext"];
      $_SESSION["showtext"] = $showtext;

      $prevpage = $_GET["prevpage"];
      $_SESSION["prevpage"] = $prevpage;

      $dir = 'portfolio';
      $_SESSION["dir"] = $dir;
      $scanndir = array_diff(scandir($dir), array('..', '.','.DS_Store'));

      // set background-color
      if ($pagetype == "project") {
        $colors = explode(',', file_get_contents("$dir/$page/colors.txt"));
      } else {
        $colors = explode(',', file_get_contents("colors.txt"));
      };
      $_SESSION["colors"] = $colors;

      // create menuitems
      $menuitems = array();
      $menunames = array();
      foreach ($scanndir as $pagename) {
        $txtbtnval = '+';
        $rotate = "";
        $txtbtn = true;
        $txtbtnfix = false;
        if ($pagename == $page and $showtext) {
          $txtbtnval = '+';
          $rotate = "rotate";
          $txtbtn = false;
          $txtbtnfix = true;
        }
        $pagetypemenu = "project";
        $menuitems[] = "<li><div class='menuitem hvr-wobble-skew'><a href='?page=$pagename&pagetype=$pagetypemenu&showtext=$txtbtnfix&prevpage=$page'>$pagename</a>".
                       "</div><div class="."'showtextitem $rotate'"."><a href='?page=$pagename&pagetype=$pagetypemenu&showtext=$txtbtn&prevpage=$page'>$txtbtnval</a></div></li>";
        $menunames[] = $pagename;
      };

      // create masonry
      $dirname = "$dir/$page/";
      $dirimages = glob($dirname."*.{jpg,png,gif}", GLOB_BRACE);
      $images = array();

      foreach ($dirimages as $dirimage) {
        $images[] = "<div class='item'><img src=$dirimage alt='' /></div>";
      };

      // load text
      $contenttext = file_get_contents("$dir/$page/text.txt");

      // set topmargin content
      $contentpos = array_search($page, $menunames);
      $contentmargin = ($contentpos * 25.6) + 2;
      $_SESSION["contentmargin"] = $contentmargin;

    ?>
    <div class="container">

      <!-- header -->
      <div class="header">
        <div class="headertitle hvr-wobble-skew">
          <a href="?page=zoe&pagetype=main"><h1>zoé</h1></a>
        </div>
        <div class="headersubtitle">
          <h1>selected works</h1>
        </div>
        <div class="headercontact hvr-wobble-skew">
          <a href="?page=contact&pagetype=main&showtext=1"><h1>contact</h1></a>
        </div>
        <!-- menu -->
        <div class="menu">
          <ul>
            <?php
              foreach ($menuitems as $item) {
                echo $item;
              }
            ?>
          </ul>
        </div>
        <!-- end menu -->
      </div>
      <!-- end header -->

      <!-- content -->
      <div class="content">
        <?php
          if ($page == "contact") {
            include("contact.php");
          };
        ?>
        <div class="contenttext">
          <?php
            echo $contenttext;
          ?>
        </div>
        <div class="masonry">
          <?php
            foreach ($images as $imagekey => $imagevalue) {
              echo $imagevalue;
            };
          ?>
        </div>
      </div>
      <!-- end content -->

      <!-- footer -->
      <div class="footer">
        <p> &copy; Copyright 2016</p>
      </div>
      <!-- end footer -->

    </div>
  </body>
</html>
