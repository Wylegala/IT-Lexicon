<?php
	//start of php session
	session_start();
	require_once "connect.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>IT Lexicon</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/style.css"> <!--main css stylesheet-->
    <link rel="stylesheet" href="css/fontello.css"> <!--Fontello icons-->
    <link rel="stylesheet" href="css/bootstrap.css"> <!--additional css code based on bootstrap-->
    <link href="https://fonts.googleapis.com/css?family=Baloo+Chettan|Germania+One" rel="stylesheet"> <!--google fonts-->
	</head>
  <body>
    <div>
      <!--Page header-->
      <div id="header">
        <div class="container">
					<!--page title/logo section-->
          <div id="page_title">
            <a href="index.php">
              IT Lexicon
            </a>
          </div>
          <!--menu section-->
          <div id="menu">
            <ul class="menu_list" type="none">
              <a href="index.php">
                <li class="menu_level_1">
                  <i class="icon-home"></i>
                </li>
              </a>
              <a href="search.php">
                <li class="menu_level_1">
                  Search a Word
                </li>
              </a>
              <a href="abb.php">
                <li class="menu_level_1">
                  Abbreviations
                </li>
              </a>
              <a href="about.php">
                <li class="menu_level_1">
                  About the Lexicon
                </li>
              </a>
              <li style="clear:both;"></li>
            </ul>
          </div>
					<div id="user_box">
						<?php
							require_once "user_box.php";
						?>
					</div>
          <div style="clear:both"></div>
        </div>
      </div>
      <!--Page body-->
      <div id="content">
        <!--Search section-->
        <div id="search_section">
          <div class="container">
            <div id="search_teaser">
              <p>Do not hesitate...</p>
              <p>...unleash IT terms<br>and abbreviations now!</p>
            </div>
            <div id="search_box">
              <div id="search_title">
                IT Lexicon
              </div>
              <div id="search">
                <form action="results.php" method="post">
                  <input type="text" name="search" placeholder="Search..." maxlength="25">
                  <button type="submit">
                    <i class="icon-search"></i>
                  </button>
                  <div style="clear:both;"></div>
                </form>
              </div>
            </div>
            <div style="clear:both;"></div>
          </div>
        </div>
				<!--Popular searches section - 20 terms-->
        <div id="popular_section">
          <div class="container">
            <div class="section_title">
              The most popular searches
            </div>
            <div id="popular_terms">
              <?php
								//Open DB connection
  							$connection = @new mysqli($host, $db_user, $db_password, $db_name);
								//Error handler
								if ($connection->connect_errno!=0)
  						  {
  						    echo "Error: ".$connection->connect_errno;
  						  }
								//If connected...
  						  else
  						  {
									//DB query to get 20 the most popular terms
                  if ($result = @$connection->query("SELECT * FROM terms ORDER BY popularity DESC LIMIT 20"))
  								{
										//Count if any results
  									$count_results = $result->num_rows;
  									if($count_results>0)
  									{
											//Increment variable
                      $i = 1;
											//Fetch and display each record
                      foreach($result as $term)
                      {
                        echo "<span id='term_".$i."'>";
                          echo "<a href='results.php?search=".$term['name']."'>";
                            echo $term['name'];
                          echo "</a>";
                        echo "</span>";
												//Switch basing on $i to break line after each 4 terms
                        switch($i)
                        {
                          case 4:
                          {
                            echo "<br>";
                            break;
                          }
                          case 8:
                          {
                            echo "<br>";
                            break;
                          }
                          case 12:
                          {
                            echo "<br>";
                            break;
                          }
                          case 16:
                          {
                            echo "<br>";
                            break;
                          }
                        }
												//Increment
                        $i++;
                      }
  									}
  									else
  									{
  										echo "Database connection error";
  									}

										$result->free_result();
  								}
  								else
  								{
  									echo "Database connection error";
  								}

									$connection->close();
                }
              ?>
            </dv>
          </div>
        </div>
      </div>
      <!--Footer section-->
      <div id="footer">
        <div class="container">
          Footer placeholder
        </div>
      </div>
    </div>
  </body>
</html>
