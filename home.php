<?php
 require 'page_init.php';

head('NPA Result Port',"$site | Result Portal","Dashboard");

require 'login_popup.php';
new_popup();
require 'menu.php';

// goameh@gmail.com : godwin$2845

// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="scripts/report_notice.js"></script>';
     
 }
  
 require './error_suc_msg.php'; // detect and display error Messages if any
require './custom_alert.php'; 


echo '<style>

 .slideshow-container {
      width: 95%;
      height: 50px;
      position: relative;
      top: 20px;
      left: 0;
      background-color: #1a1a1a;
      display: flex;
      align-items: center;
      overflow: hidden;
      border-bottom: 2px solid #ff4500;
      border-radius:5px;
    }

    .slide-text {
      color: #ff4500;
      font-size: 18px;
      font-weight: bold;
      white-space: nowrap;
      padding-left: 100%;
      animation: slide-left 30s linear infinite;
    }

    @keyframes slide-left {
      0% {
        transform: translateX(0%);
      }
      100% {
        transform: translateX(-100%);
      }
    }
 


.quotes-section {
   position:relative;
   top:-10px;
    width: 100%;
    padding: 0 20px;
}

.quote-card {
    position: relative
    background: #fff;
    margin: 30px auto;
    max-width: 400px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);

    opacity: 0;
    transform: translateY(80px);
    transition: all 0.8s ease;
}

.quote-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}


.quote-card {
    overflow: hidden;
    border-radius: 15px;
}

.quote-card p {
    padding: 18px;
    font-size: 16px;
    text-align: center;
    font-weight: bold;
    color: #fff;
    background:rgba(100,200,50,0.5);
    z-index:2;
}

.poem p{
     font-size:10.5px;
    padding:10px;
    text-align:center;
    overflow:auto;
   -ms-overflow-style: none; 
  scrollbar-width: none;     
}

 .quote-card a{
 
 text-decoration:none;
 color:rgb(150,100,150);
 z-index:5;
 cursor:pointer;
 
 }

.quote-card a:hover{
    
    color:#3A5FCD;
    text-decoration:underline;
}

/* Active state */
.quote-card.quote-show {
    opacity: 1;
    transform: translateY(0);
}

.quote-card::after {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
}

.quote-card:hover {
    transform: translateY(-5px);
}

.slide-img {
    opacity: 0;
    transform: translateX(-100px);
    transition: all 0.8s ease;
}

/* When in view */
.slide-img.img-show {
    opacity: 1;
    transform: translateX(0);
}

/* When leaving view */
.slide-img.img-hide {
    opacity: 0;
    transform: translateX(-100px);
}


 .table_btn{
    position:relative;
    top:5px;
    display:flex;
    flex-direction:horizontal;
    gap:10px;

    }
    
    .table_btn a{
    text-decoration:none;
    color:white;
    padding:8px;
    border-radius:4px;
    cursor:pointer;
    font-size:10px;
    font-weight:bold;
    display:block;
        width:60%;
        text-align:center;
    }
  
   .table_btn #share_cert{
        
     background:rgba(250,50,50,0.5);
      
    }
     .table_btn #remove_ass{
    
    background:rgba(250,50,50,0.5);
    
    }
     .table_btn #view_ass{
    
    background:rgba(10,100,250,0.5);
    
    } 
     .table_btn #dwn_ass{
    
    background:rgba(150,100,150,0.5);
    
    } 
     .table_btn #grade_ass{
    
    background:rgba(10,200,150,0.5);
    
    } 
  

.intro{
  position:relative;
 top:10px;
 height:auto;
  border-radius:10px;
  box-shadow:1px 1px 2px rgba(10,0,0,0.2);
  background:#fff;
  margin-bottom:30px;
}
.kuchylogo{
  width:100%;  
  display:flex;
  justify-content:center;
  align-items:center;
  padding: 2px 10px;
}

