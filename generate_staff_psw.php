<?php

require 'page_init.php';

if(!check_staff_login($conn)){
 header("Location:/home");
 die();
 
}

$staffCat = trim($_SESSION["staff_cat"] ?? "");

if (!in_array($staffCat, $ictdepartment, true)) {
  
    http_response_code(403);
  $message = "The page you are trying to access is restricted to authorized ICT officers of the school only.";
  
  header("Location:/home?msg-report=".$message."&report=failed");
 die();
  
}



head('Generate Staff Password',"$site | Generate Staff Password","Staff-Psw");

require 'menu.php';


?>



<style>
:root {
    --primary: #8a1f45;
    --primary-light: #f9edf2;
    --text: #26232a;
    --muted: #77717a;
    --border: #e8e2e6;
    --danger: #b42318;
    --success: #18794e;
}


.psw-container {
    max-width: 520px;
    margin: 35px auto;
}

.header {
    text-align: center;
    margin-bottom: 24px;
}

.header h2 {
    margin: 0 0 8px;
    font-size: 24px;
    text-decoration: none;
    font-weight: bold;
}

.header p {
    margin: 0;
    color: var(--muted);
    line-height: 1.6;
    font-size: 14px;
}

.card {
    background: white;
    padding: 25px;
    border: 1px solid var(--border);
    border-radius: 18px;
    box-shadow: 0 8px 28px rgba(40, 20, 30, 0.05);
    width: 90%;
    max-width: 600;
    margin: auto;
}

.notice {
    display: none;
    margin-bottom: 18px;
    padding: 13px 15px;
    border-radius: 10px;
    font-size: 14px;
    line-height: 1.5;
}

.notice.error {
    display: block;
    color: var(--danger);
    background: #fff0ef;
    border: 1px solid #f4d0cd;
}

.notice.success {
    display: block;
    color: var(--success);
    background: #edfbf3;
    border: 1px solid #ccebd9;
}

.gen_psw label {
    display: block;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 9px;
}

.gen_psw input {
    width: 100%;
    min-height: 48px;
    padding: 12px 14px;
    border: 1px solid #dcd4da;
    border-radius: 10px;
    outline: none;
    font-size: 15px;
    background: white;
}

.gen_psw input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(138, 31, 69, .09);
}

.gen_psw button {
    font-family: inherit;
    cursor: pointer;
    transition: transform .15s, opacity .15s, background .2s;
}

.gen_psw button:active {
    transform: scale(.98);
}

.gen_psw button:disabled {
    opacity: .6;
    cursor: not-allowed;
}

.primary-btn {
    width: 100%;
    min-height: 48px;
    margin-top: 17px;
    border: 0;
    border-radius: 10px;
    color: white;
    background: var(--primary);
    font-size: 15px;
    font-weight: bold;
}

.primary-btn:hover {
    background: #701736;
}

.secondary-btn {
    width: 100%;
    margin-top: 12px;
    min-height: 45px;
    border: 1px solid #e5cbd5;
    border-radius: 10px;
    background: var(--primary-light);
    color: var(--primary);
    font-weight: bold;
    font-size: 14px;
}

.help-text {
    color: var(--muted);
    font-size: 10px;
    line-height: 1.6;
    margin: 16px 0 0;
    text-align: justify;
}

/* Modal */

.modal {
    position: fixed;
    inset: 0;
    z-index: 1000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 18px;
    background: rgba(24, 13, 19, .6);
    backdrop-filter: blur(4px);
}

.modal.open {
    display: flex;
    animation: fadeIn .2s ease;
}

.modal-box {
    width: 100%;
    max-width: 430px;
    padding: 27px;
    border-radius: 20px;
    background: white;
    text-align: center;
    box-shadow: 0 20px 70px rgba(0,0,0,.2);
    animation: popIn .28s ease;
}

.modal-icon {
    display: grid;
    place-items: center;
    width: 58px;
    height: 58px;
    margin: 0 auto 16px;
    border-radius: 50%;
    color: var(--success);
    background: #e8f8ef;
    font-size: 28px;
}

.modal-box h3 {
    margin: 0 0 10px;
    font-size: 22px;
    color: rgb(10,150,50);
    font-weight: 600;
}

.modal-box p {
    margin: 0 0 20px;
    color: var(--muted);
    font-size: 14px;
    line-height: 1.6;
}

.password-box {
    padding: 16px 12px;
    border: 1px dashed #d7a7b8;
    background: var(--primary-light);
    border-radius: 12px;
    margin-bottom: 20px;
    overflow-wrap: anywhere;
}

.password-value {
    color: var(--primary);
    font-size: 21px;
    font-weight: bold;
    letter-spacing: 1px;
    user-select: text;
}

