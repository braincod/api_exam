<?php
    // Include config file
    require_once "../includes/config.php";
                    
    //Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: ../index.php");
    exit;
}
    //Get the grade being viewed

    $gradeView = $_GET['grade'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    

</head>
<body>
        <?php 
        require_once '../includes/navbar_header.php';
        ?>
        
        <?php
            //show a session and refresh the screen
            if(isset($_SESSION['upgradeMessage'])){
                echo '<p class="alert alert-success a-flex flex-row">'.$_SESSION['upgradeMessage'].'</p>';
                unset($_SESSION['upgradeMessage']);
                header('Refresh: 1; URL=move.php?grade='.$gradeView);
            }
        ?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Pupil Details</h2>
                        <!-- <a href="create.php" class="btn btn-success pull-right">Add New Employee</a> -->
                    </div>

                    <!-- Pass the php variable to dom-target, this is a simple way to convert php to javascript variables -->
                   

                     <h2>Large Modal</h2>
                      <!-- Trigger the modal with a button -->
                      <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Large Modal</button>

                      <!-- Modal -->
                      <div class="modal fade" id="myModal" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Modal Header</h4>
                            </div>
                            <div class="modal-body">
                              <p>This is a large modal.</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>






                    <div id="dom-target" style="display: none;"><?php echo $gradeView; ?></div>
                    <!-- // button to get all seletected pass them to an array -->
                    <p>You can select the pupils to upgrade to the next class by clicking on them and then press the button below.</p>
                    <button id="button">Change Grade for Selected</button><br>
                    <?php
                

                 

                    // Attempt select query execution
                    $sql = "SELECT * FROM pupil WHERE grade = '$gradeView'";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                        //Start the form
                        echo '<form action="../logic/upgrade2.php" method="POST" >';
                        echo '<input  type="hidden" name="classID"" value="'.$gradeView.'" hidden class="form-control" />';
                         echo '<div class="row">
                           <div class="col-md-4 col-xs-4">
                                    <div class="input-group">
                                        <label>Pupil Name</label>
                                    </div>
                                </div> 
                                <div class="col-md-4 col-xs-4">
                                    <div class="input-group">
                                            <label>Status</label>
                                    </div>
                               </div> 
                                
                                  </div>';
                        $i=0;
                        $counter = 1;
                        while ($row = $result->fetch_array()) {
                            # code...

                            $pupil_name = $row['pupilName'];
                            $pupil_id = $row['pupilID'];
                            echo '<div class="row">
                            <input  type="text" hidden="" name="pupil_id[]"  value="'.$pupil_id.'"  class="form-control" />
                            <label>'.$counter++.'</label>
                            <input  typw="text"hidden name="class_id"  value="'.$gradeView.'" hidden" />
                                    <div class="col-md-4 col-xs-4">
                                        <div class="input-group">
                                            <input type="text" readonly  style="width: 100px"  name="pupil_name[]"" value="'.$pupil_name.'" class="form-control" />
                                        </div>
                                    </div> 

                                    <div class="col-md-4 col-xs-4">
                                        <div class="input-group">
                                            <select class="form-control" name="select_status[]">
                                                <option value="uppergrade" id="uppergrade">Move to Grade</option>
                                                <option id="remain" value="remain">Remain</option>
                                            </select>
                                        </div>
                                    </div>   
                                    </div><br>  ';
                                    $i++;
                        } // End of while loop

                        echo '  <br>
                                <input name="total_num" value="'.$i.'" hidden />
                                <input class="btn btn-success" type="submit" name="submit" value="Move"/>
                                </form>
                        '   ;
                    }else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    $mysqli->close();
                    ?>
                </div>
            </div>        
        </div>
    </div>
     <script type="text/javascript">
                        $('#myModal').on('shown.bs.modal', function () {
                          $('#myInput').trigger('focus')
                        })
                    </script>
</body>
</html
