<?php

if(isset($_SESSION["staff_cat"])){
  
  $staffCat = $_SESSION["staff_cat"];
  if(isset($authorized) && is_array($authorized)){
   
   if(!in_array($staffCat, $authorized)){
    
    $_SESSION["error_msg"] ="Sorry you are not authorized to view All Results on this system";
  echo '<script>
 window.location.href ="/home?msg_report=Access denied!&report=failed";
 
 </script>';   
  
  exit();          
       
   }   
  }
  else{
      
 $_SESSION["error_msg"] ="Some important configuration constants are missing and hence access to Result Database cannot be granted. please consult the developer of this system to fix the missing constants";
 
  echo '<script>
 window.location.href ="/home?msg_report=missing configuration constants!&report=failed";
 
 </script>';   
  
  exit();       
      
  }
}
else{
 
 echo '<script>
 window.location.href ="/home?msg_report=please login to continue!&report=failed";
 
 </script>';   
  
  exit();  
 }



echo '<div class="page-title">
    <h1>All Results</h1>
    <div class="title-line"></div>
</div>

<form action="" method="post" class="filter-card">

    <div class="filter-grid">

        <div class="filter-group">
            <label>Select Class:</label>

    <select name="class">';
      
 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));
 
// $mergeValue = [$viewClass,"All"];
 $mergeValue = $viewClass;
 $classes = merge_into_array($mergeValue,$classes,"front",false);
 foreach ($classes as $classOption){
     
  echo '<option>'.$classOption.'</option>'; 
 }

     echo '</select>
        </div>
      <div class="filter-group">
      <label>Select Exam:</label>
  <select name="term">';
 $terms = generate_terms();
 //$mergeValue = [$term,"All"];
 $mergeValue = $term;
 $terms = merge_into_array($mergeValue,$terms,"front",false);
 
