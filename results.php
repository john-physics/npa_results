<?php
 require 'page_init.php';
 
 head('Check Result',"$site | Check Result",""); //add header 
require 'menu.php';

// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="scripts/report_notice.js"></script>';
     
 }
  
 require './error_suc_msg.php'; // detect and display error Messages if any
require './custom_alert.php'; 
require './script_errors.php'; 


echo '  <style>
      
      .section{
          width:95%;
          max-width:900px;
          margin: 30px auto 10px auto;
          
      }
        .result-card {
            max-width: 550px;
            width: 100%;
            margin:  auto;
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.12), 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: box-shadow 0.2s ease;
            position:relative;
            top:10px;
            margin-bottom:10px;
        }

 
        .card-inner {
            padding: 1.75rem 1.5rem 2rem 1.5rem;
        }

        /* academy branding */
        .academy-name {
            font-size: 1.9rem;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: #0B2B4A;
            margin-bottom: 0.5rem;
            line-height: 1.2;
            border-left: 5px solid #D4AF37;
            padding-left: 1rem;
        }

        .address {
            font-size: 0.85rem;
            color: #4a5b6e;
            margin-bottom: 1.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9edf2;
            line-height: 1.4;
        }

        /* form group styles — identical spacing and text */
        .form-group {
            margin-bottom: 1.4rem;
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #1F3A5F;
            margin-bottom: 0.45rem;
        }

        .form-group input,select {
            width: 100%;
            padding: 0.85rem 1rem;
            font-size: 1rem;
            font-family: inherit;
            background: #FFFFFF;
            border: 1.5px solid #e2e8f0;
            border-radius: 20px;
            transition: all 0.2s ease;
            color: #0A1C2F;
            font-weight: 500;
            outline: none;
        }

        .form-group input:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

    .form-group select:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }

        .form-group input::placeholder {
            color: #9aaebf;
            font-weight: 400;
        }

  
        .view-btn {
            background: #0B2B4A;
            color: white;
            border: none;
            width: 100%;
            padding: 0.9rem 0;
            font-size: 1.05rem;
            font-weight: 600;
            font-family: inherit;
            border-radius: 40px;
            margin-top: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(11, 43, 74, 0.2);
            letter-spacing: 0.3px;
        }

        .view-btn:hover {
            background: #143e60;
            transform: scale(0.98);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .view-btn:active {
            transform: scale(0.97);
        }


.password-container {
    position: relative;
}

.password-container i {
    position: absolute;
    right: 15px;
    top: 70%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #888;
}

.password-container i:hover {
    color: #333;
}

  
        .result-feedback {
            margin-top: 1.8rem;
            background: #F8FAFE;
            border-radius: 24px;
            padding: 1rem 1.2rem;
            border-left: 4px solid #D4AF37;
            font-size: 0.82rem;
            color: #1f3a5f;
            font-weight: 500;
            transition: all 0.2s;
            text-align: center;
            word-break: break-word;
        }

        .result-feedback i {
            font-style: normal;
            display: inline-block;
        }

        .error-message {
            color: #c0392b;
            background: #fff5f5;
            border-left-color: #c0392b;
        }

     
        @media (max-width: 480px) {
       
            .card-inner {
                padding: 1.5rem 1.2rem 1.8rem 1.2rem;
            }
            .academy-name {
                font-size: 1.7rem;
                padding-left: 0.8rem;
            }
            .view-btn {
                padding: 0.8rem 0;
                font-size: 1rem;
            }
        }

   
        @media (min-width: 768px) {
       
            .result-card {
                max-width: 700px;
                transition: none;
            }
            .card-inner {
                padding: 2rem 2rem 2.2rem 2rem;
            }
            .form-group label {
                font-size: 0.85rem;
            }
            .form-group input {
                padding: 0.9rem 1.1rem;
            }
        }

       .address i {
            font-style: normal;
        }

             
        button {
            background: #0B2B4A;
        }

        ::selection {
            background: #D4AF37;
            color: #0B2B4A;
        }
        
 
 
#spinner {
        display: none;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 0.5s linear infinite;
        margin: 10px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
 
  #prep1{
     display:none;
     text-align:center;
     color:rgb(50,200,50);
     font-size:10px;
     position:relative;
     top:1px;
     font-weight:bold;
 }

