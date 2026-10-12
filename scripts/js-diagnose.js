(function () {

    "use strict";

    /*
     * ==========================================
     * JavaScript Diagnostic Tool
     * ==========================================
     */

    const panel = document.createElement("div");

    panel.id = "js-diagnostic-panel";

    panel.innerHTML = `
        <div id="js-diagnostic-title">
            JavaScript Diagnostic
        </div>

        <div id="js-diagnostic-status">
            Checking...
        </div>

        <div id="js-diagnostic-errors"></div>
    `;

    const style = document.createElement("style");

    style.textContent = `
        #js-diagnostic-panel {
            position: fixed;
            left: 10px;
            right: 10px;
            bottom: 10px;
            z-index: 2147483647;

            padding: 14px;

            border-radius: 12px;

            font-family:
                Arial,
                sans-serif;

            font-size: 13px;

            color: #fff;

            box-shadow:
                0 5px 25px rgba(0,0,0,.35);

            transition:
                background .3s ease;
        }

        #js-diagnostic-panel.ok {
            background: #198754;
        }

        #js-diagnostic-panel.error {
            background: #dc3545;
        }

        #js-diagnostic-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        #js-diagnostic-status {
            font-weight: bold;
        }

        #js-diagnostic-errors {
            margin-top: 8px;
            max-height: 220px;
            overflow-y: auto;
        }

        .js-diagnostic-error {
            margin-top: 7px;
            padding: 8px;

            background: rgba(0,0,0,.2);

            border-radius: 7px;

            word-break: break-word;
        }

        .js-diagnostic-location {
            margin-top: 4px;
            font-size: 11px;
            opacity: .85;
        }

        #js-diagnostic-close {
            position: absolute;
            top: 8px;
            right: 10px;

            border: 0;
            background: transparent;

            color: #fff;

            font-size: 18px;

            cursor: pointer;
        }
    `;

    document.documentElement.appendChild(style);

    function showPanel() {

        if (!document.body) {
            return;
        }

        if (!document.getElementById(
            "js-diagnostic-panel"
        )) {
            document.body.appendChild(panel);
        }

    }


    function setSuccess() {

        panel.classList.remove("error");
        panel.classList.add("ok");

        document.getElementById(
            "js-diagnostic-status"
        ).textContent =
            "✓ No JavaScript errors found";

    }


    function setError(
        message,
        source,
        line,
        column
    ) {

        panel.classList.remove("ok");
        panel.classList.add("error");

        document.getElementById(
            "js-diagnostic-status"
        ).textContent =
            "✗ JavaScript error detected";

        const errors =
            document.getElementById(
                "js-diagnostic-errors"
            );

        const error =
            document.createElement("div");

        error.className =
            "js-diagnostic-error";

        error.textContent = message;

        if (source || line || column) {

            const location =
                document.createElement("div");

            location.className =
                "js-diagnostic-location";

            location.textContent =
                `${source || ""}` +
                `${line ? " : line " + line : ""}` +
                `${column ? ", column " + column : ""}`;

            error.appendChild(location);

        }

        errors.appendChild(error);

    }


    /*
     * ==========================================
     * Runtime errors
     * ==========================================
     */

    window.addEventListener(
        "error",
        function (event) {

            showPanel();

            setError(
                event.message ||
                "Unknown JavaScript error",

                event.filename,

                event.lineno,

                event.colno
            );

        }
    );


    /*
     * ==========================================
     * Promise errors
     * ==========================================
     */

    window.addEventListener(
        "unhandledrejection",
        function (event) {

            showPanel();

            let message = "Unhandled Promise rejection";

            if (event.reason) {

                if (event.reason.message) {
                    message =
                        event.reason.message;
                }

                else {
                    message =
                        String(event.reason);
                }

            }

            setError(message);

        }
    );


    /*
     * ==========================================
     * Initialize
     * ==========================================
     */

    function initialize() {

        showPanel();

        const close =
            document.createElement("button");

        close.id =
            "js-diagnostic-close";

        close.textContent = "×";

        close.title =
            "Close diagnostic";

        close.onclick = function () {
            panel.remove();
            style.remove();
        };

        panel.appendChild(close);

        /*
         * Give existing scripts a moment
         * to report errors.
         */

        setTimeout(function () {

            const hasErrors =
                panel.classList.contains("error");

            if (!hasErrors) {
                setSuccess();
            }

        }, 500);

    }


    if (document.readyState === "loading") {

        document.addEventListener(
            "DOMContentLoaded",
            initialize
        );

    }

    else {
        initialize();
    }


})();