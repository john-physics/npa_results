<?php

echo '<!-- Popup Overlay -->
<div id="pinPopup" class="pinpup-overlay">
  <div class="popup-box">
    <h3>Regenerate PIN</h3>
    <p id="popupText"></p>

    <div class="pinpup-actions">
     <button type="button" id="cancelpinBtn">Cancel</button>
      <button type="button" onclick="proceedBtn()" id="proceedBtn">Proceed</button>
    </div>
   
    <div id="spinner"></div>
     <small id="prep1">Regenerating PIN, please wait...</small>

  </div>
</div>

<style>
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
   cursor:pointer;
   
}

.pinpup-actions #cancelpinBtn{
  background: #f44336;
 
}

.pinpup-actions #proceedBtn{
  background:  #4caf50;

}

</style>


<script>

let selectedPinElement = null;
let selectedStudentId = null;
let selectedStudentName = null;

/* DOUBLE CLICK (Desktop) */
document.addEventListener("dblclick", function(e) {
  if (e.target.classList.contains("pink_status")) {
    triggerPopup(e.target);
  }
});

/* DOUBLE TAP (Mobile) */
let lastTap = 0;

document.addEventListener("touchend", function(e) {
  let currentTime = new Date().getTime();
  let tapLength = currentTime - lastTap;

  if (tapLength < 300 && tapLength > 0) {
    if (e.target.classList.contains("pink_status")) {
      triggerPopup(e.target);
    }
  }

  lastTap = currentTime;
});

/* SHOW POPUP */
function triggerPopup(element) {
  selectedPinElement = element;


  selectedStudentId = element.dataset.id;
  selectedStudentName = element.dataset.name;

  document.getElementById("popupText").innerHTML =
    `By clicking Proceed, a new result checking pin for <b>${selectedStudentName}</b> will be regenerated, which will overwrite the existing one.<br><br>Do you want to proceed?`;

  document.getElementById("pinPopup").style.display = "flex";
  
  document.getElementById("about").style.display ="none";

}


/* CANCEL BUTTON */

 document.getElementById("cancelpinBtn").addEventListener("click",(e)=>{

 document.getElementById("pinPopup").style.display = "none";   
 
  document.getElementById("about").style.display ="block";

}); 


const popup = document.getElementById("pinPopup");
const popupBox = document.querySelector(".popup-box");

/* Close when clicking outside the popup box */
popup.addEventListener("click", function(e) {
  if (!popupBox.contains(e.target)) {
    popup.style.display = "none";
   
  document.getElementById("about").style.display ="block";
 
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
    submit_button_name: "regenerate-result-pin",
    std_id: selectedStudentId,
    
  })
})
  .then(res => res.json())
  .then(data => {

   spinner.style.display= "none";  
  prep1.style.display = "none";
   
    if (data.status === "success") {
      
      // Update UI
  selectedPinElement.innerText = data.new_pin;

  showToast(data.message);
     
document.getElementById("pinPopup").style.display = "none";

document.getElementById("about").style.display ="block";
   
    } else {
      
 showError(data.message,data.error);  
  document.getElementById("pinPopup").style.display = "none";
 
 document.getElementById("about").style.display ="block";
 
    }

  })
  .catch(error => {
    
    showError(error,"Ajax Error");  
  document.getElementById("pinPopup").style.display = "none";
  document.getElementById("about").style.display ="block";
 
  });  
    
    
}


</script>';