#feed_back{
    
    display:block;
}
 
 #pin-error{
    display:block;
     position:absolute;
     top:80px;
     color:red;
     text-align:center;
     font-size:10px;
     font-style:italic;
     margin-left:10%;
 }
     .fa-clock{
     font-size:14px;    
     margin-right:5px;
     color: #2563eb;
      color:#d97706;
     }
     
 .fa-circle-exclamation{
  font-size:14px;    
   margin-right:5px;
    color:#dc2626;
}
     
   .result-feedback a{
   display:block;
   text-decoration:none;
   color:#fff;
   background:rgb(100,100,150);
   cursor:pointer;
   padding:10px;
   margin:20px auto 5px auto;
   border-radius:5px;
   width:50%;
   }
    
    .result-feedback a:hover{
    
     background:rgb(100,200,150);    
        
    }
    
    .fa-download{
        pointer-events:none;
    }
    </style>';

if($_SERVER["REQUEST_METHOD"]=="POST"){
 
 $viewer = trim($_POST["viewer"]);  
 $pin = trim($_POST["std_pin"]);
 $class = trim($_POST["std_class"]);
 $term = trim($_POST["term"]);
 $session = trim($_POST["session"]);
 $term_session = $term." ".$session;
 
 if(check_exist($conn,"students","std_pin",$pin,"s")){
  
  $resultTable = form_table_name("results_",$session); 
 $subjectTable = form_table_name("subject_records_",$session); 
 
 if(check_exist_table($conn,$resultTable)){
  
  $std_details = collect_user_data($conn,"students","std_pin",$pin,"s");
   $std_name = $std_details["surname"]." ".$std_details["othernames"];
  $std_name = normalize_user_name($std_details["surname"]." ".$std_details["othernames"],"upper");

 
  $std_id = $std_details["std_id"];
  $profile = null_check($std_details["profile"],"null.jpg");
  $std_cat = null_check($std_details["std_cat"],'N/A');
  $current_class = null_check($std_details["current_class"],"Unknown");  
  $group = $std_cat; 
 
 if(check_exist3($conn,$resultTable,"std_id","term","class",$std_id,$term,$class,"iss")){
//results is available 

$class_set = collect_user_data3($conn,"class_set","session","term","class",$session,$term,$class,"sss");
$totalStds = count(convert_to_array($class_set["students"]));

$classDet = collect_user_data2($conn,"variables","type","value","Class",$class,"ss");
$caPattern = convert_to_array($classDet["assessment_pattern"]);
$nextTerm = collect_user_data($conn,"variables","type","Next Term Begins","s");

$nextTermDate = $nextTerm["value"];
$results = collect_user_data3($conn,$resultTable,"term","class","std_id",$term,$class,$std_id,"sss");

$cteach_id = $results["staff_id"];
$std_cat  = $results["std_cat"];
$total_score  = $results["total_score"];
$total_scorable=$results["total_scorable"];
$subject_num = $results["subject_num"];
$overall_average = $results["overall_average"];
$overall_grade =$results["overall_grade"];
$general_remark = $results["general_remark"];
$position_inclass = $results["position_inclass"];
$teacher_comment = $results["teacher_comment"];
$principal_comment = $results["principal_comment"];
 
$activeness = $results["activeness"];
$attendance = $results["attendance"];
$punctuality = $results["punctuality"];
$self_control = $results["self_control"];
$honesty = $results["honesty"];
$humility =  $results["humility"];
$leadership = $results["leadership"];
$hand_writing =  $results["hand_writing"];
$fluency =        $results["fluency"];  
$musical_skills = $results["musical_skills"];
$sports = $results["sports"];
$date_created  = $results["date_created"];
$result_status= $results["result_status"];

 $datestrtotime = strtotime(str_replace("/","-",$date_created));
 $converted_date = date("d/m/Y",$datestrtotime);
 
$positionText = "$position_inclass out of $totalStds";
if(!$position_inclass){
$positionText = "";    
}


if(strtolower($result_status) !== "published" && $viewer !== "staff"){
    
  echo '<section class="section">
  <h2>'.$std_name.'</h2>
 <div id="resultDisplay" class="result-feedback">
   <span id="feed_back"><br>
   🔍 '.$term_session.' Results for '.$std_name.' ('.$class.') are not available at the moment!
   <br><br>
   <b><i class="fa-solid fa-clock"></i>
   Please check again later</b>
   </span>
   </div>
 
 </section>'; 
 
 
 Addfooter($site); 
 die();  
}
  
$subjectRecords = collect_table_data3($conn,$subjectTable,"std_id","term","class",$std_id,$term,$class,"iss");
$passedFailed = "Failed";
if($overall_average >= $passmark){
 $passedFailed = "Passed";   
}

$prfDir = "/images/students/$profile";
$prfPath = $_SERVER["DOCUMENT_ROOT"]."/images/students/$profile";
 if(!is_file($prfPath)){
 $prfDir = "/images/npa-logo.jpg";
 }

$redink = redink_for_failure($conn);
$showpos = show_position_inclass($conn);


 echo '<meta name="viewport" content="width=1200">';
require './css/results_styles.php';

echo '<div class="result-container" id="result-container">

    <!-- HEADER -->

    <div class="school-header">

        <div class="school-flex">

            <img src="/images/npa-logo.jpg" class="school-logo">

            <div class="school-details">
                <h1 class="school-name">'.ucwords($site).'</h1>
                <p class="school-address">
                '.$schoolAddress.'
                </p>
            </div>

            <img src="/images/npa-logo.jpg" class="school-logo">

        </div>

    </div>

    <!-- STUDENT -->

    <div class="student-section">

        <h1 class="student-name">
        '.$std_name.'
        </h1>

        <div class="student-flex">

       <img src="'.$prfDir.'" class="student-photo">

            <div class="student-info">
                <table>
                    <tr>
                      <td>Name</td>
                       <td>:</td>
                    <td>'.$std_name.'</td>
                    </tr>

                    <tr>
                        <td>Class</td>
                        <td>:</td>
                       <td>'.$class.'</td>
                    </tr>

                    <tr>
                        <td>PIN</td>
                        <td>:</td>
                        <td>'.$pin.'</td>
                    </tr>

                    <tr>
                        <td>Exam</td>
                        <td>:</td>
                        <td>'.strtoupper($term).' EXAMINATION</td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- DETAILS -->
  <h1 class="section-title">Details</h1>
    <div class="details-section">
          <table class="details-table">

            <tr>
                <td>Name of Student</td>
                <td colspan="3">'.$std_name.'</td>
            </tr>

            <tr>
                <td>Overall Grade</td>
                <td>'.$overall_grade.'</td>
                <td>Next Term Resumption Date</td>
                <td>'.$nextTermDate.'</td>
            </tr>

            <tr>
                <td>Class</td>
                <td>'.$class.'</td>
                <td>Year</td>
                <td>'.$session.'</td>
            </tr>

        </table>

    </div>

    <!-- GRADE SHEET -->

    <div class="grade-header">
        Grade Sheet
    </div>

    <div class="result-grid">

        <!-- SUBJECTS -->

        <div class="table-scroll">

            <table class="subject-table">

                <tr>

                    <th>No.</th>
                    <th>Subjects</th>';

         foreach($caPattern as $index=>$maxca){
             
           $caNo = $index+1;  
          echo '  <th>
             CA'.$caNo.'
                <br>
              '.$maxca.'%
           </th>';   
             
         }
    $maxtotal = 100;
    $maxexam = $maxtotal- array_sum($caPattern);
       
     echo'<th>Exam <br>'.$maxexam.'%</th>
        <th>Total <br> '.$maxtotal.'%</th>
         <th>Position</th>
        <th>Grade</th>
                
                </tr>';
            
          $sn = 0;
   foreach($subjectRecords as $records){
          $sn++;
       $subject = get_subject_name($records["subject"]);   
       $exam = $records["exam"];
       $total = $records["total"];
       $pos = $records["position"];
       $grade = $records["grade"];
       
          echo '<tr>
             <td>'.$sn.'</td>
             <td>'.$subject.'</td>';
         
       foreach ($caPattern as $index => $maxca){
      
         $cacol = "ca".($index+1);
       $cascore = $records[$cacol];
        echo '<td>'.$cascore.'</td>';
       }
       
       echo '<td>'.$exam.'</td>
     <td>'.$total.'</td>
     <td>'.$pos.'</td>
     <td>'.$grade.'</td>';

     }
        
     echo '</tr>
    </table>

        </div>

        <!-- DEVELOPMENT -->

        <div>

            <table class="side-table">
           <tr>
            <th>Development</th>
            <th>Ratings</th>
        </tr>

        <tr>
         <td>Activeness</td>
          <td>'.$activeness.'</td>
        </tr>

        <tr>
            <td>Attendance</td>
         <td>'.$attendance.'</td>
       </tr>

        <tr>
        <td>Punctuality</td>
         <td>'.$punctuality.'</td>
     </tr>

        <tr>
         <td>Self Control</td>
          <td>'.$self_control.'</td>
     </tr>

        <tr>
           <td>Honesty</td>
            <td>'.$honesty.'</td>
      </tr>

        <tr>
          <td>Humility</td>
       <td>'.$humility.'</td>
        </tr>

        <tr>
           <td>Leadership</td>
          <td>'.$leadership.'</td>
       </tr>

            </table>
   
     <table class="side-table">

        <tr>
            <th>Skills</th>
            <th>Ratings</th>
        </tr>

        <tr>
           <td>Handwriting</td>
        <td>'.$hand_writing.'</td>
      
               </tr>

        <tr>
       <td>Fluency</td>
        <td>'.$fluency.'</td>
        </tr>

        <tr>
           <td>Musical Skills</td>
           <td>'.$musical_skills.'</td>
        </tr>

        <tr>
             <td>Sports</td>
              <td>'.$sports.'</td>
       </tr>

    </table>

        </div>

    </div>

<!-- quick overview -->
   <h1 class="quick-overview">Quick Overview</h1>
     <div class="overview-section">
         <table class="summary-table">
            <tr>
               <td>Number of Subjects</td>
                <td>'.$subject_num.'</td>
            
                <td>Total Marks Obtained</td>
                <td>'.$total_score.'</td>
                <td>Total Marks Obtainable</td>
              <td>'.$total_scorable.'</td>
            </tr>

            <tr>
                <td>Overall Average</td>
                <td>'.$overall_average.'</td>';
                
               if($showpos){
               
             echo '<td>Position in Class</td>
              <td>'.$positionText.'</td>';
             echo '<td>Passed/Failed</td>
             <td>'.$passedFailed.'</td> '; 
               }
              else{
             
            echo '<td>Passed/Failed</td>
               <td colspan="3">'.$passedFailed.'</td>';
              }

       echo ' </tr></table>

    </div>';
    
 $pp_det = collect_user_data($conn,"staffs","staff_cat","Principal","s");
  $ict_dir = collect_user_data($conn,"staffs","staff_cat","ICT Director","s");
 $cteach_det = collect_user_data($conn,"staffs","staff_id",$cteach_id,"i");
  
$pp_name = normalize_user_name(
    $pp_det["title"]." ".$pp_det["surname"]." ".$pp_det["othernames"],"ucwords");
$cteach_name = normalize_user_name(
    $cteach_det["title"]." ".$cteach_det["surname"]." ".$cteach_det["othernames"],"ucwords");
$pp_sign = $pp_det["signature"];
$cteach_sign = $cteach_det["signature"];

$signPath = $_SERVER["DOCUMENT_ROOT"]."/images/staff/";
$principalSign = $signPath.$pp_sign;
$cteachSign = $signPath.$cteach_sign;
 
  
echo '<div class="print-remarks">

    <table class="remarks-table">
        <tr>
            <th colspan="6">Remarks</th>
        </tr>

        <tr>
            <td class="rmk-cell">
                Master/Mistress Remarks: 
                 </td>
               <td class="remarks-cell" colspan="5">
                '.$teacher_comment.'
            </td>
        </tr>

        <tr>
            <td>Name:</td>
            <td class="underline">'.$cteach_name.'</td>

            <td>Signature:</td>
            <td class="signature-line">';
              
          if(is_file($cteachSign)){
         
      echo ' <img src="/images/staff/'.$cteach_sign.'" width="100">';     
          }    
                
           echo '</td>
       <td>Date:</td>
            <td class="underline">'.$converted_date.'</td>
        </tr>

        <tr>
        <td class="rmk-cell">Principal\'s Remarks:</td>
           <td class="remarks-cell" colspan="5">'.$principal_comment.'</td>
          </tr>
      
         <tr>
          <td>Name:</td>
            <td class="underline">'.$pp_name.'</td>

            <td>Signature:</td>
            <td class="signature-line">';
              
          if(is_file($principalSign)){
         
      echo ' <img src="/images/staff/'.$pp_sign.'" width="100">';     
          }    
       echo '</td>
          
            <td>Date:</td>
            <td class="underline">'.$converted_date.'</td>
        </tr>

    </table>

</div>    
  
  <div class="print-watermark">
    '.$site.'
</div>  

<div class="footer-btns">
 <button type="button" class="download-btn" id="download-btn"  title="Back to previous page" onclick="goBack()">
 <i class="fa-solid fa-chevron-left"></i>
    </button>';

 echo '<button type="button" class="download-btn" id="download-btn" onclick="window.print()" title="Download this result sheet">
 <i class="fa-solid fa-download" id="scoresheet-droping"></i>
    </button>
      </div>
  </div>

</div>';//first div ends here


 $staffs = [];
 $staff1 = [
   "name"  => normalize_user_name($pp_det["title"]." ".$pp_det["surname"]." ".$pp_det["othernames"],'ucwords'),
  "position" => "Principal",
   "email" => $pp_det["email"],
   "number" => $pp_det["number"],
    "profile" => $pp_det["profile"]
    ];
    
 $staff2 = [
   "name"  => normalize_user_name($ict_dir["title"]." ".$ict_dir["surname"]." ".$ict_dir["othernames"],'ucwords'),
  "position" => "ICT Director",
   "email" => $ict_dir["email"],
   "number" => $ict_dir["number"],
    "profile" => $ict_dir["profile"]
    ];
$staff3 = [
   "name"  => normalize_user_name($cteach_det["title"]." ".$cteach_det["surname"]." ".$cteach_det["othernames"],'ucwords'),
  "position" => "Class Teacher",
   "email" => $cteach_det["email"],
   "number" => $cteach_det["number"],
    "profile" => $cteach_det["profile"]
    ];

 $staffs[] = $staff1;
 $staffs[] = $staff2;
 $staffs[] = $staff3;

 $imgPath = $_SERVER["DOCUMENT_ROOT"]."/images/staff/";
  

echo '<!-- RESULT ENQUIRY SECTION -->
<section class="result-enquiry">

    <div class="comp-section">
        Result Enquiries & Complaints
    </div>

    <p class="enquiry-text">
        For enquiries, complaints or questions concerning the above result,
        kindly contact any of the following members of staff.
    </p>

    <div class="staff-wrapper">';
    
    foreach ($staffs as $staff){
    
  if($staff["name"] && $staff["number"]){
  
 $photo = "/images/staff/".$staff["profile"];
 $photoPath = $imgPath.$staff["profile"];
 
 if(!is_file($photoPath)){
  $photo = "/images/npa-logo.jpg";  
 }
  
   echo ' <div class="staff-card">
            <div class="staff-photo">
                <img src="'.$photo.'" alt="Staff Photo">
            </div>
            <div class="staff-details">
               <h3>'.$staff["name"].'</h3>
                <span class="position">'.$staff["position"].'</span>
                <p>
                    <i class="fa-solid fa-envelope"></i>
                    '.$staff["email"].' </p>
                <p>
                 <i class="fa-brands fa-whatsapp"></i>
                '.$staff["number"].'
                </p>
            </div>

        </div>';   
      
     }   
    } 

   echo '</div>

    <div class="complaint-box">
        <strong>Official Result Complaint Email:</strong><br>
       <a href="mailto:'.$siteEmail.'" class="result-email">
     '.$siteEmail.'
</a>
    </div>

</section>';



 }
 else{
     
   echo '<section class="section">
  <h2>'.$std_name.'</h2>
 <div id="resultDisplay" class="result-feedback">
   <span id="feed_back"><br>
   🔍 '.$term_session.' Results for '.$std_name.' ('.$class.') are not available at the moment!
   <br><br>
   <b><i class="fa-solid fa-clock"></i>
   Please check again later</b>
   </span>
   </div>
 
 </section>';   
  
     
  }
 }
 else{
 
  echo '<section class="section">
  <h2>Result Checker</h2>
 <div id="resultDisplay" class="result-feedback">
   <span id="feed_back"><br>
   🔍 Results for '.$term_session.' are not available at the moment!
   <br><br>
   <b><i class="fa-solid fa-clock"></i>
   Please check again later</b>
   </span>
   </div>
 
 </section>';    
     
  }   
 }
 else{
  
  echo '<section class="section">
 <h2>Result Checker</h2>
 <div id="resultDisplay" class="result-feedback">
   <span id="feed_back"><br>
   🔍 Invalid student PIN!
   <br><br>
   <b><i class="fa-solid fa-circle-exclamation"></i>
   Please check your pin and try again.</b>
   </span>
   <a href="/results" id="try_again" target="_blank" title="Click to go back and enter pin again">Try Again</a>
   </div>
 
 </section>';    
        
 }
}
else{
    
 echo '<section class="section">
   <div class="result-card">
        <div class="card-inner">
            <div class="academy-name">'.$site2.'</div>
        <div class="address">'.$schoolAddress.'</div>

  <form id="resultForm" action="/results" method="post">
  <div class="form-group password-container">
 
  <input type="hidden" id="viewer" name="viewer" value="parents-students">
 
     <label for="pin">PIN</label>
  <input type="password" id="pin" name="std_pin" placeholder="Enter your PIN" autocomplete="off">
         
 <i id="toggle-password" class="fas fa-eye"></i>
 <small id="pin-error"></small>
  </div>

   <div class="form-group">
    <label for="std_class">Class</label>
 <select name="std_class" id="std_class">';
                  
   $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));
               
     foreach ($classes as $class){
                     
     echo '<option>'.$class.'</option>';    
      }
                 
   echo '</select></div>

 <div class="form-group">
   <label for="term">Exam</label>