.kuchylogo img{
  width:100%;
  height:350px;  
  border-radius:10px;
   box-shadow: 1px 1px 2px rgba(10,1,0,0.1); 
}
.coming-soon{
 display:block;
    position:relative;
    top:5px;
    margin-left:5%;
    
}
.coming-soon h6{

position:absolute;
left:25px;
 top: 2px; 
 font-style:italic;
 font-size:12px;
 color:rgb(200,100,250);
}

.update-multipix::-webkit-scrollbar {
  display: none;
}

  #owner{
      font-size:8px;
      font-style:italic;
      font-weight:bold;
    /*  padding:10px; */
      position:relative;
      left:5%;
      color:rgb(200,50,200);
  }
  

 .dashb{
    display:grid;
    
    /* Automatically adjusts columns */
    grid-template-columns:repeat(auto-fit, minmax(80px, 1fr));
    
    gap:10px;
    width:100%;
    padding:10px;

    -webkit-user-select:none;
    -moz-user-select:none;
    -ms-user-select:none;
    user-select:none;

    -webkit-touch-callout:none;
   -webkit-tap-highlight-color:transparent;
}

.dashb .dashb-conts{
    min-height:100px;
    border-radius:5px;
    border:1px solid #ddd;
    font-size:10px;
    text-align:center;
    word-break:break-word;
    cursor:pointer;
    display:block;
    padding:5px;
    box-sizing:border-box;
      
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
  
 .dashb-conts:hover{
    transform: translateY(-5px);
   box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}
 
  .dashb-conts i{
        display:block;
        position:relative;
        top:10px;
        font-size:20px;
        font-weight:bold;
       
    }
    
 .icon-box{
   width:55px;
   height:55px;
   border-radius:50%;
   display:block;
   align-items:center;
   justify-content:center;
   background:#F3F4F6;
   margin:auto;
}   
    
   .fa-user-plus{
   color:#2563EB; /* Staff */
}

.fa-user-graduate{
   color:#16A34A; /* Students */
}

.fa-user{
   color:#16A34A; /* Students */
}

.fa-school{
   color:#F59E0B; /* Class */
}

.fa-book-open{
   color:#7C3AED; /* Subject */
}

.fa-calendar-check{
   color:#06B6D4; /* Appointment */
}

.fa-clock{
   color:#4F46E5; /* Current Session */
}

.fa-upload{
   color:#10B981; /* Upload Results */
}

.fa-chart-bar{
   color:#1D4ED8; /* View Results */
}
 
 .fa-chalkboard-teacher{
 color: #0d6efd;
   
 }
 
 .fa-images{
     
  color: #0ea5e9;   /* Sky Blue */   
 }
 
 .fa-users{
     
 color: #0d6efd;   
     
 }
 
 .fa-signature{
     color:#1A237E;
      color: #3F51B5;
 }
   .dashb-conts #badge{
   
   display:inline-block;
   position:relative;
   top:10px; 
   border-radius:50%;
   width:25px;
   height:25px;
   background:red;
   color:#fff;
   font-weight:bold;
   font-size:12px;
   }
      .dashb-conts #text{
      display:block;
      position:relative;
      top:20px;
      
      }
      
 .elipses{
  display:block;
  position:absolute;
  right:3%;
  padding:5px;
   z-index:5;
   border:none;
   background:#fff;
   cursor:pointer;
   width:40px;
  height:40px;
  
}

/* Action dropdown */

.notify-actions {
  position: absolute;
  background: #f5f5f5;
  border-radius: 6px;
  box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
  display: none;
  flex-direction: column;
  z-index: 1000;
  width: 25%;
  height:auto;
  transition: 0.3s ease;
}
.notify-actions button {
  padding: 5px 10px;
  border: none;
  background: none;
  text-align: left;
  width: 100%;
  cursor: pointer;
   font-size: 9px;
  font-weight:bold;
  color:rgb(50,100,150);
}
.notify-actions button:hover {
  background: #eee;
}
     

  @media screen and (min-width:800px){
 
 
  .kuchylogo img{
  width:80%;
  height:700px; 
  
}  

 .coming-soon{
 
 margin-left:12%;
  }
  
   table_btn{
  gap:5px;
 }
.table_btn a{
  width:25%;  
  margin:auto;
   
 } 
 
 .popup-content {
    width: 400px;
     
}
 .dashb{
 
 grid-template-columns:repeat(auto-fit, minmax(150px, 1fr));
}

.dashb .dashb-conts{
    font-size:12px;
}

.elipses{
  position:absolute;
  right:15%;
    
}

.quote-card{

   max-width: 700px;
  }
  
  .quote-card img {
    width: 100%;
    height: 400px;
    object-fit: cover;
 }
}
</style>';