.gen_psw .close-btn {
    width: 100%;
    min-height: 47px;
    background: var(--primary);
    color: white;
    border: 0;
    border-radius: 10px;
    font-weight: bold;
    font-size: 15px;
}

/* Staff email picker */

.search-wrap {
    margin-bottom: 15px;
}

.staff-list {
    max-height: 300px;
    overflow-y: auto;
    text-align: left;
    border: 1px solid var(--border);
    border-radius: 10px;
}

.staff-item {
    display: block;
    width: 100%;
    padding: 14px;
    background: white;
    border: 0;
    border-bottom: 1px solid #f0ebee;
    text-align: left;
    overflow-wrap: anywhere;
    font-size: 14px;
}

.staff-item:last-child {
    border-bottom: 0;
}

.staff-item:hover {
    background: var(--primary-light);
    color: var(--primary);
}

.list-message {
    padding: 20px 10px;
    color: var(--muted);
    font-size: 14px;
    text-align: center;
}

.spinner {
    display: inline-block;
    width: 16px;
    height: 16px;
    margin-left: 8px;
    vertical-align: middle;
    border: 2px solid rgba(255, 255, 255, 0.4);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin .7s linear infinite;
}

.spinner[hidden] {
    display: none;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}


@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popIn {
    from {
        opacity: 0;
        transform: translateY(15px) scale(.96);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

@media (max-width: 420px) {
    .card { padding: 20px; }
    .modal-box { padding: 23px 18px; }
}
</style>
</head>

<body>
    
<section class="gen_psw">

<div class="psw-container">

    <div class="header">
        <h2>Staff Password Recovery</h2>
        <p>
            NPA Results Management System<br>
            ICT Department Use Only
        </p>
    </div>

    <div class="card">

        <!-- Errors and other messages appear above the form -->
        <div id="notice" class="notice" role="alert"
             aria-live="polite"></div>

        <form id="passwordForm" class="passwordForm">

            <label for="staffEmail">Staff Email Address</label>

            <input
                type="email"
                id="staffEmail"
                name="email"
                placeholder="Enter the teacher's email"
                autocomplete="off"
                required
            >

  <button type="submit" class="primary-btn" id="generateBtn">
    <span id="generateText">Generate Password</span>
    <span id="generateSpinner" class="spinner" hidden></span>
  </button>

        </form>

        <button type="button" class="secondary-btn" id="chooseEmailBtn">
            Choose Staff Email
        </button>

        <p class="help-text">
         <b>Important:</b> Confirm the staff member's identity before generating a password.
            Give the generated password directly to the staff member and
            advise them to change it after logging in.
        </p>

    </div>
</div>

<!-- Generated password popup -->
<div class="modal" id="passwordModal"
     role="dialog" aria-modal="true"
     aria-labelledby="modalTitle">

    <div class="modal-box">

        <div class="modal-icon">✓</div>

        <h3 id="modalTitle">Password Generated</h3>

        <p>
            Give this password to the staff member before closing
            this window.
        </p>

        <div class="password-box">
            <div class="password-value" id="generatedPassword"></div>
        </div>

        <button type="button" class="close-btn" id="closePasswordModal">
            Close
        </button>

    </div>
</div>

<!-- Staff email selection popup -->
<div class="modal" id="emailModal"
     role="dialog" aria-modal="true"
     aria-labelledby="emailModalTitle">

    <div class="modal-box">

        <h3 id="emailModalTitle">Choose Staff Email</h3>

        <p>Select the teacher's email address from the list.</p>

        <div class="search-wrap">
            <input type="search" id="emailSearch"
                   placeholder="Search staff emails..."
                   autocomplete="off">
        </div>

        <div class="staff-list" id="staffList">
            <div class="list-message">Loading staff emails...</div>
        </div>

        <button type="button" class="secondary-btn"
                id="closeEmailModal">
            Close
        </button>

    </div>
</div>

</section>

<? Addfooter($site);  ?>

<script>
"use strict";

const endpoint = "/includes/users.inc";

const form = document.getElementById("passwordForm");
const emailInput = document.getElementById("staffEmail");
const generateBtn = document.getElementById("generateBtn");
const notice = document.getElementById("notice");

const passwordModal = document.getElementById("passwordModal");
const generatedPassword = document.getElementById("generatedPassword");

const emailModal = document.getElementById("emailModal");
const staffList = document.getElementById("staffList");
const emailSearch = document.getElementById("emailSearch");

let staffEmails = [];

function showNotice(message, type = "error") {
    notice.textContent = message;
    notice.className = "notice " + type;
}

function clearNotice() {
    notice.textContent = "";
    notice.className = "notice";
}

function openModal(modal) {
    modal.classList.add("open");
}

function closeModal(modal) {
    modal.classList.remove("open");
}

function getErrorMessage(data, fallback) {
    return data && typeof data.message === "string" &&
           data.message.trim()
        ? data.message
        : fallback;
}

/*
 * Generate a password.
 */
 
 const generateText = document.getElementById("generateText");
 const generateSpinner = document.getElementById("generateSpinner");

form.addEventListener("submit", async function (event) {
    event.preventDefault();
    clearNotice();

    const email = emailInput.value.trim();

    if (!email) {
        showNotice("Please enter the staff email address.");
        emailInput.focus();
        return;
    }


   generateBtn.disabled = true;
   generateText.textContent = "Generating password...";
   generateSpinner.hidden = false;

    try {
        const response = await fetch(endpoint, {
            method: "POST",
            headers: {
            "Content-Type": "application/json"
            },
         credentials: "same-origin",
          body: JSON.stringify({
        submit_button_name: "generate-staff-psw",
          email:email
      })
        });

        const data = await response.json();

        if (!response.ok || data.status !== "success") {
            throw new Error(
                getErrorMessage(data, "Unable to generate the password.")
            );
        }

        if (
            typeof data.password !== "string" ||
            data.password.length === 0
        ) {
            throw new Error(
                "The server did not return a valid generated password."
            );
        }

        generatedPassword.textContent = data.password;
        openModal(passwordModal);

    } catch (error) {
        showNotice(
            error instanceof SyntaxError
                ? "The server returned an invalid response. Please try again."
                : error.message || "A network error occurred. Please try again."
        );
    } finally {
    generateBtn.disabled = false;
    generateText.textContent = "Generate Password";
    generateSpinner.hidden = true;
   }
});

/*
 * Close the password popup only when the ICT officer is ready.
 */
document.getElementById("closePasswordModal")
    .addEventListener("click", function () {
        closeModal(passwordModal);
        generatedPassword.textContent = "";
        emailInput.value = "";
      
    });

/*
 * Load the available staff emails.
 *
 * Expected endpoint response:
 * {
 *   "status": "success",
 *   "staff_emails": [
 *      "teacher@example.com",
 *      "another@example.com"
 *   ]
 * }
 */
document.getElementById("chooseEmailBtn")
    .addEventListener("click", async function () {
        clearNotice();
        openModal(emailModal);

        staffList.replaceChildren();
        const loading = document.createElement("div");
        loading.className = "list-message";
        loading.textContent = "Loading staff emails...";
        staffList.appendChild(loading);

        try {
     
            const response = await fetch(endpoint, {
                method: "POST",
                 headers: {
            "Content-Type": "application/json"
            },
         credentials: "same-origin",
          body: JSON.stringify({
        submit_button_name: "get-staff-emails"
                })
            });

            const data = await response.json();

            if (!response.ok || data.status !== "success") {
                throw new Error(
                    getErrorMessage(data, "Unable to load staff emails.")
                );
            }

            if (!Array.isArray(data.staff_emails)) {
                throw new Error("The staff email list has an invalid format.");
            }

            staffEmails = data.staff_emails
                .map(function (item) {
                    // Supports either plain email strings or objects.
                    return typeof item === "string"
                        ? item
                        : item && typeof item.email === "string"
                            ? item.email
                            : "";
                })
                .filter(function (email) {
                    return email.trim() !== "";
                });

            renderStaffEmails("");

        } catch (error) {
            staffList.replaceChildren();

            const message = document.createElement("div");
            message.className = "list-message";
            message.textContent =
                error.message || "Unable to load staff emails.";

            staffList.appendChild(message);
        }
    });

/*
 * Render emails safely, without inserting server data as HTML.
 */
function renderStaffEmails(searchTerm) {
    staffList.replaceChildren();

    const term = searchTerm.trim().toLowerCase();

    const filteredEmails = staffEmails.filter(function (email) {
        return email.toLowerCase().includes(term);
    });

    if (filteredEmails.length === 0) {
        const empty = document.createElement("div");
        empty.className = "list-message";
        empty.textContent = "No matching staff emails found.";
        staffList.appendChild(empty);
        return;
    }

    filteredEmails.forEach(function (email) {
        const button = document.createElement("button");
        button.type = "button";
        button.className = "staff-item";
        button.textContent = email;

        button.addEventListener("click", function () {
            emailInput.value = email;
            closeModal(emailModal);
            clearNotice();
            emailInput.focus();
        });

        staffList.appendChild(button);
    });
}

emailSearch.addEventListener("input", function () {
    renderStaffEmails(emailSearch.value);
});

document.getElementById("closeEmailModal")
    .addEventListener("click", function () {
        closeModal(emailModal);
    });

/* Close either popup with the Escape key. */
document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        if (passwordModal.classList.contains("open")) {
            closeModal(passwordModal);
            generatedPassword.textContent = "";
        } else if (emailModal.classList.contains("open")) {
            closeModal(emailModal);
        }
    }
});
</script>

</body>
</html>
