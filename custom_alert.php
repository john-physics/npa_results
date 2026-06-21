<?php

echo '<div id="popupOverlay">
  <div class="popupContent">
    <h2 id="tittle">Alert !</h2>
    <p>
   <span id="msg1"></span>
    <br><br>
    <span id="msg2"></span>
    <br><br>
      <strong>Please Select an Action !</strong>
    </p>
    <div class="popupButtons">
     
<a class="popupBtn consultBtn" id="ActionBtn"></a>
 
 <button class="popupBtn cancelBtn" id="cancelBtn" onclick="closePopup()"></button>
    </div>
  </div>
</div>



<style>

#popupOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
  }

  .popupContent {
    background: #ffffff;
    padding: 30px;
    max-width: 500px;
    width: 90%;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    animation: fadeIn 0.5s ease;
  }

  .popupContent h2 {
    margin-top: 0;
    color: #17a2b8;
    font-size: 24px;
  }

  .popupContent p {
    color: #555555;
    font-size: 16px;
    line-height: 1.5;
  }

  .popupButtons {
    margin-top: 20px;
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
  }

  .popupBtn {
    padding: 12px 20px;
    font-size: 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-decoration: none;
    transition: background 0.3s ease;
  }

  .consultBtn {
    background-color: #007bff;
    color: #fff;
  }

  .consultBtn:hover {
    background-color: #0056b3;
  }

  .cancelBtn {
    background-color: #6c757d;
    color: #fff;
  }

  .cancelBtn:hover {
    background-color: #5a6268;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.8);}
    to { opacity: 1; transform: scale(1);}
  }
  
  </style>
  
  <script>
  
  function showAlert(tittle,msg1,msg2,link,cancel,linkLabel, cancelLabel,save){
  
   window.safeExit = save; 
   document.getElementById("popupOverlay").style.display = "flex";   
       
  document.getElementById("tittle").innerText = tittle;   
         
 document.getElementById("msg1").innerText = msg1;   

 document.getElementById("msg2").innerText = msg2;        
    
  document.getElementById("ActionBtn").innerText = linkLabel;      
   
  document.getElementById("cancelBtn").innerText = cancelLabel;  
  
  document.getElementById("ActionBtn").href = link;      
   
  document.getElementById("cancelBtn").value = cancel;  
 
  }
  

  function closePopup() {
   
   window.safeExit = false;
   const cancelLink =  document.getElementById("cancelBtn").value;
   
   document.getElementById("popupOverlay").style.display = "none";    
      
   
  if(cancelLink){
  window.safeExit = true;
  window.location.href = cancelLink;
   }
 }
  </script>';