if(check_staff_login($conn)){
 
 
 if(isset($_SESSION["staff_id"])){
    $userId = $_SESSION["staff_id"];
}

else{
    $userId = null;
}

$user = get_user_name($userId);
$surname =  strtolower($user["surname"]);

 
echo '<section id="dashb-section" class="section">
 <!--
 <button type="button" class ="elipses">
 <i class="fas fa-ellipsis-v"></i>
 </button> 
 -->
 
  <h2>Result Dashboard</h2>';
  
 //Client_Jobs dashboard
 $name = $user["fullname"]??'Anonymous';
 $usercat = $user["user_cat"]??'Anonymous';
 $ImpAuthorized = implode(":",$authorized);

echo '<input type="hidden" id="authorized" value="'.$ImpAuthorized.'">
<input type="hidden" id="staff_cat" value="'.$usercat.'">';


 if(in_array($usercat, $authorized)){
  
  echo '<div class="intro"> 
<span id="owner"> '.$name.' • '.$usercat.' • | Manage Result Dashboard</span>';
   
 echo '<div class="dashb" id="dashb">
 <div class="dashb-conts" data-page="add_new?add_new_staff">
 <span><i class="fa-solid fa-user-plus"></i></span>
<span id="text">Add Staff</span>
 </div>
 
 <div class="dashb-conts" data-page="add_new?add_new_stds">
  <span><i class="fa-solid fa-user-graduate text-success"></i></span>
  <span id="text">Add Students</span>
 </div>
 
  <div class="dashb-conts" data-page="add_new?add_new_class">
  <span><i class="fa-solid fa-school text-warning"></i></span>
  <span id="text">Add Class</span>
 </div>

 <div class="dashb-conts" data-page="add_new?add_new_subject">
  <span><i class="fa-solid fa-book-open text-purple"></i></span>
  <span id="text">Add Subject</span>
 </div>
 
  <div class="dashb-conts" data-page="add_new?new_appoint_ment">
 <span><i class="fa-solid fa-calendar-check text-info"></i></span>
  <span id="text">Appointment</span>
 </div>

 <div class="dashb-conts" data-page="add_new?upd_current_session">
 <span><i class="fa-solid fa-clock"></i></span>
 
  <span id="text">Update Current Session</span>
 </div>
 
  <div class="dashb-conts" data-page="add_new?assign_class_teachers">
 <span><i class="fa-solid fa-chalkboard-teacher"></i></span>
 
  <span id="text">Assign Class Teachers</span>
 </div>

 <div class="dashb-conts" data-page="upload_results">
  <span><i class="fa-solid fa-upload text-success"></i></span>
  <span id="text">View Uploaded Results</span>
 </div>

  <div class="dashb-conts" data-page="results?view_results">
  <span><i class="fa-solid fa-chart-bar text-primary"></i></span>
  <span id="text">View Results</span>
 </div>';
 
 if(in_array($usercat, $appointers)){
     
  echo '<div class="dashb-conts" data-page="settings">
  <span><i class="fa-solid fa-gear text-primary"></i></span>
  <span id="text">Settings</span>
 </div>
 <div class="dashb-conts" data-page="view_staff">
  <span><i class="fa-solid fa-users text-primary"></i></span>
  <span id="text">Staff List</span>
 </div>';   
     
 }
  
  echo '

 <div class="dashb-conts" data-page="add_new?add_stds_photo">
  <span><i class="fa-solid fa-images text-success"></i></span>
 <span id="text">Add Students Photo</span>
 </div>

 <div class="dashb-conts" data-page="view_students?view_class">
  <span><i class="fa-solid fa-user text-success"></i></span>
 <span id="text">View Students Details</span>
 </div>
 
  <div class="dashb-conts" data-page="background-remover">
  <span><i class="fa-solid fa-signature text-success"></i></span>
 <span id="text">Signature Cleaner</span>
 </div>

<div class="dashb-conts" data-page="profile">
  <span><i class="fa-solid fa-user-shield text-primary"></i></span>
  <span id="text">Staff Profile</span>
 </div>

</div>
  </div>';
       
 }
 
 else{
//teachers here.      
     
    echo '<div class="intro"> 
<span id="owner"> '.$name.' • '.$usercat.' • | Manage Your Students\' Results</span>';
   
 echo '<div class="dashb" id="dashb">
 
  <div class="dashb-conts" data-page="add_new?add_new_stds">
  <span><i class="fa-solid fa-user-graduate text-success"></i></span>
  <span id="text">Add Students</span>
 </div>
 
<div class="dashb-conts" data-page="add_new?add_stds_photo">
    <span><i class="fa-solid fa-images text-success"></i></span>
    <span id="text">Add Students Photo</span>
</div>
 
  <div class="dashb-conts" data-page="view_students?view_class">
  <span><i class="fa-solid fa-user text-success"></i></span>
 <span id="text">View Students Details</span>
 </div>
 
   <div class="dashb-conts" data-page="users?manage_subjects">
  <span><i class="fa-solid fa-book-open text-success"></i></span>
 <span id="text">View Subjects</span>
 </div>
 

 <div class="dashb-conts" data-page="upload_results">
  <span><i class="fa-solid fa-upload text-success"></i></span>
  <span id="text">Upload Results</span>
 </div>
 
  <div class="dashb-conts" data-page="results?view_results">
   <span><i class="fa-solid fa-chart-bar text-primary"></i></span>
   <span id="text">View Results</span>
  </div>
 
  <div class="dashb-conts" data-page="profile">
   <span><i class="fa-solid fa-user-shield text-primary"></i></span>
   <span id="text">Staff Profile</span>
  </div>

 </div>';   
     
 }
 
   $current = get_current_session();
   $termSession = trim($current['term']." ".$current['session']);
   if(!$termSession){
    $termSession = "Unknown";
   }

  echo '<br><hr><span id="day"><strong>Current Session: '.$termSession.'</strong></span>
</section>';


}
else{
 
  echo '<center>
<div class="slideshow-container">
    <div class="slide-text">
  Welcome to '.$site.' result portal, scroll down and click on <b>Check Your Result</b>, Select exam year, term and your class, then enter your pin and click on <b>View Results</b>. If you are a staff click on <b>Staff Login</b>, Enter your email and password then click on <b>Login</b>. You will be redirected to the appropriate result compilation site after successful login.
    </div>
  </div></center>'; 
 
    
echo '<section class ="section" id="about">
 <h2 id="welcome">Welcome to Our Result Portal</h2>
 
<div class="kuchylogo">
  <img id="kuchypay-logo-box" src="/images/result-sample2.png" alt="result-sample" class="slide-img">
  </div>
 
 <div class="coming-soon" id="coming-soon">
  <i class="fa-solid fa-briefcase bounce"></i>
  <h6>Compute and view results with ease !</h6>
  
   </div><br> 
  </div>';


 echo ' <div class="table_btn" id="table_btn">

  <a id="dwn_ass" href="#" title="Login to result computing system">Staff Login</a>
  <a id="share_cert" href="/results" target="_blank" title="Click here to check your result now">Check Your Result</a>
 
 </div>';  
    
 echo '</section>';
 
 echo '<section class="quotes-section">

  <div class="quote-card">
    <img src="images/quotes/img3.jpg" alt="">
    <p>Your effort matters more than your score.</p>
  </div>

  <div class="quote-card">
    <img src="images/quotes/img1b.jpg" alt="">
    <p>Exams test knowledge, not your worth.</p>
  </div>

  <div class="quote-card">
    <img src="images/quotes/img4.jpg" alt="">
<p>Stay calm. You did your best.<br>
  <a href="/results" target="_blank" title="Click here to check your result now">Check Your Result Now</a>
</p>

  </div>

  <div class="quote-card">
    <img src="images/quotes/img5.jpg" alt="">
    <p>Progress is better than perfection.</p>
  </div>
  
   <div class="quote-card">
    <img src="images/quotes/img7.jpg" alt="">
    <p>Your success is our priority.<br>
     <a href="/results" target="_blank" title="Click here to check your result now">Check Your Result Now</a></p>
  </div> 
  
     <div class="quote-card">
    <img src="images/quotes/learning.jpg" alt="">
    <p>Education is not the filling of a pail but the lighting of a fire. Learning Never Ends<br>
</p>
  </div> 
  
  <div class="quote-card">
    <img src="images/quotes/education.jpg" alt="">
    <p>Education is the ultimate key, keep Learning, keep Growing.<br>
</p>
  </div> 
    
    <div class="quote-card poem">
    <img src="images/quotes/ethel-poem.jpg" alt="">
  
    <pre>
 <p>
𝗧𝗛𝗔𝗧 𝗥𝗢𝗨𝗚𝗛 𝗙𝗜𝗥𝗦𝗧 𝗗𝗥𝗔𝗙𝗧

The paper stared, white and empty,  
My mind a room with lights turned off.  
Questions danced in strange languages,  
Every answer I studied… gone, lost.  

I flipped the page, heart sinking slow,  
Like watching hope pack up and leave.  
The clock ticked loud, too loud, too fast,  
While my pen just sat there and grieved.  

“Read the question twice,” they always say,  
I read it five — still made no sense.  
Formulas slipped like water through my hands,  
Confidence walked out, no defense.  

I wrote something. Anything. Please.  
Margins full of nervous art.  
Drew a face where the graph should be,  
Because my brain fell apart.  

Bell rang. Pen down. Silence heavy.  
Walked out with shoulders made of stone.  
Friends said “How was it?” I just smiled,  
Said “We move,” and walked alone.  

But here’s the thing about failure:  
It’s not the end, just a bent page.  
Even red ink can teach you something,  
Even falling can set the stage.  

Exams can test what’s in your head,  
But they don\'t grade how much you fought.
And concepts fail sometimes... it\'s human,
what matters are the efforts put into thriving to succeed.

So i\'ll cry today, and try tomorrow.
One bad test won\'t write my story.
Failure\'s only 𝐀 𝐑𝐎𝐔𝐆𝐇 𝐅𝐈𝐑𝐒𝐓 𝐃𝐑𝐀𝐅𝐓.


ʙʏ: 𝐄𝐓𝐇𝐄𝐋𝐁𝐄𝐑𝐓
     
</p></pre>
  </div> 
  
  
     <div class="quote-card poem">
    <img src="images/quotes/lopez-poem.png" alt="">
  
    <pre>
 <p>
<b>BEFORE THE BELL</b>

The hours bent beneath my will
My diligence, a quiet skill
While others fret about their fate
I trace my path, immaculate

I knew the answers before the page
Before the clock could cage the day
Each sleepless night, a quiet forge
Shaping my mind, the brain, the gorge

I write, not frantic, but precise
Each word a chess move
My confidence cold as ice
The exam rages, and I follow it\'s groove 

Confidence, not arrogance, my cloak
A subtle smile, no need to gloat
The toil, the struggle, nights unspent
All fuel the fire, the quiet ascent

But then the bell tolls, a sudden swell
And even I feel that fleeting spell
I breathe, accustomed to the strain
Let the moment pass, retain my reign

A humble nod? Perhaps I feign
Yet brilliance whispers through my vein
I pass, I know, I reign discreet
A scholar’s triumph, precise, complete.

By: <b>LOPEZ</b>
   
</p></pre>

  </div>
  
  
 <div class="quote-card">
  <img src="images/result-sample3.png" alt="">
    <p>Your results are ready.<br>
     <a href="/results" target="_blank" title="Click here to check your result now">Click here to view them Now</a></p>
  </div> 

</section>';

}


