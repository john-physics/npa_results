<?php 


echo '<style>

body {
    font-family: "Segoe UI", sans-serif;
    background: #eef2f7;
    margin: 0;
}

.class-container {
    width: 100%;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow:auto;
}



.top-bar {
    text-align: right;
    margin: 20px 0;
}

.btn {
    background: #3498db;
    color: white;
    padding: 10px 18px;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background: #2980b9;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #34495e;
    color: #fff;
    padding: 12px;
    text-align: left;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background: #f9f9f9;
}

.download-btn {
    background: #27ae60;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
}

  tr:nth-child(odd){
    background: rgba(0,0,0,0.04);
  }

.preview-btn {
    background: rgb(230,50,50);
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 5px;
    text-decoration: none;
}

.download-btn:hover {
    background: #1e8449;
}

.preview-btn:hover {
    background: #d68910;
}


.pinpup-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
}

.popup-box {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 300px;
  text-align: center;
}
.popup-box h3{
  font-size:20px; 
 color: #2196f3;   
    
}
.popup-box p{
  font-size:10px; 
 
    
}
.pinpup-actions {
  margin-top: 15px;
 
}

.pinpup-actions button {
  margin: 5px;
   width:45%;
   padding:10px;
   border-radius:10px;
   border:none;
   color:#fff;
}

.pinpup-actions #cancelpinBtn{
  background: #f44336;

}

.pinpup-actions #proceedBtn{
  background:  #4caf50;

}


</style>';



echo '<!-- Popup Overlay -->
<div id="pinPopup" class="pinpup-overlay">
  <div class="popup-box">
    <h3>Remove Class</h3>
    <p id="popupText"></p>

    <div class="pinpup-actions">
     <button type="button" id="cancelpinBtn">Cancel</button>
      <button type="button" onclick="proceedBtn()" id="proceedBtn">Proceed</button>
    </div>
   
    <div id="spinner"></div>
     <small id="prep1">Removing Class, please wait...</small>

  </div>
</div>';


$classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));

echo '<div class="class-container">
<table>
    <thead>
        <tr>
        <th>S/N</th>
        <th>Class Name</th>
       <th>Class Category</th>
        <th>Assessment Pattern</th>
         <th>Students Number</th>
         <th>Class Teacher</th>
         <th>Current Term\'s Result</th>
         <th>Actions</th>
            </tr>
        </thead>

        <tbody>';
        
    if(!$classes){
        
   echo ' <tr>
     <td colspan="4">No Class found.</td>
     </tr>';    
        
    }
   
   else{
     $totalStds =0;  
     $sn=0;
    foreach ($classes as $class) {
    
    $classDets = get_class_dets("class",$class);
    $classTeacher = $classDets["teacher"];
    $stdNum = $classDets["std_num"];
    $classCat = $classDets["class_cat"];
   $assPattern = $classDets["ass_pattern"];
    $totalStds+=$stdNum; 
    $session = $classDets["session"];
    $term = $classDets["term"];
   
 $result_status = check_result_status($conn,$term,$session,$class);
 $currentResult = "None";
 if($result_status){
 $published = $result_status["published"];
 $unpublished = $result_status["unpublished"]; 
 $class_size =$result_status["class_size"];
 
 if($class_size){
  $notpublished = $class_size - $published;
  $currentResult = "Published";
 if($notpublished > 0){
  $currentResult = "Not published";   
    }  
  }
 }
 
    $sn++;
     echo '<tr>
       <td>'.$sn.'.</td>
       <td>'.$class.'</td>
      <td>'.$classCat.'</td>
      <td>'.$assPattern.'</td>
      <td>'.$stdNum.'</td>
      <td>'.$classTeacher.'</td>
      <td>'.$currentResult.'</td>
      <td>
     <a href="#" class="preview-btn" data-class="'.$class.'">Remove </a>
    
    </td>
     </tr>';   
        
    }
    
    
    
  }  
echo '</tbody>
    </table>
</div>';

echo '<div class="acct-container">

     <div class="info-item">
     <span class="label">Current Session:</span>
     <span class="status-badge green_status">'.$session.' </span>
    </div> 
    
      <div class="info-item">
     <span class="label">Current Term:</span>
      <span class="status-badge blue_status">'.$term.' </span>
    </div>
    
    <div class="info-item">
     <span class="label">Total Students:</span>
      <span class="value">'.number_format($totalStds).' </span>
    </div>

</div>';


echo '<script>

let className = "";
document.addEventListener("click", function(e) {
// e.preventDefault();
  const btn = e.target.closest(".preview-btn");

  if (btn) {
 
 className = btn.dataset.class;
 
  document.getElementById("popupText").innerHTML =
    `By clicking Proceed, <b>${className}</b> will be removed from this site.<br><br>Do you want to proceed?`;

  document.getElementById("pinPopup").style.display = "flex";
  
 document.querySelector(".acct-container").style.display="none";
 document.querySelector(".footer").style.display="none";
 
    
  }

});


/* CANCEL BUTTON */

 document.getElementById("cancelpinBtn").addEventListener("click",(e)=>{

 document.getElementById("pinPopup").style.display = "none";   
    
  document.querySelector(".acct-container").style.display="block";  
  document.querySelector(".footer").style.display="block"; 
}); 


const popup = document.getElementById("pinPopup");
const popupBox = document.querySelector(".popup-box");

/* Close when clicking outside the popup box */
popup.addEventListener("click", function(e) {
  if (!popupBox.contains(e.target)) {
    popup.style.display = "none";
  document.querySelector(".acct-container").style.display="block";
  document.querySelector(".footer").style.display="block"; 
  }
});


/* PROCEED BUTTON */
function proceedBtn(){

 const spinner = document.getElementById("spinner");
const prep1 = document.getElementById("prep1");
spinner.style.display= "flex";  
  prep1.style.display = "block";
 
 fetch("/includes/users.inc", {
  method: "POST",
  headers: { "Content-Type": "application/json" },
  body: JSON.stringify({
    submit_button_name: "remove-class",
    class_name: className,
    
  })
})
  .then(res => res.json())
  .then(data => {

    if (data.status === "success") {
      
  showToast(data.message);
  prep1.innerHTML = data.message+". Refeshing the page...";

setTimeout(() =>{
      
      // reload page
  window.location.reload();
 spinner.style.display= "none";  
  prep1.style.display ="none";
 document.getElementById("pinPopup").style.display = "none";
 
 
  },2000);

     } else {
   
   spinner.style.display= "none";  
  prep1.style.display = "none";
   
 showError(data.message,data.error);  
  document.getElementById("pinPopup").style.display = "none";
    
    }

  })
  .catch(error => {
    spinner.style.display= "none";  
  prep1.style.display = "none";
    showError(error,"Ajax Error");  
  document.getElementById("pinPopup").style.display = "none";

  });  
    
    
}


</script>';