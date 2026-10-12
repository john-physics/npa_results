<?php
/*
 * PWA Diagnostic Tool
 *
 * Attach/include this file at the bottom of a page while diagnosing
 * PWA installation problems. Remove it when diagnosis is complete.
 */
?>

<div id="pwa-diagnostic"
     style="
        position:fixed;
        bottom:10px;
        left:10px;
        right:10px;
        max-width:600px;
        margin:auto;
        background:#111;
        color:#fff;
        padding:15px;
        border-radius:12px;
        z-index:999999;
        font-family:Arial,sans-serif;
        font-size:13px;
        box-shadow:0 5px 30px rgba(0,0,0,.5);
     ">

    <div style="
        font-size:17px;
        font-weight:bold;
        margin-bottom:10px;
    ">
        PWA Diagnostic
    </div>

    <div id="pwa-diagnostic-results">
        Running diagnostics...
    </div>

</div>

<script>
(function(){

    const box = document.getElementById("pwa-diagnostic-results");

    if(!box){
        return;
    }

    const results = [];

    function addResult(label, status, message){

        let symbol = "✓";
        let color = "#00e676";

        if(status === "error"){
            symbol = "✗";
            color = "#ff5252";
        }

        if(status === "warning"){
            symbol = "!";
            color = "#ffc107";
        }

        results.push(`
            <div style="margin:6px 0;line-height:1.5;">
                <span style="
                    color:${color};
                    font-weight:bold;
                    font-size:15px;
                ">${symbol}</span>

                <strong>${label}:</strong>

                <span style="color:#ddd">${message}</span>
            </div>
        `);

        box.innerHTML = results.join("");
    }


    /*
     * 1. Secure context
     */

    if(window.isSecureContext){

        addResult(
            "Secure context",
            "ok",
            "YES"
        );

    }else{

        addResult(
            "Secure context",
            "error",
            "NO — PWA installation requires HTTPS."
        );

    }


    /*
     * 2. Service Worker API
     */

    if("serviceWorker" in navigator){

        addResult(
            "Service Worker API",
            "ok",
            "YES"
        );

    }else{

        addResult(
            "Service Worker API",
            "error",
            "NOT AVAILABLE"
        );

    }


    /*
     * 3. Service Worker registration
     */

    async function checkServiceWorker(){

        if(!("serviceWorker" in navigator)){
            return;
        }

        try{

            const registration =
                await navigator.serviceWorker.getRegistration("/");


            if(registration){

                addResult(
                    "Service Worker registration",
                    "ok",
                    "FOUND — " +
                    registration.scope
                );

            }else{

                addResult(
                    "Service Worker registration",
                    "error",
                    "NOT FOUND"
                );

            }


            /*
             * Controller
             */

            if(navigator.serviceWorker.controller){

                addResult(
                    "Service Worker controller",
                    "ok",
                    "YES"
                );

            }else{

                addResult(
                    "Service Worker controller",
                    "warning",
                    "NO — reload the page after the worker activates."
                );

            }


            /*
             * Worker state
             */

            if(registration){

                const worker =
                    registration.active ||
                    registration.waiting ||
                    registration.installing;

                if(worker){

                    addResult(
                        "Service Worker state",
                        "ok",
                        worker.state.toUpperCase()
                    );

                }else{

                    addResult(
                        "Service Worker state",
                        "warning",
                        "NO ACTIVE/WAITING/INSTALLING WORKER"
                    );

                }

            }

        }catch(error){

            addResult(
                "Service Worker",
                "error",
                error.message
            );

        }

    }


    /*
     * 4. Standalone
     */

    const standalone =
        window.matchMedia(
            "(display-mode: standalone)"
        ).matches ||
        window.navigator.standalone === true;


    if(standalone){

        addResult(
            "Standalone",
            "ok",
            "YES — running as installed app."
        );

    }else{

        addResult(
            "Standalone",
            "warning",
            "NO — currently running in browser."
        );

    }
    
        /*
     * 5. Manifest
     */

    async function checkManifest(){

        try{

            const response =
                await fetch(
                    "/manifest.json",
                    {
                        cache:"no-store"
                    }
                );


            if(!response.ok){

                addResult(
                    "Manifest",
                    "error",
                    "HTTP " + response.status
                );

                return;

            }


            addResult(
                "Manifest",
                "ok",
                "HTTP 200 OK"
            );


            let manifest;

            try{

                manifest =
                    await response.json();

            }catch(error){

                addResult(
                    "Manifest JSON",
                    "error",
                    "Invalid JSON"
                );

                return;

            }


            /*
             * Name
             */

            if(manifest.name){

                addResult(
                    "Manifest name",
                    "ok",
                    manifest.name
                );

            }else{

                addResult(
                    "Manifest name",
                    "error",
                    "Missing"
                );

            }


            /*
             * Start URL
             */

            if(manifest.start_url){

                addResult(
                    "Start URL",
                    "ok",
                    manifest.start_url
                );

                checkUrl(
                    manifest.start_url,
                    "Start URL response"
                );

            }else{

                addResult(
                    "Start URL",
                    "error",
                    "Missing"
                );

            }


            /*
             * Scope
             */

            if(manifest.scope){

                addResult(
                    "Scope",
                    "ok",
                    manifest.scope
                );

            }else{

                addResult(
                    "Scope",
                    "warning",
                    "Not specified"
                );

            }


            /*
             * Display
             */

            if(
                manifest.display === "standalone" ||
                manifest.display === "fullscreen" ||
                manifest.display === "minimal-ui"
            ){

                addResult(
                    "Display",
                    "ok",
                    manifest.display
                );

            }else{

                addResult(
                    "Display",
                    "warning",
                    manifest.display || "Missing"
                );

            }


            /*
             * Theme color
             */

            if(manifest.theme_color){

                addResult(
                    "Theme color",
                    "ok",
                    manifest.theme_color
                );

            }else{

                addResult(
                    "Theme color",
                    "warning",
                    "Not specified"
                );

            }


            /*
             * Background color
             */

            if(manifest.background_color){

                addResult(
                    "Background color",
                    "ok",
                    manifest.background_color
                );

            }else{

                addResult(
                    "Background color",
                    "warning",
                    "Not specified"
                );

            }


            /*
             * Icons
             */

            if(Array.isArray(manifest.icons)){

                addResult(
                    "Manifest icons",
                    manifest.icons.length >= 2
                        ? "ok"
                        : "warning",
                    manifest.icons.length + " found"
                );


                const icon192 =
                    manifest.icons.find(function(icon){

                        return icon.sizes &&
                               icon.sizes
                                   .split(/\s+/)
                                   .includes("192x192");

                    });


                const icon512 =
                    manifest.icons.find(function(icon){

                        return icon.sizes &&
                               icon.sizes
                                   .split(/\s+/)
                                   .includes("512x512");

                    });


                if(icon192 && icon192.src){

                    checkIcon(
                        icon192.src,
                        "192×192 icon"
                    );

                }else{

                    addResult(
                        "192×192 icon",
                        "error",
                        "Not declared in manifest"
                    );

                }


                if(icon512 && icon512.src){

                    checkIcon(
                        icon512.src,
                        "512×512 icon"
                    );

                }else{

                    addResult(
                        "512×512 icon",
                        "error",
                        "Not declared in manifest"
                    );

                }


            }else{

                addResult(
                    "Manifest icons",
                    "error",
                    "Icons missing"
                );

            }


        }catch(error){

            addResult(
                "Manifest",
                "error",
                error.message
            );

        }

    }


    /*
     * 6. Check icon
     */

    async function checkIcon(url,label){

        try{

            const response =
                await fetch(
                    url,
                    {
                        method:"HEAD",
                        cache:"no-store"
                    }
                );


            if(response.ok){

                addResult(
                    label,
                    "ok",
                    "HTTP " + response.status
                );

            }else{

                addResult(
                    label,
                    "error",
                    "HTTP " + response.status
                );

            }


        }catch(error){

            addResult(
                label,
                "error",
                "Cannot access icon"
            );

        }

    }


    /*
     * 7. Check URL
     */

    async function checkUrl(url,label){

        try{

            const response =
                await fetch(
                    url,
                    {
                        method:"HEAD",
                        cache:"no-store"
                    }
                );


            if(response.ok){

                addResult(
                    label,
                    "ok",
                    "HTTP " + response.status
                );

            }else{

                addResult(
                    label,
                    "error",
                    "HTTP " + response.status
                );

            }


        }catch(error){

            /*
             * Some servers do not support HEAD.
             * Try GET before reporting an error.
             */

            try{

                const response =
                    await fetch(
                        url,
                        {
                            method:"GET",
                            cache:"no-store"
                        }
                    );


                if(response.ok){

                    addResult(
                        label,
                        "ok",
                        "HTTP " + response.status
                    );

                }else{

                    addResult(
                        label,
                        "error",
                        "HTTP " + response.status
                    );

                }


            }catch(error2){

                addResult(
                    label,
                    "error",
                    "Cannot access URL"
                );

            }

        }

    }
    
        /*
     * 8. beforeinstallprompt
     */

    let installPromptReceived = false;


    window.addEventListener(
        "beforeinstallprompt",
        function(event){

            installPromptReceived = true;


            addResult(
                "beforeinstallprompt",
                "ok",
                "FIRED — browser says the app can be installed."
            );

        }
    );


    /*
     * If the event does not fire immediately,
     * wait a little before reporting it.
     */

    setTimeout(function(){

        if(!installPromptReceived){

            addResult(
                "beforeinstallprompt",
                "warning",
                "Waiting — browser has not offered installation yet."
            );

        }

    },3000);


    /*
     * 9. appinstalled
     */

    window.addEventListener(
        "appinstalled",
        function(){

            addResult(
                "Installation",
                "ok",
                "APP INSTALLED"
            );

        }
    );


    /*
     * 10. Network
     */

    function checkNetwork(){

        if(navigator.onLine){

            addResult(
                "Network",
                "ok",
                "ONLINE"
            );

        }else{

            addResult(
                "Network",
                "warning",
                "OFFLINE"
            );

        }

    }


    window.addEventListener(
        "online",
        checkNetwork
    );


    window.addEventListener(
        "offline",
        checkNetwork
    );


    /*
     * 11. Browser information
     */

    const userAgent =
        navigator.userAgent;


    let browser = "Unknown";


    if(userAgent.includes("Edg/")){

        browser = "Microsoft Edge";

    }else if(userAgent.includes("Chrome/")){

        browser = "Google Chrome";

    }else if(userAgent.includes("Firefox/")){

        browser = "Mozilla Firefox";

    }else if(userAgent.includes("Safari/")){

        browser = "Safari";

    }


    addResult(
        "Browser",
        "ok",
        browser
    );


    /*
     * 12. HTTPS / localhost
     */

    const protocol =
        window.location.protocol;

    const hostname =
        window.location.hostname;


    if(
        protocol === "https:" ||
        hostname === "localhost" ||
        hostname === "127.0.0.1"
    ){

        addResult(
            "PWA security origin",
            "ok",
            protocol === "https:"
                ? "HTTPS"
                : "LOCALHOST"
        );

    }else{

        addResult(
            "PWA security origin",
            "error",
            "Not HTTPS or localhost"
        );

    }


    /*
     * 13. Service Worker update status
     */

    async function checkServiceWorkerUpdate(){

        if(!("serviceWorker" in navigator)){
            return;
        }

        try{

            const registration =
                await navigator.serviceWorker.getRegistration("/");


            if(!registration){
                return;
            }


            if(registration.waiting){

                addResult(
                    "Service Worker update",
                    "warning",
                    "NEW WORKER WAITING"
                );

            }else{

                addResult(
                    "Service Worker update",
                    "ok",
                    "NO UPDATE WAITING"
                );

            }


        }catch(error){

            addResult(
                "Service Worker update",
                "warning",
                "Unable to check"
            );

        }

    }


    /*
     * Run diagnostics
     */

    checkNetwork();

    checkServiceWorker();

    checkServiceWorkerUpdate();

    checkManifest();


})();
</script>