Addfooter($site); 


?>
<script>
    
   
 const button = document.querySelectorAll(".dashb-conts");
 
 button.forEach(btn =>{
     
  btn.addEventListener("click",(e)=>{
   const page = btn.dataset.page;   
      
 window.location = page;   
    
    
  });   
     
 });
 
 
   // Handle ellipses button click
 /* 
  document.addEventListener("click", function(e) {
  const btn = e.target.closest(".elipses");
    if (btn) {
      e.preventDefault();
       
      // Close other open menus
      document.querySelectorAll(".notify-actions").forEach(menu => menu.remove());

      // Create new dropdown
      const menu = document.createElement("div");
      menu.classList.add("notify-actions");

      // logout Btn 
      const logoutBtn = document.createElement("button");
      logoutBtn.innerText = "Log Out";
      logoutBtn.addEventListener("click", () => {
        
//  document.getElementById("logout-popup").style.display = "flex";
 
 document.getElementById("logout-popup").classList.add("active");


  document.getElementById("about").style.display = "none";
     
 document.getElementById("footer").style.top = "400px";
   
        menu.remove();
        
      });
      
  const manageUsers = document.createElement("button");   
 manageUsers.innerText = "Manage Users";

manageUsers.addEventListener("click",(e)=>{
    
 window.location.href = "/users?manage_users";  
    
});


 const manageClass = document.createElement("button");   
 manageClass.innerText = "Manage Classes";

manageClass.addEventListener("click",(e)=>{
    
 window.location.href = "/users?manage_class";  
    
});

 const manageSubj = document.createElement("button");   
 manageSubj.innerText = "Manage subjects";

manageSubj.addEventListener("click",(e)=>{
    
 window.location.href = "/users?manage_subjects";  
    
});


const authorized = document.getElementById("authorized").value;
const staffCat = document.getElementById("staff_cat").value;

// convert back to array
const authorizedArray = authorized.split(":");

// check if user category exists
if(authorizedArray.includes(staffCat)){
    
      menu.appendChild(manageUsers);
      menu.appendChild(manageClass);
      menu.appendChild(manageSubj);  

}

  menu.appendChild(logoutBtn);

  document.body.appendChild(menu);
const rect = btn.getBoundingClientRect();
const offsetX = -45;
const offsetY = -10;

menu.style.display = "flex";
menu.style.top = rect.bottom + window.scrollY + offsetY + "px";
menu.style.left = rect.left + window.scrollX + offsetX + "px";
  
    } else {
      // Close dropdown if clicked outside
      document.querySelectorAll(".notify-actions").forEach(menu => menu.remove());
    }
  });

 */
 
