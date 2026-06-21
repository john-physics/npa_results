<?php

echo '<style>


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

  tr:nth-child(odd){
    background: rgba(0,0,0,0.04);
  }
  
.action-btns{
display:flex;
gap:20px;
align-items:center;
justify-content:center;

}
 .download-btn {
    background: #27ae60;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
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
  z-index:1000;
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
    <h3>Remove Subjects</h3>
    <p id="popupText"></p>

    <div class="pinpup-actions">
     <button type="button" id="cancelpinBtn">Cancel</button>
      <button type="button" onclick="proceedBtn()" id="proceedBtn">Proceed</button>
    </div>
   
    <div id="spinner"></div>
     <small id="prep1">Removing Subject, please wait...</small>

  </div>
</div>';


$subjects = collect_table_data1($conn,"variables","type","Subject","s","","value");

sort($subjects);

echo '<div class="class-container">
<table>
    <thead>
        <tr>
       <th>S/N</th>
        <th>Subject Name</th>
         <th>Subject Code</th>
       <th>Subject Category</th>
         <th>Subject Teacher(s)</th>';
     
   $authorized = remove_from_array("Teacher",$authorized);
     
     if(in_array($staff_cat,$authorized)){
         
      echo '<th style="text-align:center;">Actions</th>';
     }    
        
   echo '</tr>
        </thead>

        <tbody>';
        
    if(!$subjects){
        
   echo ' <tr>
     <td colspan="4">No subject found.</td>
     </tr>';    
        
    }
   
   else{
    
    $sn =0;  
    foreach ($subjects as $subj) {
    
    $subjDets = get_class_dets("subject",$subj);
    $subjTeacher = $subjDets["teacher"];
    $subjCat = $subjDets["subj_cat"];
    $subj_id = $subjDets["subj_id"];
    $subjCode = $subjDets["subj_code"];
    $sn++;
      
     echo '<tr>
      <td>'.$sn.'.</td>
      <td>'.$subj.'</td>
      <td>'.$subjCode.'</td>
      <td>'.$subjCat.'</td>
      <td>'.$subjTeacher.'</td>';
    
  if(in_array($staff_cat,$authorized)){
         
   echo '<td>
 <div class="action-btns">  
 <a href="/add_new?add_new_subject&upd-subject-name=true&subj_id='.$subj_id.'" class="download-btn" data-subj="'.$subj.'"><i class="fa-solid fa-pen-to-square"></i></a>
   
     <a href="#" class="preview-btn" data-subj="'.$subj.'"><i class="fa-solid fa-trash"></i></a>
   </div> 
    </td>';
     } 
    
  echo '</tr>';   
        
    }
  }  
echo '</tbody>
    </table>
</div>';


echo '<script>

let subjName = "";
document.addEventListener("click", function(e) {
// e.preventDefault();
  const btn = e.target.closest(".preview-btn");

  if (btn) {
 
 subjName = btn.dataset.subj;
 
  document.getElementById("popupText").innerHTML =
    `By clicking Proceed, <b>${subjName}</b> will be removed from this site.<br><br>Do you want to proceed?`;

  document.getElementById("pinPopup").style.display = "flex";
  
 document.querySelector(".footer").style.display="none";
    
  }

});


/* CANCEL BUTTON */

 document.getElementById("cancelpinBtn").addEventListener("click",(e)=>{

 document.getElementById("pinPopup").style.display = "none";   

  document.querySelector(".footer").style.display="block"; 
}); 


const popup = document.getElementById("pinPopup");
const popupBox = document.querySelector(".popup-box");

/* Close when clicking outside the popup box */
popup.addEventListener("click", function(e) {
  if (!popupBox.contains(e.target)) {
    popup.style.display = "none";
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
    submit_button_name: "remove-subj",
    subj_name: subjName,
    
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