foreach($terms as $termOption){

 if($termOption == "All"){
     $exam = "Examinations";
 }
 else{
   $exam = "Examination";   
 }

echo '<option value="'.$termOption.'">'.$termOption.' '.$exam.'</option>';
}
           
     echo '</select>
        </div>
        <div class="filter-group">
            <label>Select Group:</label>
         <select name="group">';
   
  $groups = collect_table_data1($conn,"variables","type","Class","s","","classification");
 $mergeValue = [$group,"All"];
 $groups = merge_into_array($mergeValue,$groups,"front",false);
   
   foreach ($groups as $groupOption){
    
echo '<option value="'.$groupOption.'">'.$groupOption.'</option>'; 
       
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
    <button type ="submit" id="submit-filter" name="submit-filter-results">Filter Results</button>';

 $disabled = "disabled";
 if($staff_class){
  $disabled = "";    
 }
 echo ' <div class="add-remove">
 <button type="button"  onclick="classResults()" '.$disabled.'><i class="fa-solid fa-chart-bar text-primary"></i> </button>
<button type="button" onclick="openDeletePopup()" class="open-remove-btn" id="trash-btn"><i class="fa-solid fa-trash"></i></button>
<input type="hidden" id="term-session" value="'.$termSession.'">
 </div>
    </div>

</form>';

require 'delete_results.php';

/*-- ================= TOTAL FOUND ================= -->
*/

$Allresults = [];
$table = form_table_name("results_",$session);

if(check_exist_table($conn,$table)){
    
  if($viewClass =="All" && $group == "All"){
    
 $Allresults = collect_table_data($conn,$table,"id DESC","*");   

}
elseif($viewClass == "All" && $term =="All"){
    
 $Allresults = collect_table_data($conn,$table,"id DESC","*");   

}
elseif($viewClass == "All" && $term !="All"){
    
$Allresults = collect_table_data1($conn,$table,"term",$term,"s","id DESC","*");
    
}

elseif($viewClass !== "All" && $term =="All"){
    
$Allresults = collect_table_data1($conn,$table,"term",$term,"s","id DESC","*");
    
}
else{
  //Filter display
  
 $Allresults = collect_table_data2($conn,$table,"term","class",$term,$viewClass,"ss","id DESC","*");

 }  
}

$totalResults = count($Allresults);
if($term == "All"){
    
    $term_session = $session;
}
else{
    $term_session = $term." ".$session;
}


echo '<div class="total-found">
    <p>Showing '.$viewClass.' Results for '.$term_session.'</p>
    <input type="hidden" id="total-found-results"  value="'.$totalResults.'">';
    
 if($totalResults){
$records=pluralize("Record",$totalResults);
 echo '<p>'.number_format($totalResults).' '.$records.' found</p>';  
  }
    
echo '</div>


<div class="table-wrapper">
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

 if($Allresults && is_array($Allresults)){
  $sn = 0;
 foreach ($Allresults as $result){
  $sn++;   
  $std_id = $result["std_id"];   
  $group = $result["std_cat"];
  $std_class = $result["class"];
  //get std details
  $std_details = collect_user_data($conn,"students","std_id",$std_id,"i");
  $std_name = $std_details["surname"]." ".$std_details["othernames"];
  $std_pin = $std_details["std_pin"];
  $profile = null_check($std_details["profile"],"null.jpg");
  
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
    <td>'.$term.' Examination</td>
    <td>'.$session.'</td>
    <td class="action-area">

       <button type="button" 
        class="menu-btn"
        onclick="toggleMenu(this)">
            <i class="fas fa-bars"></i>
        </button>

        <div class="action-menu">

            <!-- VIEW FORM -->
            <form action="/results" method="POST">
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
                value="'.$term.'">

             <input type="hidden"
                name="session"
                value="'.$session.'">

                <button type="submit"
                class="view-btn"
                title="View this result">
                    <i class="fas fa-eye"></i>
                </button>

            </form>

            <!-- EDIT FORM -->
            <form action="/edit_results" method="POST">
 
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
                value="'.$term.'">

             <input type="hidden"
                name="session"
                value="'.$session.'">

                <button type="submit"
                class="edit-btn"
                title="Edit this result">
                    <i class="fas fa-pen"></i>
                </button>

            </form>
            
      
       <!-- Delete single Results -->
    
                <button type="submit"
                class="delete-btn"
                title="Delete this result"
            data-std_id="'.$std_id.'"
            data-std_class="'.$std_class.'"
             data-term ="'.$term.'"
             data-session ="'.$session.'"
             >      
              <i class="fas fa-trash"></i>
                </button>

        </div>

    </td>

</tr>'; 
     
  }
 }
 else{
  
  echo '<tr>
  <td colspan="9">No data found!</td>
  
  </tr>';   
     
 }

echo '</tbody>

</table>
</div>
<script>
function classResults(){
    
 //redire staff to view his class Results
 
 window.location.href = "/upload_results?show_class_results";
    
}

const trashBtn = document.getElementById("trash-btn");
const totalFound = document.getElementById("total-found-results").value.trim();

if(totalFound == 0){
    
 trashBtn.disabled = true;  
    
}
else{
  
  trashBtn.disabled = false;    
    
}


</script>';


?>

<script>

let selectedStudent = null;

document.addEventListener("click", function(e){

    const deleteBtn = e.target.closest(".delete-btn");

    if(deleteBtn){

        e.preventDefault();

        selectedStudent = {

            std_id: deleteBtn.dataset.std_id,
            std_class: deleteBtn.dataset.std_class,
            term: deleteBtn.dataset.term,
            session: deleteBtn.dataset.session

        };

    
    // Show Popup
   document.getElementById("deleteModal").style.display = "flex";
    }

});


document.getElementById("cancelDelete").addEventListener("click", function(){

    document.getElementById("deleteModal").style.display = "none";

    selectedStudent = null;

});



document.getElementById("confirmDelete").addEventListener("click", function(){

    if(!selectedStudent){
        return;
    }
    
 const Spine = document.getElementById("deleteSpinner2");
  Spine.style.display = "flex";
 fetch("/includes/set_class.inc", {

    method: "POST",

    headers:{
       "Content-Type":"application/json"
    },

    body: JSON.stringify({

        button_name:"delete_single_result",
        std_id: selectedStudent.std_id,
        std_class: selectedStudent.std_class,
        term: selectedStudent.term,
        session: selectedStudent.session

    })
})

.then(response => response.json())

.then(data => {

    if(data.status === "success"){

  document.getElementById("deleteModal").style.display = "none";

    Spine.style.display = "none";
     showToast(data.message);
    
    setTimeout(()=>{
    
       window.location.reload();   
    },1000);
    

    }
    else{
    
    document.getElementById("deleteModal").style.display = "none";
Spine.style.display = "none";
  showError(data.message,data.error);
        
    }
})

.catch(error => {

 document.getElementById("deleteModal").style.display = "none";
Spine.style.display = "none";
  showError(error,data.error);

});

});


document.getElementById("deleteModal").addEventListener("click", function(e){


// If user clicked the dark background

    if(e.target === this){

        this.style.display = "none";

        selectedStudent = null;
    }

});
</script>