<?php

require 'page_init.php';

if(!check_staff_login($conn)){
 header("Location:/home");
 die();
 
}

head('Upload Results',"$site | Upload Results","");

require 'menu.php';

// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="scripts/report_notice.js"></script>';
     
 }
  
require './error_suc_msg.php';
require './custom_alert.php'; 
require './script_errors.php'; 

require './css/styles.php';//load css


 $staff_id = $_SESSION["staff_id"];

 $staff_det = collect_user_data($conn,"staffs","staff_id",$staff_id,"i");
$staff_cat = $staff_det["staff_cat"];
$fullname = $staff_det["title"]." ".$staff_det["surname"]." ".$staff_det["othernames"];
$othernames = $staff_det["title"]." ".$staff_det["othernames"];

$staff_class = null_check($staff_det["class_handling"],null);

$current = get_current_session();
$CurrentSession = $current['session'];
$currentTerm = $current["term"];


if(isset($_GET["show_all_results"])){
    
if(isset($_POST["submit-filter-results"])){
$session = trim($_POST['session']);
 $term = trim($_POST["term"]);
$termSession = $term." ".$session;
$group = trim($_POST["group"]);
$viewClass = trim($_POST["class"]);

}
 else{
     
 //use $current session    
 $session = $CurrentSession;
 $term = $currentTerm;
$termSession = $term." ".$session;
$group = "All";
//$viewClass = "All";
$viewClass = "PRE-SCHOOL 1";

 }
 
 echo '<input type="hidden" id="staff_class" value="'.$viewClass.'">
 <input type="hidden" id="term_session" value="'.$termSession.'">';
 
 require 'all_results.php';
 
//filtered Results, show broadsheet here also 
$result_status = check_result_status($conn,$term,$session,$viewClass);

if($result_status && is_array($result_status)){
 
 $published = $result_status["published"];
 $unpublished = $result_status["unpublished"]; 
 $class_size =$result_status["class_size"];
 $broadsheet =$result_status["broadsheet"];
 $notpublished = $class_size - $published;

 if($broadsheet){
  
  require 'broad_sheet.php';
  
  }  
 }
}
else{
   
if(isset($_POST["submit-filter-results"])){
$session = trim($_POST['session']);
 $term = trim($_POST["term"]);
$termSession = $term." ".$session;
$group = trim($_POST["group"]);
$viewClass = trim($_POST["class"]);

}
 else{
     
 //use $current session    
 $session = $CurrentSession;
 $term = $currentTerm;
$termSession = $term." ".$session;
$group = "All";
//$viewClass = "All"; 
$viewClass = "PRE-SCHOOL 1";

 }
 
 if($staff_class){
  //check if this teacher's class is set
  if(check_exist4($conn,"class_set","staff_id","session","term","class",$staff_id,$CurrentSession,$currentTerm,$staff_class,"isss")){
    
$viewClass = $staff_class;//restrict view to staff class only & always.
      
 echo '<div class="page-title">
    <h1>Class Results</h1>
    <div class="title-line"></div>
</div>

<!-- FILTER FORM -->

<form action="" method="post" class="filter-card">

   <div class="filter-grid">
 
 <div class="filter-group">
  <label>Select Exam:</label>

    <select name="term">';
     
  $terms = generate_terms();
 // $mergeValue = [$term,"All"];
  $mergeValue = $term;
 $terms = merge_into_array($mergeValue,$terms,"front",false);
 
foreach($terms as $termOption){
   $exam = "Examination";   
 if($termOption == "All"){
     $exam = "Examinations";
 }

echo '<option value="'.$termOption.'">'.$termOption.' '.$exam.'</option>';
}
           
  echo '</select>
        </div>


  <div class="filter-group">
    <label>Select Year:</label>
     <select name="session">';

 $sessions = generate_sessions();
 $sessions = merge_into_array($session,$sessions,"front",false);
foreach($sessions as $sessionOption){

echo '<option>'.$sessionOption.'</option>';

}  
  
echo '</select>
        </div>
 </div>
 <div class="filter-btn">
    <button type ="submit" id="submit-filter" name="submit-filter-results">Filter Results</button>
    
 <div class="add-remove">';
 $disabled = "disabled";
 if(in_array($staff_cat,$authorized)){
  $disabled = "";    
 }
 
 if($term == "All"){
  $term_session = $session;
}
else{
    $term_session = $term." ".$session;
}

 echo '<button type="button" onclick="openAddPopup()"><i class="fa-solid fa-plus"></i></button>
 <button type="button"  onclick="AllResults()" '.$disabled.'><i class="fa-solid fa-chart-bar text-primary"></i> </button>
<button type="button" onclick="openRemovePopup()"  class="open-remove-btn"><i class="fa-solid fa-xmark"></i></button>
<input type="hidden" id="staff-class" value="'.$staff_class.'">
<input type="hidden" id="term_session" value="'.$term_session.'">
 </div>
    </div>

</form>';


require 'remove_stds.php';

$table = "class_set";

if(check_exist_table($conn,$table)){
    
if($term =="All"){
    
 $classSet = collect_table_data3($conn,$table,"staff_id","session","class",$staff_id,$session,$viewClass,"iss","id DESC","*");   

}

else{
  //Filter display
  
 $classSet = collect_table_data4($conn,$table,"staff_id","session","term","class",$staff_id,$session,$term,$viewClass,"isss","id DESC","*");

 }  
}


echo '<div class="total-found">
    <p>Showing '.$viewClass.' Results for '.$term_session.'</p>
 <!-- <p id="total-found"></p>  -->
 </div>';

echo '<div class="table-wrapper">
<table class="results-table">
<thead>
<tr>
    <th>S/N</th>
    <th>Photos</th>
    <th>Name</th>
    <th>PIN</th>
    <th>Class</th>
    <th>Group</th>
    <th>Exam</th>
    <th>Year</th>
    <th>Actions</th>
</tr>
</thead>
<tbody>';

if($classSet && is_array($classSet)){
 $sn = 0;
foreach ($classSet as $set){

 $viewterm = $set["term"];
 $stds = $set["students"];
 $classStds =  convert_to_array($stds);

 if($classStds && is_array($classStds)){
     
  foreach ($classStds as $std_id){
  //get std details 
  
   $std_details = collect_user_data($conn,"students","std_id",$std_id,"i");
  $std_name = $std_details["surname"]." ".$std_details["othernames"];
  $std_pin = $std_details["std_pin"];
  $profile = null_check($std_details["profile"],"null.jpg");
  $std_cat = null_check($std_details["std_cat"],'N/A');
  $std_class = $viewClass;  
  $group = $std_cat;  
  $sn++;  
   
 $profilePath = $root.'/images/students/'.$profile;
 
 if(!file_exists($profilePath)){
     
 $profile = "npa-logo.jpg";  
     
 }
      
   echo '
   <tr>
    <td>'.$sn.'</td>
    <td>
    <img src="images/students/'.$profile.'"
        class="student-photo" loading="lazy">
    </td>
    <td class="student-name">'.$std_name.'</td>
    <td>'.$std_pin.'</td>
    <td>'.$std_class.'</td>
    <td>'.$group.'</td>
    <td>'.$viewterm.' Examination</td>
    <td>'.$session.'</td>
    <td class="action-area">

       <button type="button"
        class="menu-btn"
        onclick="toggleMenu(this)">
            <i class="fas fa-bars"></i>
        </button>

        <div class="action-menu">

            <!-- VIEW FORM -->
            <form action="/results" method="post">
             <input type="hidden"
             name="viewer" value="staff">
            
              <input type="hidden"
                name="std_id"
                value="'.$std_id.'">
        
              <input type="hidden"
                name="std_pin"
                value="'.$std_pin.'">
              
              <input type="hidden"
                name="std_class"
                value="'.$std_class.'">

              <input type="hidden"
                name="term"
                value="'.$viewterm.'">

             <input type="hidden"
                name="session"
                value="'.$session.'">

                <button type="submit"
                class="view-btn"
                title="View">
                    <i class="fas fa-eye"></i>
                </button>

            </form>

            <!-- EDIT FORM -->
            <form action="/edit_results" method="post">
 
            <input type="hidden"
                name="std_id"
                value="'.$std_id.'">
         
              <input type="hidden"
                name="std_class"
                value="'.$std_class.'">

              <input type="hidden"
                name="term"
                value="'.$viewterm.'">

             <input type="hidden"
                name="session"
                value="'.$session.'">

                <button type="submit"
                class="edit-btn"
                title="Edit" name"edit-std-results">
                    <i class="fas fa-pen"></i>
                </button>

            </form>

        </div>

    </td>

</tr>';  
     
   }  
  }
 }
 
 if(!$sn){
     
     echo '<tr>
  <td colspan="9">No student found. Use the plus icon above to add your students</td>
  
  </tr>';   
     
 }
 
 echo '<input type="hidden" id="data-count" value="'.$sn.'">
 
 <script>
 document.addEventListener("DOMContentLoaded",()=>{
     
 const dataCount = document.getElementById("data-count").value;
 const countDisplay = document.getElementById("total-found");
 
 if(dataCount > 0){
 
 if(dataCount == 1){
 
 countDisplay.innerHTML = dataCount+" Record found";

 }
  else{
  
   countDisplay.innerHTML = dataCount+" Records found";
  }
 }
     
 });
 
 </script>';
 
}
else{
  
  echo '<tr>
  <td colspan="9">No data found!</td>
  
  </tr>';   
     
 }

echo '</tbody>

</table>
</div>';

  
  }
 else{
     
 // staff class not set, teachers must first set up their class.
 echo '<input type="hidden" id="staff_id" value="'.$staff_id.'">
   <input type="hidden" id="staff_name" value="'.$othernames.'">
   <input type="hidden" id="staff_class" value="'.$staff_class.'">
   <input type="hidden" id="term_session" value="'.$termSession.'">';
  
  require 'set_class.php';
  echo '<style>
  .footer{
     
    margin-top:100%;  
      }
     </style>';
  
  }
  
 // broad sheet goes here for cteachers view 

 $result_status = check_result_status($conn,$term,$session,$viewClass);

if($result_status && is_array($result_status)){
 
 $published = $result_status["published"];
 $unpublished = $result_status["unpublished"]; 
 $class_size =$result_status["class_size"];
 $broadsheet =$result_status["broadsheet"];
 $cteacher = $result_status["cteacher"];
 $notpublished = $class_size - $published;

 if($broadsheet && $cteacher == $staff_id){
  
 echo '<input type="hidden" id="staff_class" value="'.$viewClass.'">
 <input type="hidden" id="term_session" value="'.$term_session.'">'; 
 
  require 'broad_sheet.php';
  
  }  
 }
 

 }
elseif(in_array($staff_cat,$authorized)){
   //only authorized staffs can view all results 
   
 echo '<input type="hidden" id="staff_class" value="'.$viewClass.'">
 <input type="hidden" id="term_session" value="'.$termSession.'">';

 require 'all_results.php';
 
 // broad sheet goes here for authorized staff's view 
 $result_status = check_result_status($conn,$term,$session,$viewClass);
if($result_status && is_array($result_status)){
 
 $published = $result_status["published"];
 $unpublished = $result_status["unpublished"]; 
 $class_size =$result_status["class_size"];
 $broadsheet =$result_status["broadsheet"];
 $notpublished = $class_size - $published;

 if($broadsheet){
    
  require 'broad_sheet.php';
  
  }  
 }
 
 
}
else{
 //unknown permision   
 echo '<script>
 window.location ="/home?msg_report=Access denied !&report=failed";
 
 </script>'; 
 exit();
    
 }
}

  Addfooter($site);

?>

<script>
    
  function toggleMenu(button){

    let currentMenu =
    button.nextElementSibling;

    // Close other opened menus
    document.querySelectorAll(".action-menu")
    .forEach(menu => {

        if(menu !== currentMenu){
            menu.style.display = "none";
        }

    });

    // Toggle current menu
   if(currentMenu.style.display === "flex"){
        currentMenu.style.display = "none";
    }else{
        currentMenu.style.display = "flex";
    }

}

// Close menu when clicking outside
document.addEventListener("click", function(e){

    if(
        !e.target.closest(".action-area")
    ){

        document.querySelectorAll(".action-menu")
        .forEach(menu => {
            menu.style.display = "none";
        });

    }

});
  
    
</script>
<script>
    
 function AllResults(){
     
//redirect to view all results
 window.location.href= "/upload_results?show_all_results";    
     
 }   
    
</script>
