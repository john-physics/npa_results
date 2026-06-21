<?php

?>

<style>
  /* Error overlay styles */
  #errorOverlay {
    position: fixed;
    bottom: -100%; /* hidden initially */
    left: 0;
    width: 100%;
    background: #fff5f5; /* soft red background */
    color: #a30000;      /* dark red text */
    border-top: 3px solid #a30000;
    box-shadow: 0 -4px 8px rgba(0,0,0,0.25);
    padding: 10px;
    font-size: 10px;
    line-height: 1.5;
    text-align: justify;
    transition: bottom 0.4s ease-in-out;
    z-index: 9999;
  }

  #errorOverlay.active {
    bottom: 0; /* slides up when active */
  }

  #errorOverlay h3 {
    margin: 0 0 5px;
    font-size: 12px;
    color: #a30000;
    font-weight: bold;
  }

  #closeError {
    position:absolute;
    right:20px; top:2px;
    cursor: pointer;
    color: #a30000;
    font-size: 14px;
    font-weight: bold;
    display: block;
    border:1px solid #fff;
    border-radius: 5px;
    padding:2px;
    width:50px;
    text-align:center;
    background:rgba(250,100,50,0.8);
    color:#fff;
    
  }

 /* Code Overlay */
  #codeOverlay {
    position: fixed;
    bottom: -100%;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 800px;
    max-height: 75vh;
    background: #1e1e1e;
    color: #f1f1f1;
    border-radius: 10px 10px 0 0;
    box-shadow: 0 -6px 12px rgba(0,0,0,0.5);
    font-size: 10px;
    line-height: 1.4;
    transition: bottom 0.4s ease-in-out, opacity 0.3s ease-in-out;
    z-index: 99999;
    opacity: 0;
    display: flex;
    flex-direction: column;
    
  }

  #codeOverlay.active {
    bottom: 10%;
    opacity: 1;
  }

  /* Buttons container (always visible at top) */
  .overlay-buttons {
    flex-shrink: 0;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    padding: 10px;
    background: #252525;
    border-radius: 10px 10px 0 0;
    border-bottom: 1px solid #333;
    position: sticky;
    top: 0;
    z-index: 1;
  }

  .overlay-buttons button {
    border: none;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background 0.3s;
  }

  .copy-btn {
    background: #2d8cf0;
    color: #fff;
  }
  .copy-btn:hover { background: #1768c4; }

  .close-btn {
    background: #ff4d4f;
    color: #fff;
  }
  .close-btn:hover { background: #c9302c; }

  /* Scrollable code section */
  .code-box {
    flex-grow: 1;
    overflow-y: auto;
    overflow-x: auto;
    padding: 15px;
  }

  .code-box pre {
    margin: 0;
    background: transparent;
    color: #dcdcdc;
    white-space: pre-wrap;
    word-break: break-word;
  }
     
.toast {
 display:block;
  visibility: hidden;
  width: 60%;
 /*  min-width: 250px; */
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 8px;
  padding: 16px;
  position: fixed;
  z-index: 9999;
  bottom: 5%;
  right:20%; 
  margin:auto;
  font-size: 12px;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
  opacity: 0;
  transition: opacity 0.4s ease, transform 0.4s ease;
}

.toast.show {
 
  visibility: visible;
  opacity: 1;
  transform: translateY(-10px);
} 
</style>

<!-- Error log container -->
<div id="errorOverlay" class="errorlog">
  <span id="closeError">&times;</span>
  <h3>Error Log</h3>
  <div id="errorMessage"></div>
</div>

<!-- Toast div -->
<div id="toast" class="toast">This is a toast message for notification</div>
 
 
<script>
  // Function to show error overlay
  function showError(message, type="General Error") {
    let overlay = document.getElementById("errorOverlay");
    let msgBox = document.getElementById("errorMessage");

    msgBox.innerHTML = `<strong>${type}:</strong> ${message}`;
    overlay.classList.add("active");
  }

  // Close button handler
  document.getElementById("closeError").onclick = function() {
    document.getElementById("errorOverlay").classList.remove("active");
  };

  // Example usage (uncomment to test)
  //showError("This is a test error message. Something went wrong while processing your request", "Runtime Error");
</script>

<script>
  // Open overlay
  function openCodeOverlay(code="") {
    let overlay = document.getElementById("codeOverlay");
    if(code) document.getElementById("codeContent").innerText = code;
    overlay.classList.add("active");
  }

  // Close overlay
  function closeCodeOverlay() {
    let overlay = document.getElementById("codeOverlay");
    overlay.classList.remove("active");
  }

  // Copy code
  function copyCode() {
    let code = document.getElementById("codeContent").innerText;
    navigator.clipboard.writeText(code).then(() => {
  
   closeCodeOverlay();   
 showToast("Code copied to clipboard!"); 
      
    });
  }
</script>

<script>

  function showToast(message) {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.classList.add("show");

  setTimeout(() => {
    toast.classList.remove("show");
  }, 3000); // Hide after 3 seconds
}


function decodeHtmlEntities(text) {
  var txt = document.createElement("textarea");
  txt.innerHTML = text;
  return txt.value;
}

function formatNumber(amount, symbol = '') {
  // Ensure it's a number
  let num = parseFloat(amount);

  // Handle invalid input
  if (isNaN(num)) return '0.00';

  // Format number with commas and two decimals
  let formatted = num.toLocaleString('en-US', { 
    minimumFractionDigits: 2, 
    maximumFractionDigits: 2 
  });

  // Return with or without symbol
  return symbol ? symbol + ' '+ formatted : formatted;
}
  
function shareLink(link, shareTitle, shareText) {
  if (navigator.share) {
    navigator.share({
      title: shareTitle,
      text: shareText,
      url: link,
    }).then(() => {
  showToast('Link copied successfully !');
    }).catch((error) => {
      if (error.name !== 'AbortError') {
     showToast('Could not share link. ' + error);
      }
    });
  } else if (navigator.clipboard) {
    navigator.clipboard.writeText(link).then(() => {
  showToast('Link copied to clipboard!');
    }).catch((error) => {
     showToast('Failed to copy link. ' + error);
    });
  } else {
    showToast('Sharing not supported. Please copy the link manually.');
  }
}    
</script>
  
  