<select name="term" id="term">';
  
   $terms = generate_terms();
foreach($terms as $term){

echo '<option value="'.$term.'">'.$term.' Examination</option>';
} 
 echo '</select></div>

     <div class="form-group">
     <label for="session">Year</label>
    <select id="session" name="session">';
  
   $sessions = generate_sessions();
  
foreach($sessions as $session){

echo '<option>'.$session.'</option>';

}
 
 echo '</select>
 </div>
  <button type="submit" id="viewResultsBtn" name="viewResultsBtn" value="view-my-result" class="view-btn">View Results</button>
      </form>


    <div id="resultDisplay" class="result-feedback">
   <span id="feed_back">🔍 Enter your PIN and tap "View Results"</span>
    <div id="spinner"></div>
   <small id="prep1">Fetching your results...</small>
            </div>
        </div>

    </div>
    </section>';   
    
}


Addfooter($site); 


?>


<script>
 
 const form = document.getElementById("resultForm"); 
form.addEventListener("submit", async (e) =>{
  
 const spinner =document.getElementById("spinner");
const prep1 =document.getElementById("prep1");
const feedBack =document.getElementById("feed_back");
 const pinError = document.getElementById("pin-error");
const pin = document.getElementById("pin").value.trim();
const viewClass = document.getElementById("std_class").value.trim();
const session = document.getElementById("session").value.trim();
 e.preventDefault(); //prevent default submission initially
 
 if(!pin){
     
  pinError.innerHTML = "Please Enter your PIN";
  return;   
 }
 
 pinError.innerHTML = "";
 feedBack.style.display = "none";
 spinner.style.display ="flex";
 prep1.style.display ="block";

   // 2. AJAX PIN validation
 const formData = new URLSearchParams();
formData.append("std_pin", pin);
formData.append("view_class", viewClass);
formData.append("session", session);
formData.append("submit_button_name", "check_pin");

  try {
    const res = await fetch("/includes/validatepin", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: formData
    });

    const data = await res.json();

    if (data.pin !== "valid") {
     
  pinError.innerHTML = data.message;
 feedBack.style.display = "block";
 spinner.style.display ="none";
 prep1.style.display ="none";

  return; // Stop submission
    }

    // Everything passed; submit normally
    form.submit(); // goes to PHP page via POST

  } catch (error) {
  
  pinError.innerHTML = "";
 feedBack.style.display = "block";
 spinner.style.display ="none";
 prep1.style.display ="none";
  
  showError(error,"Ajax Error");
    return;  //stop submission
   }  
 });
   
   
 
</script>


<script>
  
    // Toggle show/hide password
const togglePassword = document.getElementById("toggle-password");
const passwordField = document.getElementById("pin");

togglePassword.addEventListener("click", () => {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    }
});


</script>

<script>
    
  function goBack(){
      
  let backURL = document.referrer;
  
if(!backURL){
 backURL = "/upload_results"; 
}

window.location.href = backURL;

  }


document.addEventListener("click",(e)=>{
 
 const btn = e.target.closest(".download-btn");
 
 if(btn){
     
const scoresheetDroping = document.getElementById("scoresheet-droping");

scoresheetDroping.classList.add("droping");
 
     setTimeout(()=>{
    
     scoresheetdownloading.innerHTML =""; 
     scoresheetDroping.classList.remove("droping");
         
     },5000); 
     
 }

    
});


</script>

