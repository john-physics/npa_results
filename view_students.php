<?php
 require 'page_init.php';

if(!check_staff_login($conn)){

header("Location:/home");
exit();
}


head('Students Details',"$site | Students Details",""); //add header 
require 'menu.php';

// <!-- Message send report -->
 if(isset($_GET["msg_report"])){
 
   $msg = $_GET["msg_report"];
   $report = $_GET["report"];
   
   report_notice($report,$msg); 
   
  echo '<script src="scripts/report_notice.js"></script>';
     
 }
  
 require './error_suc_msg.php'; // detect and display error Messages if any
require './custom_alert.php'; 
require './script_errors.php'; 

echo '<style>

body {
    font-family: "Segoe UI", sans-serif;
    background: #eef2f7;
    margin: 0;
}

.class-container {
    width: 100%;
    margin: 40px auto;
    background: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow:auto;
}



.top-bar {
    text-align: right;
    margin: 20px 0;
}

.btn {
    background: #3498db;
    color: white;
    padding: 10px 18px;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background: #2980b9;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #34495e;
    color: #fff;
    padding: 12px;
    text-align: center;
}

td {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

tr:hover {
    background: #f9f9f9;
}

  tr:nth-child(odd){
    background: rgba(0,0,0,0.04);
  }
  
.action-btns{
display:flex;
gap:10px;

}
 .download-btn {
    background: #27ae60;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
} 
.preview-btn {
    background: rgb(230,50,50);
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 5px;
    text-decoration: none;
    
}

.download-btn:hover {
    background: #1e8449;
}

.preview-btn:hover {
    background: #d68910;
}


.pinpup-overlay {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.6);
  justify-content: center;
  align-items: center;
  z-index:1000;
}

.popup-box {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 300px;
  text-align: center;
}
.popup-box h3{
  font-size:20px; 
 color: #2196f3;   
    
}
.popup-box p{
  font-size:10px; 
 
    
}
.pinpup-actions {
  margin-top: 15px;
 
}

.pinpup-actions button {
  margin: 5px;
   width:45%;
   padding:10px;
   border-radius:10px;
   border:none;
   color:#fff;
}

.pinpup-actions #cancelpinBtn{
  background: #f44336;

}

