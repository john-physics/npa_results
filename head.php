<?php

function head($meta,$title,$dashb='portal'){

 global $siteName,$conn;

 echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name ="description" content="'.$meta.'">
<meta name ="key words" content="NewPhase, Academy,Result,'.$dashb.',Check result,ABC">
<meta name="author" content="John Ella">
 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title>'.$title.'</title>
<link rel="stylesheet" href="./css/new_styles.css">
<link rel="stylesheet" href="./css/styles.css">
 <link rel="stylesheet" href="./css/form_styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700;800;900&display=swap" rel="stylesheet">

  <style>
  
  html,body{
 scroll-behavior:smooth;   
    
 }
body{
   
   font-family: "Poppins",sans-serif;
}

.section h2{
  
  color: rgb(50,200,150); 
  text-decoration:none;    
    
}
 hr{
       
    border: 1px solid hsl(60,50%,50%);   
       
   }
   
    .section #day{
    position:absolute:
    top:100px;
     display:block;
     text-align:center;
     font-size:12px;
     color: rgb(50,200,150); 
   margin-bottom:10px;
 }
  
   .section #warning{
 display:flex;
  justify-content:center;
 align-items:center;
     color:hsl(0,40%,60%);
     font-size:30px;
     margin-bottom:10px;
   
 } 
 .section #no-data{
 font-size:12px;   
   position:relative;
   top:-5px;
   color:rgb(150,200,250);
}
  .bounce {
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-10px); }
}


.nav-bar{
    position:absolute;
    right:0;

    display: inline-flex;
    flex-direction:row; 
    justify-content:center;
    align-items:center;
    width:80%;
    gap: 10%;
  font-size:19px;
  overflow-x:scroll;
  -ms-overflow-style: none;/* IE & Edge */
  scrollbar-width: none;  /* Firefox */
 
 }

.nav-bar span{
    cursor:pointer;
    transition:0.3s ease;
    
}

.nav-bar a{
    text-decoration:none;
}
    

.nav-bar::-webkit-scrollbar {
  display: none;
}

.nav-bar #kuchy-logo{
  position:relative;  
  top: 5px;
  width: 22px;
  height:22px;
  border-radius:50%;
    
}


.nav-bar #notify-badge {
  position: absolute;
  top: 0;
  left:16%;
  background: #dc3545; /* red */
  color: white;
  font-size: 8px;
  font-weight: bold;
  padding: 1px 5px;
  border-radius: 50%;
} 
  
.nav-bar #client-badge {
  position: absolute;
  top: 0;
  left: 33%;
  background: #dc3545; /* red */
  color: white;
  font-size: 8px;
  font-weight: bold;
  padding: 1px 5px;
  border-radius: 50%;
} 
  
  .nav-bar #fees-badge {
  position: absolute;
  top: 0;
  left: 49.5%;
  background: #dc3545; /* red */
  color: white;
  font-size: 8px;
  font-weight: bold;
  padding: 1px 5px;
  border-radius: 50%;
} 
  
  
  .nav-bar #star-badge {
  position: absolute;
  top: 0;
  left: 66%;
  background: #dc3545; /* red */
  color: white;
  font-size: 8px;
  font-weight: bold;
  padding: 1px 5px;
  border-radius: 50%;
} 
   
 
 .nav-bar #kuchy-badge {
  position: absolute;
  top: 0;
  left: 84%;
  background: rgb(10,250,50); /* red */
  color: white;
  font-size: 8px;
  font-weight: bold;
  padding: 1px 5px;
  border-radius: 50%;
} 
  

