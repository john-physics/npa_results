document.addEventListener("DOMContentLoaded", function () {
  // Declare default if not yet declared
  if (typeof window.safeExit === "undefined") window.safeExit = false;

  // Prevent F5, Ctrl+R, F12, DevTools, etc.
  document.addEventListener("keydown", function (e) {
    if (!window.safeExit) {
      if (
        e.key === "F5" ||
        (e.ctrlKey && e.key.toLowerCase() === "r") ||
        (e.metaKey && e.key.toLowerCase() === "r") ||
        e.key === "F12" ||
        (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === "i")
      ) {
        e.preventDefault();
      }
    }
  });

  // Disable right-click context menu
  document.addEventListener("contextmenu", function (e) {
    if (!window.safeExit) {
      e.preventDefault();
    }
  });

  // Warn before reload/close
  window.addEventListener("beforeunload", function (e) {
    if (!window.safeExit) {
      e.preventDefault();
      e.returnValue = ""; // Show default browser warning
      endExam("You tried to leave or reload the page");
    }
  });

  // Prevent pull-to-refresh on mobile (Chrome/Android)
  document.body.style.overscrollBehavior = "contain";

  // Detect if page was reloaded
  if (
    !window.safeExit &&
    (performance.navigation.type === 1 ||
      (performance.getEntriesByType("navigation")[0] &&
       performance.getEntriesByType("navigation")[0].type === "reload"))
  ) {
    endExam("Page was reloaded");
  }

  // Detect tab/window switch
  document.addEventListener("visibilitychange", function () {
    if (!window.safeExit && document.visibilityState !== "visible") {
      endExam("User switched tab or minimized window");
    }
  });

  // Prevent back/forward navigation
  window.history.pushState(null, "", window.location.href);
  window.addEventListener("popstate", function () {
    if (!window.safeExit) {
      window.history.pushState(null, "", window.location.href);
      endExam("Attempted to navigate away using back/forward button");
    }
  });

  // Optionally track exam start
  sessionStorage.setItem("examStarted", "true");
});

//unction to end exam and redirect
function endExam(reason) {
  if (window.safeExit) return; // Don't run if already marked as safe exit

  console.log("Exam terminated: " + reason);
  alert("Exam ended: " + reason);

  // Notify backend to end the exam
   examId = document.getElementById("exam-Id").value;
  answered = Object.keys(answeredQuestions).length;

  // Prevent additional alerts on redirect
  window.safeExit = true;

  window.location = `../start_exam.php?end_my_exam&exam_Id=${examId}&qst_answered=${answered}&total_qst=${totalQuestions}&end_reason=${encodeURIComponent(reason)}`;
}