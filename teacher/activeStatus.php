<?php
    // Include config file
    require_once "../includes/config.php";
    
    //check if the id was set

    if(isset($_GET['id'])){
        $pupilID = $_GET['id'];
        $pupilName = '';
        $parentName = '';
        $parentPhoneNumber = '';
        $grade = '';

        $SQL = "SELECT * FROM pupil, parent WHERE pupil.pupilID = '$pupilID' AND pupil.parentID = parent.parentID";
        $results = mysqli_query($mysqli, $SQL);

        if(mysqli_num_rows($results) > 0){
            while($rows = mysqli_fetch_assoc($results)){
                $pupilName = $rows['pupilName'];
                $parentName = $rows['parentName'];
                $parentPhoneNumber = $rows['phoneNumber'];
                $grade = $rows['grade'];
            }
        }

    }

    if(isset($_POST['submit'])){

        $reasonTitle = $_POST['activeStatus'];
        $reasonDetails = $_POST['reasonDetails'];
        $pupilID = $_POST['pupilID'];
        $grade = $_POST['grade'];

        if($reasonTitle == 'active'){
            $reasonTitle = $_POST['reason'];


        }
        //else if it is any of the other options
        else {

            if(updateAndInsert($reasonTitle, $reasonDetails, $pupilID, $mysqli, $grade)){
                $_SESSION['reasonAdded'] =  "Recorded successfully added";
            }else {
                $_SESSION['reasonAddedFailed'] =  "Recorded successfully added";
            }
        }

        
        
    }

    function updateAndInsert($reasonTitle, $reasonDetails, $pupilID, $mysqli, $grade){
        //Insert into reason and tracking table

        $SQLINSERT = "INSERT INTO reasons(`pupilID`, `reason`, `reasonDetails`) VALUES(?, ?, ?)";
        if($stmt = $mysqli->prepare($SQLINSERT)){
            $stmt->bind_param('iss', $pupilID, $reasonTitle, $reasonDetails);

            if($stmt->execute()){
                $timestamp = date("Y-m-d H:i:s"); 
                    // Record track for the given year
                // Replace $timestamp with a single year in production
                $recordTracker = "INSERT INTO tracking(pupilID, grade, dateModified) VALUES ('$pupilID', '$grade', '$timestamp') ";
                if (mysqli_query($mysqli, $recordTracker)){
                    
                    $update = "UPDATE pupil SET grade = '$grade', activeStatus='$reasonTitle', dateModified = '$timestamp' WHERE pupilID = '$pupilID'";
                    if(mysqli_query($mysqli, $update))
                        return true;
                    else
                        return false;
                }else 
                    return false;            
            }
            else 
                return false;
        }
    }


?>
<?php 
  require_once '../includes/navbar_header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Active Status Modification </title>
<!-- Meta Tags for Bootstrap 4 -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap 4 CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 50%; padding: 10px; margin-left: 20%; margin-top: 1% }
</style>
</head>
<body>
<div class="container">
    <div class="wrapper">
        <h2>Change Active Status</h2>

        <?php
            if(isset($_SESSION['reasonAdded'])){
                echo '<p class="alert alert-success"> '.$_SESSION['reasonAdded'].'</p>';
                unset($_SESSION['reasonAdded']);
            } else if(isset($_SESSION['reasonAddedFailed'])){
                echo '<p class="alert alert-warning"> '.$_SESSION['reasonAddedFailed'].'</p>';
                unset($_SESSION['reasonAddedFailed']);
            }
        ?>
       
        <form class="form-group" action="" method="POST">
            <h4> Active Status Modifications </h4>

			<div class="col-sm-12">
            <input text="text" name="pupilID" value="<?php echo  $pupilID; ?>" hidden />
            <input text="text" name="grade" value="<?php echo  $grade; ?>" hidden />
                <label>Pupil Name</label>
				<input type="text" name="fullName" readonly value="<?php echo $pupilName; ?>" placeholder="Pupil" class="form-control">

			</div><br>
            <div class="col-sm-12">
                <label>Grade</label>
				<input type="text" readonly value="<?php echo $grade; ?>" placeholder="Grade" class="form-control">

			</div><br>
			<div class="col-sm-12">
               <label>Parent Name</label>
				<input type="text" name="parentName" readonly value="<?php echo $parentName; ?>" placeholder="Parent Name" class="form-control">

			</div> 
			<br>

			<div class="col-sm-12">
            <label>Parent Contact Number</label>

				<input type="text" name="phoneNumber" readonly value="<?php echo $parentPhoneNumber; ?>" placeholder="Phone Number" class="form-control">

			</div>

			<br><br><br>
            <div class="col-sm-12">
            <label>Active Status</label>

                <select name="activeStatus" class="form-control" onChange="accountSelect(this)">
                        <option id="select">
                            ~Select~
                        </option>
                        <option value="active">Active</option>
                        <option value="suspended">
                            Suspended
                        </option>
                        <option value="transfered">
                            Transfered
                        </option>
                        <option value="dropout">
                            Drop Out
                        </option>
                        <option value="teen_pregnancies">
                            Teen Pregnancies
                        </option>
                </select>	
			</div><br>
           
            <div class="col-sm-12" id="hidden_div" style="display: none;">
            <label>Reason</label>
                    <input type="text" name="reason" placeholder="reason why the pupil is still in the same grade"  class="form-control"/>
                    <br>
            </div>
         
            <div class="col-sm-9">
                <textarea name="reasonDetails" placeholder="Reason  in details" required class="form-control"></textarea>
            </div>

            <br>
            <div class="col-sm-6">
            <input class="btn btn-primary" type="submit" name="submit" value="submit" />
            </div>
        </form>
    </div>
</div>

<script>
 function accountSelect(select) {
            // document.getElementById('hidden_div');
            if (select.value == 'active' || select.value == 'Active') {
                    document.getElementById('hidden_div').style.display = "block";
                  
            } else  {
                    document.getElementById('hidden_div').style.display = "none";
            }
 }
</script>
</body>
</html>