#nav-links li {
    text-align: left;
    
}
 #nav-links a{
 font-size:18px;
 
 }
   li i{
    font-size:18px;
    width:1.5rem;
    text-align:center;
    opacity:.95;
    color:#fff;
    margin-right:10px;
  }
 
  .fa-whatsapp{ color:#25D366; } 
  .fa-certificate{ color:gold; }
  .fa-home{ color:#0d6efd;}
  .fa-user-shield{ color:#6f42c1;}
  .fa-globe{ color:#0dcaf0;}
  .fa-gear{ color:#198754;}
  .fa-file-arrow-up { color: #20c997};
  .fa-clapperboard { color: #dc3545; } 
  .fa-book { color: #6610f2; }  
  .fa-cash-register { color: #fd7e14; } 
  .fa-donate { color: #ffc107; }  
  .fa-lock { color: #6c757d; }  
  .fa-info-circle { color: #17a2b8; }
  .fa-certificate { color: #ffc107; }  
  .fa-code { color: #ddd; }  
  .fa-sign-in-alt { color: #0d6efd; } 
  .fa-sign-out-alt { color: #dc3545; }
  .fa-user-graduate { color: #20c997; } 
  .fa-gavel { color: #fd7e14; } 
  .fa-shield-halved { color: #6c757d; } 
  .fa-envelope{ color:#20c997;}
  .fa-bell{ color:#ffc107;} /*yellow bell*/
   .fa-briefcase{ color:#20c997;} 
  .fa-sack-dollar { color: #ffc107; }  
  .fa-star{ color:#ffc107;}
  #fa-donate{ color:#fd7e14; }
   .fa-money-check{ color:#0fa;  }

#about p {
   text-align: justify; 
    
}
/* Contact Section with Icons */
.contact-item h3 {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 10px;
    display: flex;
    align-items: center; /* Align text and icon */
    gap: 10px; 
}

.contact-item h3 i {
    color: #00ccff;
    font-size: 1.5rem;
}

/* Add hover effect for icons */
.contact-item h3:hover i {
    color: #333;
}
.contact-form Select{
    background-color: #fff;
}
.report {
            display: none; /* Initially hidden */
            width: 80%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;
            font-size: 16px;
            z-index: 1000;
            opacity: 1;
            transition: opacity 2s ease-out;
        }
 #start_btn {
     display: block;
     width: 60%;
     text-align: center;
     text-decoration:none;
     background: rgb(200,100,100);
     color: white;
     border-radius: 10px;
     padding: 10px;
 }
 #survey_progress{
     position: relative;
     bottom: 20px; 
 }
 #skip_btn {
 position: relative;  bottom: 20px; left: 75%; 
 text-decoration: none;
     
   /* background: #0077cc;   */
    /*  background:#BF1439; */
   /*  background: #BF1439; */

 }

 
/ *
 header{
   position: relative;  
     color:#fff;
     text-align: center;
     height: 270px;
     background: #CF3F57; 
  
 }
 
  header .profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 2px dashed  rgb(250,100,250);
    margin-bottom: 5px;
     background:#ff8;
     position:relative;
    
}
 header h1{
     position: relative;
     top:-30px;
     font-size: 27px;
     padding: 5px;
 }
 header p{
     position: relative;
     top: -45px;
     font-size: 18px;
     font-style: italic;
     
 }


*/

.new_success{
 top:10px;
 text-align: justify; 
 padding:10px;
 font-size:12px;
 border: 1px solid #fff;
 border-radius:10px;
 background:#007BFF;
 color:white;
 display:block;
 left:10%;
 width:100%;

}
.new_errors{
 top:10px;
 text-align: justify; 
 padding:10px;
 font-size:12px;
 border: 1px solid #fff;
 border-radius:10px;
 background:red;
 color:white;
 display:block;
 left:10%;
 width:100%;

}
  .link_btn {
    text-decoration:none;
    color:white;
    padding:3px;
    border-radius:2px;
    cursor:pointer;
    font-size:12px;
    font-weight:bold;
    display:block;
        width:60px;
        text-align:center;
    }
      #remove_link_btn{
    
    background:rgba(250,50,50,0.5);
    
    }
     #view_link_btn{
    
    background:rgba(10,100,250,0.5);
    
    } 
      #dwn_link_btn{
    
    background:rgba(150,100,150,0.5);
    
    } 
      #grade_link_btn{
    
    background:rgba(10,200,150,0.5);
    
    } 
    
    .contact-form #label{
        position:relative;
        top:10px;
        font-style:italic;
    }

header{
    position:relative;
    height:230px;
    overflow:hidden;

    background:
    radial-gradient(circle at center 85px,
        rgba(255,255,255,.25) 0%,
        rgba(255,255,255,.12) 18%,
        transparent 45%),

    linear-gradient(
        135deg,
        #74003b 0%,
        #a50055 40%,
        #d11a67 100%
    );

    color:#fff;
    margin-bottom:0.5px; 
  
}

/* Dark vignette effect */
header::before{
    content:"";
    position:absolute;
    inset:0;

    background:
    radial-gradient(circle at top left,
        rgba(0,0,0,.35),
        transparent 45%),

    radial-gradient(circle at top right,
        rgba(0,0,0,.35),
        transparent 45%);
}

/* Center everything */
header .container{
    position:relative;
    z-index:2;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;

    height:100%;
}

/* Logo */
.profile-pic{
    width:160px;
    height:160px;
    border-radius:50%;
    object-fit:cover;

    border:5px solid rgba(255,255,255,.2);

    box-shadow:
        0 0 25px rgba(255,255,255,.3),
        0 0 70px rgba(255,255,255,.15);
    position :relative;
    top:30px;
}

/* School name */
header h1{
    position:relative;
    top:10px;
    margin: 0;
    font-size:1.5rem;
    font-weight:800;
    letter-spacing:1px;
}

/* Subtitle */
header p{
    margin-top:20px;

    font-size:1.5rem;
    font-style:italic;
    font-weight:300;
    opacity:.95;
    position:relative;
    top:-20px;
}


header .container::before{
    content:"";
    position:absolute;

    width:220px;
    height:220px;

    border-radius:50%;

    top:20px;

    background:rgba(255,255,255,.12);
    filter:blur(20px);

    z-index:-1;
}

.profile-pic{
    box-shadow:
        0 0 10px rgba(255,255,255,.2),
        0 0 25px rgba(255,0,128,.4),
        0 0 50px rgba(170,0,255,.35),
        0 0 80px rgba(255,0,180,.25);
        border:4px solid rgba(255,180,220,.25);
        
         
    transition: all .3s ease;
}


header{
    background:
    linear-gradient(
        135deg,
        #5b1028 0%,
        #8a1f45 45%,
        #b33a5b 100%
    );
}

.profile-pic{
    box-shadow:
        0 0 15px rgba(255,255,255,.2),
        0 0 40px rgba(255,80,120,.45),
        0 0 80px rgba(180,40,140,.35),
        0 0 120px rgba(255,120,80,.25);
        
        
    box-shadow:
        0 0 10px rgba(255,255,255,.2),
        0 0 25px rgba(255,0,128,.4),
        0 0 50px rgba(170,0,255,.35),
        0 0 80px rgba(255,0,180,.25);
        border:4px solid rgba(255,180,220,.25);
          
        
}


header .container::before{
    content:"";
    position:absolute;

    width:420px;
    height:420px;

    top:-60px;
    left:50%;

    transform:translateX(-50%);

    border-radius:50%;

    background:
    radial-gradient(
        circle,
        rgba(255,255,255,.22) 0%,
        rgba(255,180,220,.12) 35%,
        rgba(255,120,180,.06) 55%,
        transparent 75%
    );

    z-index:-1;
}



.logo-wrapper{
    
    margin-bottom:0px;
}



.logo-wrapper::before{
    content:"";
    position:absolute;
    inset:-4px;

    border-radius:50%;

    background:
    conic-gradient(
        from 0deg,
        transparent,
        rgba(255,255,255,.8),
        rgba(255,120,180,.8),
        rgba(180,40,140,.8),
        transparent
    );

  /*  animation:spin 8s linear infinite; 
  */
}

.logo-wrapper::after{
    content:"";
    position:absolute;
    inset:4px;

    border-radius:50%;

    background:inherit;
    z-index:1;
}


@keyframes spin{
    from{
        transform:rotate(0deg);
    }
    to{
        transform:rotate(360deg);
    }
}

</style>
    
</head>
<body>


 <!-- Header Section -->
 <header class="head-section">
 <div class="container">';

$prfDir = "/images/npa-logo.jpg";
if($dashb == "profile" && isset($_SESSION["staff_id"])){
 
 $staff_id = $_SESSION["staff_id"];
 $det = collect_table_data1($conn,"staffs","staff_id",$staff_id,"i","","profile",1);  
   
 if($det && is_array($det)){
 $profile = null_check($det[0],"null.jpg");
 $prf = "/images/staff/$profile";
 $prfPath = $_SERVER["DOCUMENT_ROOT"].$prf;
  
  if(file_exists($prfPath)){
     
    $prfDir = "/images/staff/$profile";
   
  }
 }
}

 echo '<div class="logo-wrapper">
 <a href="'.$prfDir.'"><img src="'.$prfDir.'" alt="Logo" class="profile-pic" id="profile-pic"></a></div>
            <h1>'.$siteName.'</h1>
            <p>Result Portal</p>
        </div>
    </header>';  
    
 
 if($dashb == "Dashboard"){  $_SESSION["dashboard"] = true;  
 }
 else{ $_SESSION["dashboard"] = false; }
 
    
}

