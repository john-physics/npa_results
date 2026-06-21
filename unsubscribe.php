<?php
require 'page_init.php';

head('Unsubscribe from our emails','Unsubscribe');


echo '<style>
.success{
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
 
 width:80%;

}
  
 .warning{
     padding: 10px;
     border: 2px solid #003366;
   margin: auto;
     width: 85%;
 }
   .warning i{
   font-weight: bold;
    color:rgb(200,150,250);
    text-align: justify; 

    }
  .warning form button{
    box-shadow: none;  
    border-radius: 10px;
    padding: 5px; font-size: 16px;
    color: white;
    border: none;
    background: rgb(200,50,50);
    margin: 20px;
    }

#green{
 color:green;
}
#red{
    color:red;
}
#orange{
    color: :orange;
}
#blue{
    color: blue;
}

.form_cont #des{
      height:120px;
  }
  .form_cont #art{
      height:400px;
  }
  .form_cont #cancelA{
      background:rgb(255,50,150);
  }
  #download{
    position: relative; left:70%; top:5px;
  }
  .form_cont #file{
      border: 1px solid black;

  }
  .form_cont #file:hover{
     border: 2px solid red; 
  }
    .footer{
        top: 210px;
    }
    h3{
        text-align: center;
        
    }

  h3{
  position:relative;
  top:20px;
  
  }
  </style>';


if(isset($_GET["msg_report"])){
     
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="/scripts/report_notice.js"></script>';
     
 }

require 'error_suc_msg.php';

echo '<h3>Unsubscribe From Our Mailing List </h3>'; 

 if(isset($_GET['user_email'])){
   $user_email = $_GET['user_email'];  
  
 echo '<div class="warning"><br><br>
<i>Please tell us why you would love to Unsubscribe from our mailing list ?</i>
<center>
<form action="/includes/unsubscribe.inc" method="post">

<input type="text" name="user_email" value="'.$user_email.'" placeholder="Enter your Email here" readonly>
<br><br>
<input type="text" name="reasons" placeholder="Enter Reasons Here" required>
<br>
<button type="submit" id="submit" name="submit_un_sub_email">Next</button>
 
</button> 
 </form></center>
 </div>
 
 <style>
 
  .warning form button{
     width:70%;
 }
 .warning form input{
    width:80%; 
    padding:10px;
    background:white;
    border: 1px solid black;
    border-radius:5px;
 }
 </style>';
     

}
elseif(isset($_GET['unsubscribe_email_report'])){
    
 $user_email = $_GET['email'];
 $report = $_GET['report'];
 
 echo '<div class="warning">
<br><center>
<i>'.$report.'</i></center>
<br><br>
<center>
<form action="/includes/unsubscribe.inc" method="post">

<button type="submit" id="submit" name="submit_un_sub_ok">Back to Home Page</button>

</button> 
  </form></center>
 </div>
 <style>
 
  .warning form button{
     width:80%;
 }
 </style>';
 
    
}

else{
    
  echo '<div class="warning">
<br>
<i>Please provide your email in the input box below to Unsubscribe from our mailing list</i><br><br>
<center>
<form action="/includes/unsubscribe.inc" method="post">
<input type="email" name="user_email" id="user_email" placeholder="Enter your Email here" required>
<br><br>
<input type="text" name="reasons" id="reasons" placeholder="Why do you want to Unsubscribe" required>
<br>
<button type="submit" id="submit" name="submit_un_sub_email">Next</button>

</button> 
 </form></center>
 </div>
 
 <style>
 
  .warning form button{
     width:70%;
 }
 .warning form input{
    width:80%; 
    padding:10px;
    background:white;
    border: 1px solid black;
    border-radius:5px;
 }
 </style>';
    
}

 echo '<style>
 .warning{
   top:50px;
     border-radius:20px;
 }
 .warning i{
     font-size:16px;
 }
 </style>';

echo '<br><br>';
   Addfooter($site); 
 
 ?>

</body>
</html>