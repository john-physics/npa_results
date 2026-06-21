let pdfNum = 0;
let pagesRendered = 0;
let pdfLoading = true; // Flag to track if PDF is still loading
let pdfDocument = null; // Reference to the PDF document
let abortController = null; // Add AbortController to cancel PHP requests

const url = document.getElementById("calendar_url").value;

const pdfjsLib = window["pdfjs-dist/build/pdf"];
pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.worker.min.js";

const viewer = document.getElementById("pdf-viewer");
const calendarSpinner = document.getElementById("calendar_spinner");

// Set timeout to check after 30 seconds
const loadingTimeout = setTimeout(function() {
    if (pdfLoading && pagesRendered < pdfNum) {
        stopPdfLoading();
        
        const errorMsg = "Failed to load calendar due to network fluctuation, please scroll down and use the download link";
        const errorType = "Time out";
        showError(errorMsg, errorType);
     
        calendarSpinner.style.display ="none";
        viewer.innerHTML = "<span style=\'color:red; position:relative;top:50px;text-align:center;\'>Failed to load calendar !</span>";    
        
    }
}, 2000);

// Function to stop PDF loading - NOW WITH REQUEST CANCELLATION
function stopPdfLoading() {
    pdfLoading = false;
    
    // CANCEL THE PHP REQUEST - This frees server resources
    if (abortController) {
        abortController.abort();
        console.log("PDF request cancelled - server resources freed");
    }
    
    // Destroy the PDF document if it exists
    if (pdfDocument) {
        pdfDocument.destroy().catch(function() {
            // Silently handle destroy errors
        });
    }
    
    // Clear any pending promises
    clearTimeout(loadingTimeout);
    
    // Clear the viewer content
    viewer.innerHTML = "";
}

// Listen for clicks anywhere on the window
window.addEventListener("click", function(event) {
    // If PDF is still loading and user clicks outside the PDF viewer
    if (pdfLoading && !viewer.contains(event.target)) {
        const DwnLink = document.getElementById("dwn_ass"); 
        const ShareLink = document.getElementById("share_cert"); 
        
        // FIRST: Stop PDF loading for any click outside viewer
        stopPdfLoading(); 
        calendarSpinner.style.display = "none";
        
        // THEN: Check if click was on download/share links
        const isDownloadLink = DwnLink && DwnLink.contains(event.target);
        const isShareLink = ShareLink && ShareLink.contains(event.target);
        
        // Only show error if NOT clicked on download/share links
        if (!isDownloadLink && !isShareLink) {
            showToast("Calendar loading cancelled");
            viewer.innerHTML = "<span style=\'color:red; position:relative;top:50px;text-align:center;\'>Calendar loading cancelled ! <br>Please refresh the page to load Calendar again.</span>";    
        }
        // If it was download/share links, keep silent (no error message)
    }
});

window.addEventListener("beforeunload", function(event) {
     // Check if  a page reload
   const isReload = performance.navigation.type === 1;
    
    if (pdfLoading && !isReload) {
        stopPdfLoading();
        showToast("Calendar loading cancelled");
    }
});

// Start loading the PDF with AbortController
abortController = new AbortController();

pdfjsLib.getDocument({
    url: url,
    signal: abortController.signal // Pass the abort signal to cancel the request
}).promise.then(function(pdf) {
    pdfDocument = pdf; // Store reference for potential destruction
    pdfNum = pdf.numPages;
    
    // If no pages, hide spinner immediately
    if (pdfNum === 0) {
        pdfLoading = false;
        calendarSpinner.style.display = "none";
        clearTimeout(loadingTimeout);
        return;
    }
    
    for (let i = 1; i <= pdf.numPages; i++) {
        // Check if loading was stopped before processing each page
        if (!pdfLoading) {
            return;
        }
        
        pdf.getPage(i).then(function(page) {
            // Check again if loading was stopped
            if (!pdfLoading) {
                return;
            }
            
            const canvas = document.createElement("canvas");
            viewer.appendChild(canvas);
            const context = canvas.getContext("2d");

            const scale = 1.5;
            const viewport = page.getViewport({ scale: scale });

            const outputScale = window.devicePixelRatio || 1;
            canvas.width = viewport.width * outputScale;
            canvas.height = viewport.height * outputScale;
            canvas.style.width = viewport.width + "px";
            canvas.style.height = viewport.height + "px";

            const transform = outputScale !== 1
                ? [outputScale, 0, 0, outputScale, 0, 0]
                : null;

            page.render({
                canvasContext: context,
                viewport: viewport,
                transform: transform
            }).promise.then(function() {
                pagesRendered++;
                
                // Check if all pages are rendered
                if (pagesRendered === pdf.numPages) {
                    calendarSpinner.style.display = "none";
                    pdfLoading = false;          
                    // Clear any pending promises
                    clearTimeout(loadingTimeout);
                    return;
                }
            }).catch(function(error) {
                // Handle render errors for individual pages
                if (pdfLoading) {
                    console.error("Error rendering page:", error);
                    showToast(error);  
                }
            });
            
        }).catch(function(error) {
            // Handle page loading errors
            if (pdfLoading) {
                console.error("Error loading page:", error);
                showToast(error);     
            }
        });
    }
}).catch(function(error) {
    // Check if error is from cancellation (normal behavior)
   stopPdfLoading();  
    if (error.name === "AbortError") {
        console.log("PDF loading was cancelled by user");
        // Don't show error message for normal cancellations
        return;
    }
    
    // Only show error for actual failures, not user cancellations
    
    calendarSpinner.style.display ="none"; 
    viewer.innerHTML = "<span style=\'color:red; position:relative;top:50px;text-align:center;\'>Failed to load calendar. Please try again later.</span>";    
    showError("Error loading PDF: " + error, "Ajax Error");
});


 const shareCal = document.getElementById("share_cert");
 
 const dwnCal = document.getElementById("dwn_ass");
 
 shareCal.addEventListener("click",(e)=>{

e.preventDefault();

document.getElementById("pdf-viewer").innerHTML = "<span style=\'color:lightblue; font-weight:bold;position:relative;top:50px;text-align:center;\'>Sharing Calendar, Please wait...</span>";    

const shareSpinner = document.getElementById("share-spinner");
const link = document.getElementById("cal_link").value;
const shareTitle = document.getElementById("share_title").value;
const shareText = document.getElementById("share_text").value;

shareSpinner.style.display = "flex";

setTimeout(()=>{

shareSpinner.style.display = "none";    
    
},3000);
  
  
 shareLink(link, shareTitle, shareText);   
 });
 
 
dwnCal.addEventListener("click",(e)=>{
 
 document.getElementById("pdf-viewer").innerHTML = "<span style=\'color:lightblue; position:relative;top:50px;text-align:center;font-weight:bold;\'>Downloading Calendar, Please wait...</span>";
 
 const dwnSpinner = document.getElementById("dwn-spinner");
 
dwnSpinner.style.display = "flex";

setTimeout(()=>{

dwnSpinner.style.display = "none";    
    
},5000);   
    
});
 