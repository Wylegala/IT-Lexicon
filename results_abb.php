<?php
	session_start();

	//Check if anybody used search functionality. If not, redirect user back to index.php
	if (!(isset($_POST['search']) || isset($_GET['search'])))
	{
		header('Location: index.php');
		exit();
	}
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
          <div id="page_title"> <!--page title/logo section-->
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
			<div id="results">
				<div class="container">
					<?php
						//open DB connection
						$connection = @new mysqli($host, $db_user, $db_password, $db_name);
						if ($connection->connect_errno!=0)
						{
							//Error handler in case of unsuccessfull connection
							echo "Error: ".$connection->connect_errno;
							exit();
						}
						else
						{
							//Defining $search that will be used later on to refine data from DB
							if(isset($_POST['search']))
							{
								$search = $_POST['search'];
							}
							elseif(isset($_GET['search']))
							{
								$search = $_GET['search'];
							}

							//Sanitization of entered phrase
							$search = htmlentities($search, ENT_QUOTES, "UTF-8");

							//DB query, search for mentioned abb
							if ($result = @$connection->query(
							sprintf("SELECT * FROM abb WHERE name='%s'",
							mysqli_real_escape_string($connection,$search))))
							{
								//Count and verify if any results
								$count_results = $result->num_rows;
								if($count_results>0)
								{
									//Get and display the abb
									$abb = $result->fetch_assoc();

									echo "<div class='result_name'>".$abb['name']."</div>";
									echo "<div class='result_desc'>".$abb['description']."</div>";

									//Increment popularity for given abb
									$id = $abb['id_abb'];
									$connection->query("UPDATE abb SET popularity=popularity+1 WHERE id_abb='$id'");
								}
								else
								{
									//Error handler - cannot find abb in the DB
									echo "<p class='term_name' style='font-size: 2rem;'>".$search." cannot be found. Please, try another abbreviation.</p>";
								}

								$result->free_result();
							}
							else
							{
								header('Location: index.php');
								exit();
							}

							$connection->close();
						}
					?>
				</div>
			</div>
      <!--Footer section-->
      <div id="footer" class="footer_fixed">
        <div class="container">
          Footer placeholder
        </div>
      </div>
    </div>
  </body>
</html>
