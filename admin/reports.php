<?php
  // Include config file
  
//Check if the user is logged in, if not then redirect him to login page
require_once '../connection.php';
    require_once '../function.php';
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
    exit;
}

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


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    
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
        $(document).ready(function(){
            // $('[data-toggle="tooltip"]').tooltip();,
            $('#myTable').DataTable();
        });
    </script>
</head>
<body>
<?php
require_once '../navbar_header.php';

?>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
               
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Report Types</strong>
                    </div>
                    <div class="card-body">

                    <form action="generate.php" method="POST"> 
                        <div class="col-sm-12">
                            <label>Report Types</label>
                            <select class="form-control" name="reportType" onChange="reportSelect(this)">
                                <option id="summaryReport" value="summaryReport"> summary</option>
                                <option id="allPupils" value="allPupils"> All Pupils</option>
                                <option id="inTake" value="inTake"> All Pupils in an Intake </option>
                                <option id="district" value="District">schools by district</option>
                              <!--    <option id="yearAndGrade" value="yearAndGrade"> </option>--->
                                <option id="complex" value="complex"> Pupil Performance By</option>
 <!-- 
                                <option id="endofyear" value="endofyear"> </option>

                                <!-- <option id="singlePupil" value="singlePupil">Single Pupil Tracking</option> -->
                                
                            </select>
                        </div>

                        <div class="col-sm-12" id="hidden_grade" style="display: none;">
                        <label>inTake </label>
                        <select class="form-control" name="pupil_intake" >
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                                
                        </select>
                    </div> 

                    <div class="col-sm-12" id="hidden_year" style="display: none;">
                        <label>Year Between</label><br>
                        <label class="control-label mb-1">From </label>
                        <select class="form-control" name="startYear" >
                           <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                                
                                
                        </select>  
                        <label class="control-label mb-1">To</label>
   
                         <select class="form-control" name="endYear" >
                            <option value="2014">2014</option>
                            <option value="2015">2015</option>
                            <option value="2016">2016</option>
                            <option value="2017">2017</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                                
                            
                                
                        </select>
                    </div>
                        <br>

                        <div class="col-sm-12" id="hidden_reason" style="display: none;">
                        <label>Reason Type </label>
                        <select class="form-control" name="reasonType" >
                            <option value="passed">Pass</option>
                            <option value="failed">Fail</option>
                            <option value="subjects">intake</option>
                            <option value="school">Province</option>                               
                        </select>
                    </div>  

                    <div class="col-sm-12" id="hidden_individual" style="display: none;">
                      <!--Add php to get all Students from the database  -->
                      <?php

                        $SQLi = "SELECT * FROM pupils_accounts ";

                        if($results = $db_link->query($SQLi)){
                            if($results->num_rows > 0){
                                echo '<label>Select Pupil</label>
                                        <select class="form-control select2" style="width: 100%">';
                                
                                while($row = $results->fetch_array()){
                                   echo '   <option>Select</option> 
                                            <option value="'.$row['pupil_id'].','.$row['pupil_name'].','.$row['pupil_intake'].'"> ID: '
                                            .$row['pupil_id'].' Name: '.$row['pupil_name'].' Grade: '.$row['pupil_intake'].
                                            '</option> 
                                           ';
                                }
                                echo '</select>';
                        }
                    }

                      ?>
                    </div><br>
                        <input type="submit" value="submit"/>
                    </form>


                    </div>
                </div>
              
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Pupil Details</h2>
                        <!-- <a href="create.php" class="btn btn-success pull-right">Add New Employee</a> -->
                    </div>
                    <?php
                   
                    // Attempt select query execution
                    $sql = "SELECT pupil_id,pupil_name,pupil_intake,school_center,school_name FROM pupils_accounts,schools WHERE pupil_school=school_center ORDER BY pupils_accounts.pupil_intake ASC";
                    
                    if($result = $db_link->query($sql)){
                        if($result->num_rows > 0){
                            echo "<table id='myTable'  class='table table-bordered table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>pupil ID</th>";
                                        echo "<th>Pupil Name</th>";
                                        echo "<th>Intake</th>";
                                        echo "<th>School Center</th>";
                                        echo "<th>School Name</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = $result->fetch_array()){
                                    echo "<tr>";
                                        echo "<td>" . $row['pupil_id'] . "</td>";
                                        echo "<td>" . $row['pupil_name'] . "</td>";
                                        echo "<td>" . $row['pupil_intake'] . "</td>";
                                        echo "<td>" . $row['school_center'] . "</td>";
                                        echo "<td>" . $row['school_name'] . "</td>";
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['pupil_id'] ."' title='View Record' data-toggle='tooltip'><span class='glyphicon glyphicon-eye-open'></span></a>";
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
                        echo "ERROR: Could not able to execute $sql. " . $db_link->error;
                    }
                    
                    // Close connection
                    $db_link->close();
                    ?>
                </div>
            </div>        
        </div>
    </div>

    <!-- SCRIPT -->
    <script>
        function reportSelect(select) {
            if(select.value == 'inTake' || select.value == 'All Pupils in an inTake'){
                document.getElementById('hidden_grade').style.display = "block";
                document.getElementById('hidden_year').style.display = "none";
                document.getElementById('hidden_reason').style.display = "none";
                document.getElementById('hidden_individual').style.display = "none";

                
            }else if(select.value == 'yearAndGrade' || select.value == 'All Pupils in'){
                document.getElementById('hidden_grade').style.display = "block";
                document.getElementById('hidden_year').style.display = "block";
                document.getElementById('hidden_reason').style.display = "none";
                document.getElementById('hidden_individual').style.display = "none";


            }else if(select.value == 'complex' || select.value == 'All Pupils that are'){
                document.getElementById('hidden_grade').style.display = "none";
                document.getElementById('hidden_year').style.display = "none";
                document.getElementById('hidden_reason').style.display = "block";
                document.getElementById('hidden_individual').style.display = "none";


            }else if(select.value == 'singlePupil' || select.value == 'Single Pupil Tracking'){
                document.getElementById('hidden_grade').style.display = "none";
                document.getElementById('hidden_year').style.display = "none";
                document.getElementById('hidden_reason').style.display = "none";
                document.getElementById('hidden_individual').style.display = "block";

            }else {
                document.getElementById('hidden_grade').style.display = "none";
                document.getElementById('hidden_year').style.display = "none";
                document.getElementById('hidden_reason').style.display = "none";
                document.getElementById('hidden_individual').style.display = "none";

            }
        }
    
        $('.select2').select2();
    </script>

</body>
</html>