.pinpup-actions #proceedBtn{
  background:  #4caf50;

}

 .acct-container {
     position:relative;
      max-width: 500px;
      margin: auto;
      background-color: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
  .acct-container a{
      text-decoration:none;
      color: rgb(0,100,150);
      font-weight:bold;
  }
    .acct-container a:hover{
      text-decoration:underline;
      color: rgb(150,100,10);
      font-weight:bold;
  }
   .acct-container h1 {
     
    display:block;
      text-align: center;
      color: #093d8f;
      margin-bottom: 30px;
      margin-left: 40px;
      position:relative;
      gap:20px;
      font-size:18px;
      overflow:auto;
    }

    .info-item {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 18px;
      
    }

    .label {
      font-weight: 600;
      min-width: 120px;
      color: #5c5c5c;
      font-size:14px;
    }

    .value {
      font-weight: 500;
      color: #1a1a1a;
     margin-left:10px;
    }
    
    .status {
      background-color: #4caf50;
      color: white;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 15px;
      font-size: 14px;
      display: inline-block;
      
    }
    
     .category-row {
      display: flex;
      align-items: center;
      gap: 5px;
    }
    .category-row a{
        text-decoration:none;
        color:#fff;
    }
     .update-link {
     color: #fff;
      background-color: #0066cc;
      font-size: 12px;
      padding: 5px 10px;
      border-radius: 5px;
      text-decoration: none;
      transition: background-color 0.3s ease;
      position:relative;
      left:5px;
    }

    .update-link:hover {
      background-color: #004a99;
    }   

.status-badge {
  color: white;
  font-weight: 600;
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 14px;
  display: inline-block;
  transition: all 0.3s ease;
  animation: fadeIn 0.4s ease;
  text-align:center;
  
}

.status-badge:hover {
  box-shadow: 0 0 8px rgba(0,0,0,0.2);
  transform: scale(1.05);
}

.green_status {
  background-color: #4caf50;
}


.red_status {
  background-color: #f44336;
}


.yellow_status {
  background-color: #ff9800;
}


.gold_status {
  background-color: #c6a700;
  color: #fff8e1;
}


.blue_status {
  background-color: #2196f3;
}

.remove_cat button {

   position:relative;
   width:100%;
   margin: 20px auto;
   padding:10px;
   color:#fff;
   background:#f44336; 
   cursor:pointer;
   border-radius:5px;
   border:none;
   box-shadow:none;
   font-size:14px;
   font-weight:600;
}
.remove_cat button:hover{
    
   background:#ff9800; 
}

.table_btn{
  display:flex;
  flex-direction: space-between;
  gap:7px;
    
}

.view-btn {
    background: #27ae60;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    text-decoration: none;
    cursor:pointer;
}

.delete-btn {
    background: rgb(230,50,50);
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 5px;
    text-decoration: none;
    cursor:pointer;
}

.edit-btn {
    background: rgb(50,150,150);
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    margin-right: 5px;
    text-decoration: none;
    cursor:pointer;
}


.view-btn:hover {
    background: #1e8449;
}

.delete-btn:hover {
    background: #d68910;
}
.edit-btn:hover {
    background: rgb(150,150,150);
}


.category-wrapper{
    background:#fff;
    padding:10px;
    overflow-x:auto;
    white-space:nowrap;
    display:flex;
    gap:12px;
    position:relative;
    top:10px;
  /*  z-index:997; */
    box-shadow:0 2px 8px rgba(0,0,0,0.05);

    scrollbar-width:none;
}

.category-wrapper::-webkit-scrollbar{
    display:none;
}

.category-link{
    text-decoration:none;
    background:#eceff5;
    color:#333;
    padding:10px 18px;
    border-radius:50px;
    font-size:14px;
    font-weight:500;
    transition:0.3s;
    flex-shrink:0;
}

.category-link:hover,
.category-link.active{
    background:#203a43;
    color:#fff;
}

.student-photo{
    
    width:80px;
    height:80px;
     border-radius:10px;
     padding:2px;
}

</style>';



echo '<section class="section">
<h2>View Students</h2>';

$current_class = null_check($_GET["view_class"],"PRE-SCHOOL 1");
  
 echo '<div class="category-wrapper">';
 $classes = sortClasses(collect_table_data1($conn,"variables","type","Class","s","","value"));

foreach($classes as $class){

$active = ($current_class == $class) ? "active" : "";

    echo '
    <a class="category-link '.$active.'" 
       href="?view_class='.urlencode($class).'">
       '.$class.'
    </a>';
}
echo '</div>';


$students = collect_table_data1($conn,"students","current_class",$current_class,"s","surname ASC");


echo '<div class="class-container">
<table>
    <thead>
        <tr>
       <th>S/N</th>
       <th>Student\'s Photo</th>
        <th>Student\'s Name</th>
      <th>Admision Year</th>
       <th>Gender</th>
         <th>D.O.B</th>
          <th>State</th>
       <th>L.G.A</th>
         <th>Resident</th>
       <th>Parent\'s Name</th>
       <th>Parent\'s Number</th>
        <th>Parent\'s Email</th>
         <th>Actions</th>
            </tr>
        </thead>

        <tbody>';
        
    if(!$students){
        
   echo ' <tr>
     <td colspan="13" style="text-align:center;">No student found in the selected class.</td>
     </tr>';    
        
    }
   
   else{
    
    $sn =0;  
   foreach ($students as $student) {

  $std_id =$student["std_id"];
  $parent_name  = null_check($student["parent_name"],"Unknown");
 $parent_email  = null_check($student["parent_email"],"None");
 $pnum = $student["parent_number"];
 $parent_num = null_check(std_num($pnum,"cc"),"None");
  $sur = $student["surname"];
  $oth = $student["othernames"];
   $sur = ucwords(strtolower($sur));
  $oth = ucwords(strtolower($oth));
 $student_name = $sur." ".$oth;

 // $lastlogin = timeAgo($student["lastlogin"],'d/m/Y h:i A');
 
  $acct_status = $student["status"];
  $prf = $student["profile"]??'null.jpg';
   $prf_link = '/images/students/'.$prf;

 if(!file_exists($_SERVER["DOCUMENT_ROOT"].$prf_link)){
 $prf_link = "/images/npa-logo.jpg";
 }
 
$state = null_check($student["std_state"],'Unknown');
  $lga = null_check($student["std_lga"],'Unknown');
$resident = null_check($student["resident"],'Unknown');
$pin = null_check($student["std_pin"],'None');
$year = null_check($student["year_admitted"],'Unknown');

$gender = null_check($student["gender"],'Unknown');

$dob =  null_check($student["birth_date"],'Unknown');

    $sn++;
      
     echo '<tr>
      <td>'.$sn.'.</td>
      <td>
      <img src="'.$prf_link.'" alt="student photo" loading="lazy"  class="student-photo" >
      
      </td>
      <td>'.$student_name.'</td>
      <td>'.$year.'</td>
      <td>'.$gender.'</td>
      <td>'.$dob.'</td>
     <td>'.$state.'</td>
      <td>'.$lga.'</td>
      <td>'.$resident.'</td>
     <td>'.$parent_name.'</td>
      <td>'.$parent_num.'</td>
      <td>'.$parent_email.'</td>
      <td>
 
 <div class="action-btns">  
 <a href="/add_new?add_new_stds&action=edit-record&std='.$std_id.'&user_type=Student" class="download-btn"><i class="fa-solid fa-pen-to-square"></i></a>
   
   </div> 
    </td>
     </tr>';   
        
    }
    
    
    
  }  
echo '</tbody>
    </table>
</div>';


 $current = get_current_session();
 $session = null_check($current['session'],'Unknown');
 $term= null_check($current['term'],'Unknown');

$totalStds = count_user_data($conn,"students","status","Active","s");

echo '<div class="acct-container">

     <div class="info-item">
     <span class="label">Current Session:</span>
     <span class="status-badge green_status">'.$session.' </span>
    </div> 
    
      <div class="info-item">
     <span class="label">Current Term:</span>
      <span class="status-badge blue_status">'.$term.' </span>
    </div>
    
    <div class="info-item">
     <span class="label">Total Active Students:</span>
      <span class="value"> '.number_format($totalStds).' </span>
    </div>

</div>

</section>';


Addfooter($site); 