</script>

<script>
const images = document.querySelectorAll(".slide-img");

const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        const el = entry.target;

        if (entry.intersectionRatio >= 0.5) {
            el.classList.add("img-show");
            el.classList.remove("img-hide");
        } else if (entry.intersectionRatio < 0.2) {
            el.classList.remove("img-show");
            el.classList.add("img-hide");
        }
    });
}, {
    threshold: [0.2, 0.5]
});

images.forEach(img => imageObserver.observe(img));
</script>


<script>
const cards = document.querySelectorAll(".quote-card");

const quoteObserver = new IntersectionObserver((ente) => {
    ente.forEach(ent => {
        const ell = ent.target;

        if (ent.intersectionRatio >= 0.5) {
            ell.classList.add("quote-show");
        } else if (ent.intersectionRatio < 0.2) {
            ell.classList.remove("quote-show");
        }
    });
}, {
    threshold: [0.2, 0.5]
});

cards.forEach(card => quoteObserver.observe(card));
</script>

<script>
  // logout Btn
   
 const logoutBtn = document.getElementById("logout-link");
     
logoutBtn.addEventListener("click", (e) => {
 
  document.getElementById("logout-popup").classList.add("active");
 
  document.getElementById("nav-section").style.display="none"; 
  document.getElementById("dashb-section").style.display="none";
  document.getElementById("footer").style.display="none";


});

</script>