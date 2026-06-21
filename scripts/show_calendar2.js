let pdfNum = 0;
let pagesRendered = 0;
let pdfLoading = true;
let pdfDocument = null;
let abortController = null;
let loadingTimeout = null; // Make this a variable so we can clear it properly

const url = document.getElementById("calendar_url").value;

const pdfjsLib = window["pdfjs-dist/build/pdf"];
pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.14.305/pdf.worker.min.js";

const viewer = document.getElementById("pdf-viewer");
const calendarSpinner = document.getElementById("calendar_spinner");

// Function to stop PDF loading
function stopPdfLoading() {
    pdfLoading = false;
    
    // CANCEL THE PHP REQUEST
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
    
    // Clear timeout
    if (loadingTimeout) {
        clearTimeout(loadingTimeout);
    }
    
    // Clear the viewer content
    viewer.innerHTML = "";
}

// Function to start timeout countdown
function startTimeoutTimer() {
    if (loadingTimeout) {
        clearTimeout(loadingTimeout); // Clear any existing timeout
    }
    
    loadingTimeout = setTimeout(function() {
        if (pdfLoading && pagesRendered < pdfNum) {
            console.log("Timeout reached - stopping PDF loading");
            stopPdfLoading();
            
            const errorMsg = "Failed to load calendar due to network fluctuation, please scroll down and use the download link";
            const errorType = "Time out";
            showError(errorMsg, errorType);
         
            calendarSpinner.style.display = "none";
            viewer.innerHTML = "<span style='color:red; position:relative;top:50px;text-align:center;'>Failed to load calendar !</span>";    
        }
    }, 20000); // 20 seconds timeout
}

// Listen for clicks anywhere on the window
window.addEventListener("click", function(event) {
    if (pdfLoading && !viewer.contains(event.target)) {
        const DwnLink = document.getElementById("dwn_ass"); 
        const ShareLink = document.getElementById("share_cert"); 
        
        stopPdfLoading(); 
        calendarSpinner.style.display = "none";
        
        const isDownloadLink = DwnLink && DwnLink.contains(event.target);
        const isShareLink = ShareLink && ShareLink.contains(event.target);
        
        if (!isDownloadLink && !isShareLink) {
            showToast("Calendar loading cancelled");
            viewer.innerHTML = "<span style='color:red; position:relative;top:50px;text-align:center;'>Calendar loading cancelled ! <br>Please refresh the page to load Calendar again.</span>";    
        }
    }
});

window.addEventListener("beforeunload", function(event) {
    const isReload = performance.navigation.type === 1;
    
    if (pdfLoading && !isReload) {
        stopPdfLoading();
        showToast("Calendar loading cancelled");
    }
});

// Start loading the PDF
abortController = new AbortController();

// START THE TIMEOUT WHEN PDF LOADING ACTUALLY STARTS
startTimeoutTimer();

pdfjsLib.getDocument({
    url: url,
    signal: abortController.signal
}).promise.then(function(pdf) {
    pdfDocument = pdf;
    pdfNum = pdf.numPages;
    
    console.log("PDF loaded, pages: " + pdfNum);
    
    if (pdfNum === 0) {
        stopPdfLoading();
        calendarSpinner.style.display = "none";
        return;
    }
    
    for (let i = 1; i <= pdf.numPages; i++) {
        if (!pdfLoading) {
            return;
        }
        
        pdf.getPage(i).then(function(page) {
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
                console.log("Page " + pagesRendered + " rendered of " + pdfNum);
                
                if (pagesRendered === pdf.numPages) {
                    calendarSpinner.style.display = "none";
                    pdfLoading = false;          
                    if (loadingTimeout) {
                        clearTimeout(loadingTimeout);
                    }
                    console.log("All pages rendered successfully");
                }
            }).catch(function(error) {
                if (pdfLoading) {
                    console.error("Error rendering page:", error);
                    showToast(error);  
                }
            });
            
        }).catch(function(error) {
            if (pdfLoading) {
                console.error("Error loading page:", error);
                showToast(error);     
            }
        });
    }
}).catch(function(error) {
      stopPdfLoading(); 
    if (error.name === 'AbortError') {
        console.log('PDF loading was cancelled by user');
        return;
    }
    
    console.error("PDF loading failed:", error);
  
    calendarSpinner.style.display = "none"; 
    viewer.innerHTML = "<span style='color:red; position:relative;top:50px;text-align:center;'>Failed to load calendar. Please try again later.</span>";    
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
 