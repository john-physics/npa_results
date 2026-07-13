<?php

echo '<style>

.fa-users{
    color:#3498db;
}

.fa-school{
    color:#27ae60;
}

.fa-book-open{
    color:#e67e22;
}

.fa-times{
    color:#ff4d4d;
}

.fa-chart-column{
   color: #0ea5e9;   /* Sky Blue */    
    
}

/* NAV BAR */
#nav-section{
    background:#2d2d2d;
    position:relative;
    z-index:100;
     position:relative;
    padding: 25px 0;
}


/* MENU BUTTON */
#menu-toggle{
    background:none;
    border:none;
    color:#00c8ff;
    font-size:1.2rem;
    padding:0;
    cursor:pointer;
    font-weight:500;
    position: absolute;  
  left:2%;
}

/* SIDE MENU */
#nav-links{
    position:absolute;
    top:100%; 
    left:0;
    width:80%;
    max-width:400px;
    height:auto;
    display: flex;
    background:#111;
    border-radius:0 0 15px 0;
    gap: 0;
    padding :0;
 
    list-style:none;
    /* hidden by default */
    transform:translateX(-110%);
    opacity:0;
    visibility:hidden;

    transition:
    transform 0.5s ease,
    opacity 0.5s ease,visibility 0.5s ease;
    box-shadow:0 8px 20px rgba(0,0,0,0.4);
}

/* ACTIVE STATE */
#nav-links.show{
    transform:translateX(0);
    opacity:1;
    visibility:visible;
}
 

/* CLOSE BUTTON */
#nav-links .close-btn{
    display:flex;
    justify-content:flex-end;
    padding:0 20px 15px;
   background:none;
   position:absolute;
   top: 20px;
   right:10px;
}

#nav-links .close-btn i{
    color:#ff4d4d;
    font-size:1.5rem;
    cursor:pointer;
}

/* MENU ITEMS */
#nav-links li{
    width:100%;
    margin-left:15px;
}

#nav-links li a{
    display:flex;
    align-items:center;
    gap: 2px;
    color:#fff;
    text-decoration:none;
    padding: 5px;
    font-size:1rem;
    font-weight:600;
    transition:0.3s ease;
}

/* ICONS */
#nav-links li a i{
    width:25px;
    text-align:center;
    font-size:1.2rem;
}

/* HOVER EFFECT */
#nav-links li a:hover{
    background:#1e1e1e;
    padding-left:28px;
}



</style>';


echo '<nav id="nav-section" class="menu">
    <div class="nav-container">
        <button id="menu-toggle">☰ Menu</button>
     
     
    <ul id="nav-links">
          
          <!-- CLOSE ICON -->
   <div class="close-btn" title="Close Menu">
      <i class="fas fa-times"></i>
        </div> 
     
      <li>
         <a href="/home">
         <i class="fa-solid fa-home" aria-hidden="true" title="Back to Home page"></i>   
       Home Page
           </a></li>
             <li>
         <a href="/results">
         <i class="fa-solid fa-certificate" aria-hidden="true" title="click here to Check results"></i>   
       Check Result
           </a></li>
             <li>
         <a href="/grading_system">
         <i class="fa-solid fa-chart-column" aria-hidden="true" title="View Grading System"></i>   
       Grading System
           </a></li>';
      
   if(isset($_SESSION["staff_cat"]) && $_SESSION["staff_id"]){
    $staff_cat = $_SESSION["staff_cat"];   
     
   if(in_array($staff_cat, $authorized)){
       
     echo '
<li>
  <a href="/users?manage_users">
    <i class="fas fa-users"></i>
    Manage Users
  </a>
</li>

<li>
  <a href="/users?manage_class">
    <i class="fas fa-school"></i>
    Manage Classes
  </a>
</li>

<li>
  <a href="/users?manage_subjects">
    <i class="fas fa-book-open"></i>
    Manage Subjects
  </a>
</li>

';   
       
  }  
    
  if(isset($_SESSION["dashboard"]) && $_SESSION["dashboard"] === true){
  
    echo '<li>
      <a href="#" id="logout-link">
    <i class="fas fa-sign-out-alt"></i>
      Logout
       </a></li>';     
      
  }
 }    
 
     echo '</ul>
    </div>
</nav>';
    
 
echo '<script>
    // ELEMENTS
    const menuToggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");
    const navItems = navLinks.querySelectorAll("a");
    const closeBtn = document.querySelector(".close-btn");

    // OPEN / CLOSE MENU
    menuToggle.addEventListener("click", (event) => {
        navLinks.classList.toggle("show");
        event.stopPropagation();
    });

    // CLOSE WITH X BUTTON
    closeBtn.addEventListener("click", () => {
        navLinks.classList.remove("show");
    });

    // CLOSE WHEN A LINK IS CLICKED
    navItems.forEach((item) => {
        item.addEventListener("click", () => {
            navLinks.classList.remove("show");
        });
    });

    // CLOSE WHEN CLICKING OUTSIDE
    document.addEventListener("click", (event) => {

        const clickedInsideMenu = navLinks.contains(event.target);
        const clickedMenuButton = menuToggle.contains(event.target);

        if (!clickedInsideMenu && !clickedMenuButton) {
            navLinks.classList.remove("show");
        }

    });
</script>'; 



