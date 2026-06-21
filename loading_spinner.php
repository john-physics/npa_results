<?php

echo '<style>
/* Loading spinner overlay */
.spinner-overlay {
    display: none; /* Initially hidden */
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    justify-content: center;
    align-items: center;
    border-radius: 10px;
}

.spinner {
    border: 6px solid #f3f3f3;
    border-top: 6px solid #007BFF;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 0.5s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
 
</style>';

echo ' <!-- Loading Spinner -->
       <div id="loading-spinner" class="spinner-overlay">
         <div class="spinner"></div>
         </div>';
        
     