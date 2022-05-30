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
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    
    <style type="text/css">
        /* .wrapper{
            width: 650px;
            margin: 0 auto;
        }
        .page-header h2{
            margin-top: 0;
        }
        table tr td:last-child a{   
            margin-right: 15px;
        } */
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#myTable').DataTable();
        
            $('#myTable tbody').on( 'click', 'tr', function () {
                $(this).toggleClass('selected');
            } );
        
            $('#button').click( function () {
                var div = document.getElementById("dom-target");
                var myData = div.textContent;
                var jsonArrayData = new Array();
                for (var i = 0; i < table.rows('.selected').data().length; i++) {
                    console.log(table.rows('.selected').data()[i][0] + ' '+ myData +' \n');

                    //create a json file
                    jsonArrayData.push({
                        id: table.rows('.selected').data()[i][0],
                        grade: myData
                    });

                }
                console.log(jsonArrayData);
                //push the json data to the logic.php file [bottom line callbacks lol]
                $.ajax({
                       type: 'post',
                       url: '../logic/upgrade.php',
                       dataType: 'JSON',
                       data: {
                           source1: JSON.stringify(jsonArrayData)
                       },
                       success: function(data){
                        alert("Well I did my posting");
                           console.log("success: ",data);
                       },
                       failure: function(errMsg) {
                            console.error("error:",errMsg);
                       }
                });

                location.reload();
                return false;
                             
            });
        } );


    </script>
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
                    <div id="dom-target" style="display: none;"><?php echo $gradeView; ?></div>
                    <!-- // button to get all seletected pass them to an array -->
                    <p>You can select the pupils to upgrade to the next class by clicking on them and then press the button below.</p>
                    <button id="button">Change Grade for Selected</button><br>
                    <?php
                

                 

                    // Attempt select query execution
                    $sql = "SELECT * FROM pupil WHERE grade = '$gradeView'";
                    if($result = $mysqli->query($sql)){
                        if($result->num_rows > 0){
                            echo "<table id='myTable'  class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>DOB</th>";
                                        echo "<th>Grade</th>";
                                        echo "<th>Date Enrolled</th>";
                                        echo "<th>Active Status</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                        echo "<td>" . $row['pupilID'] . "</td>";
                                        echo "<td>" . $row['pupilName'] . "</td>";
                                        echo "<td>" . $row['dateOfBirth'] . "</td>";
                                        echo "<td>" . $row['grade'] . "</td>";
                                        echo "<td>" . $row['yearStarted'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='activeStatus.php?id=". $row['pupilID'] ."' title='Move pupil' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span> View</a>";
                                            // echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            // echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            $result->free();
                        } else{
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
</body>
</html
