<?php
    require_once('db_connect.php'); //connect to database

    $name = $_GET['name'];
    $query = "select * from users where name='" . $name . "'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);
    
    $query = "select name from users where name<>'" . $row['name'] . "'";
    $result = mysqli_query($link,$query);

    if(isset($_POST['transfer'])) {
        if($_POST['credits_tr'] > $row['credit']) {
            echo "Credits transferred cannot be more than " . $row['credit'] . "<br>";
        }

        else {
            $query = "update users set credit=credit-" . $_POST['credits_tr'] . " where name='" . $row['name'] . "'";
            mysqli_query($link,$query);

            $query = "update users set credit=credit+" . $_POST['credits_tr'] . " where name='" . $_POST['to_user'] . "'";
            mysqli_query($link,$query);

            $query = "insert into transfers values('" . $row['name'] . "','" . $_POST['to_user'] . "'," . $_POST['credits_tr'] . ")";
            mysqli_query($link,$query);

            header("Location: users.php");
        }
    }
?>

<html>
	<head>
        <title>Transfer Credits page</title>
        <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
      </head>
  <body>
    	<div class ="add">
    	<center>
    		<big>
        <a href="users.php"><button type="button" class="btn btn-success">BACK</button></a>
        <br><br>
        user name is:  <?php echo $row['name'] ?>,
        <br>
        current credits  : <?php echo $row['credit'] ?>,
        <br>
        users email :  <?php echo $row['email'] ?>.
        <br>
        <br><br>
            </big>
        </center>
        <form action="#" method="post">
        	<center>
            
                <legend>Transfer your credits to</legend>
               Enter your Credits: <input type="number" name="credits_tr" min =0 value=1 required>
                <br><br>
                credits to user: <select name="to_user" required>
                    <option value =""></option>

                <?php
                        while($tname = mysqli_fetch_array($result)) {
                            echo "<option value='" . $tname['name'] . "'>" . $tname['name'] . "</option>";
                        }
                ?>

                </select>
                <br>
            
            <br>
        </center>
            <center>
            <input type="submit" name="transfer" value="Transfer">
        </center>
        </form>
        </head>
    <style>
       body {
			background-image: url(spk2.jpg);
			 background-repeat: no-repeat;
			background-size: 100% 100%;
			background-position: center;
			height: 100vh;
	    font-family: Arial, Helvetica, sans-serif;
        }
        .add
        {
        	color: white;
        }
     </style>
 </div>
    </body>
</html>
