<?php
  // Include config file
  require_once "../connection.php";
/**
 * A report generate 
 * 
 */
$getParam = $_POST['reportType'];

//import the pdf
require './pdfGen/fpdf.php';
$pdf = new FPDF('P','mm','A3');
$pdf->SetTitle('FPDF tutorial'); 
//add new page

$pdf->AddPage();

//set up the font

$pdf->SetFont('Arial','B',14);
// echo $getParam;
if($getParam == 'allPupils'){
    
    // $pdf->
    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(270,5,'All pupils available s  ',0,0,'C');
     
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(290,5,'Pupil RMS ',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(290,5,'All Pupils REPORT in all intakes(2014-2022)',0,0,'C');
    
    $pdf->Ln();
    $pdf->Ln();
    //Query the results

    $SQL = "SELECT pupil_id,pupil_name,pupil_intake,school_center,school_name FROM pupils_accounts,schools WHERE pupil_school=school_center ORDER BY pupils_accounts.pupil_intake ASC";

    $results = mysqli_query($db_link, $SQL);

    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(60 ,5,'Pupil ID',1,0);
    $pdf->Cell(40 ,5,'Full Name',1,0);
    $pdf->Cell(50 ,5,'Year(intake)',1,0);
    $pdf->Cell(60,5,'School Center',1,0);
    $pdf->Cell(60,5,'School Name',1,1);
   // $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line



    if(mysqli_num_rows($results) > 0){

        while($getAllPupils = mysqli_fetch_assoc($results)){

            $pdf->Cell(60, 5, ''.$getAllPupils['pupil_id'],1,0);
            $pdf->Cell(40, 5, ''.$getAllPupils['pupil_name'],1,0);
            $pdf->Cell(50, 5, ''.$getAllPupils['pupil_intake'],1,0);
            $pdf->Cell(60, 5, ''.$getAllPupils['school_center'],1,0);
            $pdf->Cell(60, 5, ''.$getAllPupils['school_name'],1,0);
            $pdf->Ln(); //print next row on a new line

        }
    }
$pdf->Output();
// summary report starts here
    } else if($getParam == 'summaryReport'){

    // $pdf->
    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    $pdf->Cell(270,5,'Summary Report  ',0,0,'C');
     
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(290,5,'Pupil RMS ',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(290,5,'Summary Report',0,0,'C');
    
    $pdf->Ln();
    $pdf->Ln();
    //Query the results

    $SQL = "SELECT COUNT(pupil_id) as pupil_id, pupil_gender FROM `pupils_accounts` GROUP BY pupil_gender ORDER BY COUNT(pupil_id) DESC";

    $results = mysqli_query($db_link, $SQL);
    

    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(60 ,5,'Total',1,0);
    $pdf->Cell(40 ,5,'Gender',1,1);
    //$pdf->Cell(50 ,5,'Year(intake)',1,0);
    //$pdf->Cell(60,5,'School Center',1,0);
    //$pdf->Cell(60,5,'School Name',1,0);
   // $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line

    

   if(mysqli_num_rows($results) > 0){
    
            while($getAllPupils = mysqli_fetch_assoc($results)){
        
            $pdf->Cell(60, 5, ''.$getAllPupils['pupil_id'],1,0);
            $pdf->Cell(40, 5, ''.$getAllPupils['pupil_gender'],1,0);
           $pdf->Ln(); //print next row on a new line

        }
    }

    $pdf->Output();
//end
} else if ($getParam == 'inTake'){

    $pupil_intake = $_POST['pupil_intake'];
        // $pdf->
        $pdf->Ln();
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(270,5,'All PUPILS PER INTAKE '.$pupil_intake.' REPORT ',0,0,'R');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(290,5,'Pupil RMS ',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(290,5,'All PUPILS PER INTAKE '.$pupil_intake.' REPORT ',0,0,'C');
        
        $pdf->Ln();
        $pdf->Ln();
        //Query the results
    
        $SQL = "SELECT pupil_id,pupil_name,pupil_intake ,school_center,school_name,school_location FROM pupils_accounts,schools WHERE pupils_accounts.pupil_school = schools.school_center AND pupils_accounts.pupil_intake ='$pupil_intake' ORDER BY pupils_accounts.pupil_intake ASC";

        $results = mysqli_query($db_link, $SQL);
    
        $pdf->SetFont('Arial','B',12);
    
        $pdf->Cell(40 ,5,'Pupil Id',1,0);
        $pdf->Cell(40 ,5,'Full Names',1,0);
        $pdf->Cell(30 ,5,'Pupil inTake',1,0);
        $pdf->Cell(50,5,'School Center',1,0);
        $pdf->Cell(60,5,'School Name',1,0);
        $pdf->Cell(64,5,'School Location',1,1);//end of line
        
    
        if(mysqli_num_rows($results) > 0){
    
            while($getAllPupils = mysqli_fetch_assoc($results)){
    
                $pdf->Cell(40, 5, ''.$getAllPupils['pupil_id'],1,0);
                $pdf->Cell(40, 5, ''.$getAllPupils['pupil_name'],1,0);
                $pdf->Cell(30, 5, ''.$getAllPupils['pupil_intake'],1,0);
                $pdf->Cell(50, 5, ''.$getAllPupils['school_center'],1,0);
                $pdf->Cell(60, 5, ''.$getAllPupils['school_name'],1,0);
                $pdf->Cell(64, 5, ''.$getAllPupils['school_location'],1,0);
                $pdf->Ln(); //print next row on a new line
    
            }
        }
    
        $pdf->Output();
    

} else if($getParam == 'complex'){
    
    $reason = $_POST['reasonType'];
        // $pdf->
        
        $pdf->Ln();
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(270,5,'All '.strtoupper($reason).' PUPILS REPORT ',0,0,'R');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(290,5,' ',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(290,5,'All '.strtoupper($reason).' PUPILS REPORT ',0,0,'C');
        
        $pdf->Ln();
        $pdf->Ln();
        //Query the results
    
        if($reason == 'passed'){

            $SQL = "SELECT * FROM pupil, parent WHERE pupil.parentID = parent.parentID AND pupil.activeStatus = 'active' 
                        ORDER BY yearStarted ASC " ;
            $results = mysqli_query($db_link, $SQL);
        
            $pdf->SetFont('Arial','B',12);
        
            $pdf->Cell(60 ,5,'Full Name',1,0);
            $pdf->Cell(40 ,5,'Date of Birth',1,0);
            $pdf->Cell(50 ,5,'Parent Name',1,0);
            $pdf->Cell(60,5,'Address',1,0);
            $pdf->Cell(30,5,'Grade',1,0);
            $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line
        
            $pdf->Cell(274, 5, '',1,1);
            // $pdf->Ln();
        
            if(mysqli_num_rows($results) > 0){
        
                while($getAllPupils = mysqli_fetch_assoc($results)){
        
                    $pdf->Cell(60, 5, ''.$getAllPupils['pupilName'],1,0);
                    $pdf->Cell(40, 5, ''.$getAllPupils['dateOfBirth'],1,0);
                    $pdf->Cell(50, 5, ''.$getAllPupils['parentName'],1,0);
                    $pdf->Cell(60, 5, ''.$getAllPupils['address'],1,0);
                    $pdf->Cell(30, 5, ''.$getAllPupils['grade'],1,0);
                    $pdf->Cell(34, 5, ''.$getAllPupils['yearStarted'],1,0);
                    $pdf->Ln(); //print next row on a new line
        
                }
            }


        } else if($reason == 'failed'){

            $SQL = "SELECT * FROM pupil, parent, reasons WHERE pupil.parentID = parent.parentID AND 
            pupil.pupilID = reasons.pupilID AND reasons.reason = '$reason' AND pupil.activeStatus = '$reason' 
                        ORDER BY yearStarted ASC " ;
            $results = mysqli_query($db_link, $SQL);
        
            $pdf->SetFont('Arial','B',12);
        
            $pdf->Cell(60 ,5,'Full Name',1,0);
            $pdf->Cell(40 ,5,'Date of Birth',1,0);
            $pdf->Cell(50 ,5,'Parent Name',1,0);
            $pdf->Cell(60,5,'Address',1,0);
            $pdf->Cell(30,5,'Grade',1,0);
            $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line
        
            $pdf->Cell(274, 5, '',1,1);
        
        
            if(mysqli_num_rows($results) > 0){
        
                while($getAllPupils = mysqli_fetch_assoc($results)){
        
                    $pdf->Cell(60, 5, ''.$getAllPupils['pupilName'],1,0);
                    $pdf->Cell(40, 5, ''.$getAllPupils['dateOfBirth'],1,0);
                    $pdf->Cell(50, 5, ''.$getAllPupils['parentName'],1,0);
                    $pdf->Cell(60, 5, ''.$getAllPupils['address'],1,0);
                    $pdf->Cell(30, 5, ''.$getAllPupils['grade'],1,0);
                    $pdf->Cell(34, 5, ''.$getAllPupils['yearStarted'],1,0);
                    $pdf->Ln(); //print next row on a new line
        
                }
            }



        } else if ($reason == 'subjects'){
            $SQL = "SELECT * FROM pupil, parent, reasons WHERE pupil.parentID = parent.parentID AND 
            pupil.pupilID = reasons.pupilID AND reasons.reason = '$reason' AND pupil.activeStatus = '$reason' 
                        ORDER BY yearStarted ASC " ;
            $results = mysqli_query($db_link, $SQL);
        
            $pdf->SetFont('Arial','B',12);
        
            $pdf->Cell(60 ,5,'Full Name',1,0);
            $pdf->Cell(40 ,5,'Date of Birth',1,0);
            $pdf->Cell(50 ,5,'Parent Name',1,0);
            $pdf->Cell(60,5,'Address',1,0);
            $pdf->Cell(30,5,'Grade',1,0);
            $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line
        
            $pdf->Cell(274, 5, '',1,1);
        
        
            if(mysqli_num_rows($results) > 0){
        
                while($getAllPupils = mysqli_fetch_assoc($results)){
        
                    $pdf->Cell(60, 5, ''.$getAllPupils['pupilName'],1,0);
                    $pdf->Cell(40, 5, ''.$getAllPupils['dateOfBirth'],1,0);
                    $pdf->Cell(50, 5, ''.$getAllPupils['parentName'],1,0);
                    $pdf->Cell(60, 5, ''.$getAllPupils['address'],1,0);
                    $pdf->Cell(30, 5, ''.$getAllPupils['grade'],1,0);
                    $pdf->Cell(34, 5, ''.$getAllPupils['yearStarted'],1,0);
                    $pdf->Ln(); //print next row on a new line
        
                }
            }
        } else if ($reason == 'schools'){

        }


        
    
        $pdf->Output();
    
}

else if($getParam == 'yearAndGrade'){
    
    $startYear = $_POST['startYear'];
    $endYear =$_POST['endYear'];
    $grade = $_POST['grade'];
        // $pdf->
        $pdf->Ln();
        $pdf->SetFont('Arial','',10);
        $pdf->Cell(270,5,'All PUPILS  IN '.$grade.'  BEWTEEN '.$startYear.' -'.$endYear.' REPORT ',0,0,'R');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(290,5,'De Progress Primary ',0,0,'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(290,5,'All PUPILS IN '.$grade.' BEWTEEN '.$startYear.' -'.$endYear.' REPORT ',0,0,'C');
        
        $pdf->Ln();
        $pdf->Ln();
        //Query the results
    
        $SQL = "SELECT * FROM pupils_accounts, parent WHERE pupil.parentID = parent.parentID AND pupil.grade = '$grade'
                    AND YEAR(yearStarted)BETWEEN '$startYear'  AND '$endYear' ORDER BY yearStarted ASC ";
        $results = mysqli_query($db_link, $SQL);
    
        $pdf->SetFont('Arial','B',12);
    
        $pdf->Cell(60 ,5,'Full Name',1,0);
        $pdf->Cell(40 ,5,'Date of Birth',1,0);
        $pdf->Cell(50 ,5,'Parent Name',1,0);
        $pdf->Cell(60,5,'Address',1,0);
        $pdf->Cell(30,5,'Grade',1,0);
        $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line
    
        $pdf->Cell(274, 5, '',1,1);
    
    
        if(mysqli_num_rows($results) > 0){
    
            while($getAllPupils = mysqli_fetch_assoc($results)){
    
                $pdf->Cell(60, 5, ''.$getAllPupils['pupilName'],1,0);
                $pdf->Cell(40, 5, ''.$getAllPupils['dateOfBirth'],1,0);
                $pdf->Cell(50, 5, ''.$getAllPupils['parentName'],1,0);
                $pdf->Cell(60, 5, ''.$getAllPupils['address'],1,0);
                $pdf->Cell(30, 5, ''.$getAllPupils['grade'],1,0);
                $pdf->Cell(34, 5, ''.$getAllPupils['yearStarted'],1,0);
                $pdf->Ln();
    
            }
        }
    
        $pdf->Output();
    
}else if($getParam == 'endofyear'){

    /*Do the various Date Calculations*/
    $date=date_create("today");
    $todayDateFormat = date_format($date,"Y-m-d");
    //find out what the date was 3 days ago
    $previuousDates = date_sub($date,date_interval_create_from_date_string("3 days")); 
    $previuousDateFormat = date_format($previuousDates,"Y-m-d");
    
    // $pdf->
    $pdf->Ln();
    $pdf->SetFont('Arial','',10);
    
    $pdf->Cell(270,5,'All PUPILS WHO PROCEEDED TO NEXT GRADE REPORT',0,0,'R');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Arial','B',18);
    $pdf->Cell(290,5,'De Progress Primary ',0,0,'C');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(290,5,'All PUPILS WHO PROCEEDED TO NEXT GRADE REPORT',0,0,'C');
    
    $pdf->Ln();
    $pdf->Ln();
    //Query the results

    $SQL = "SELECT pupil.pupilName, pupil.grade as previous_grade,  
    tracking.grade as current_grade, parent.parentName, pupil.yearStarted
                FROM pupil, tracking, parent WHERE pupil.pupilID = tracking.pupilID 
                    AND pupil.parentID = parent.parentID 
                        AND YEAR(tracking.dateModified) BETWEEN '$todayDateFormat' AND '$previuousDateFormat'
                            HAVING pupil.grade < tracking.grade";

    $results = mysqli_query($db_link, $SQL);

    $pdf->SetFont('Arial','B',12);

    $pdf->Cell(60 ,5,'Full Name',1,0);
    $pdf->Cell(40 ,5,'Prevoius grade',1,0);
    $pdf->Cell(50 ,5,'current grade',1,0);
    $pdf->Cell(60,5,'Parent Name',1,0);
    // $pdf->Cell(30,5,'Grade',1,0);
    $pdf->Cell(34,5,'Year Enrolled',1,1);//end of line

    $pdf->Cell(244, 5, '',1,1);


    if(mysqli_num_rows($results) > 0){

        while($getAllPupils = mysqli_fetch_assoc($results)){

            $pdf->Cell(60, 5, ''.$getAllPupils['pupilName'],1,0);
            $pdf->Cell(40, 5, ''.$getAllPupils['previous_grade'],1,0);
            $pdf->Cell(50, 5, ''.$getAllPupils['current_grade'],1,0);
            $pdf->Cell(60, 5, ''.$getAllPupils['parentName'],1,0);
            // $pdf->Cell(30, 5, ''.$getAllPupils['grade'],1,0);
            $pdf->Cell(34, 5, ''.$getAllPupils['yearStarted'],1,0);
            $pdf->Ln();

        }
    }

    $pdf->Output();
}else if($getParam == 'singlePupil'){

    //This is the sub main report of the system.
    

}
?>