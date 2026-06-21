<?php

class AssessmentInput {

    private $conn;
    private $std_class;
    private $session;
    private $term;
    private $std_id;
    private $staff_id;
    private $uploader;


    public function __construct($constructor){

       $this->conn = $constructor['conn'];
       $this->std_class= $constructor['std_class'];
       $this->session = $constructor['session'];
       $this->term = $constructor['term'];
       $this->std_id = $constructor['std_id'];
      $this->staff_id = $constructor['staff_id'];
      $this->uploader = $constructor['uploader'];
    }
    
    
 private function getClassData(){

 $clasDet = collect_user_data2($this->conn,"variables","type","value","Class",$this->std_class,"ss");

 $pattern = $clasDet['assessment_pattern'];

    return [
        'pattern' => $pattern,
        'subjects' => $this->getSubjects()
    ];
}


private function getSubjects(){

  $sub = collect_user_data4($this->conn,"class_set","staff_id","session","term","class",$this->uploader,$this->session,$this->term,$this->std_class,"isss");
$subs = convert_to_array($sub["subjects"]);

  $others = collect_user_data($this->conn,"students","std_id",$this->std_id,"i");
$added_subjects = convert_to_array($others["added_subjects"]);
$removed_subjects = convert_to_array($others["removed_subjects"]);

if($added_subjects){
 $subs = merge_into_array($added_subjects,$subs,"end",false);   
}

if($removed_subjects){
  
 $subs = remove_from_array($removed_subjects,$subs);
}

$subjects = [];
foreach ($subs as $sbId){
    
 $sel = collect_user_data2($this->conn,"variables","id","type",$sbId,"Subject","is");
    
 $subjectsArray = [ 
    "id" => $sbId, 
    "subject" => $sel["value"],
    "subject_cat" => $sel["classification"]
   ];
$subjects[] = $subjectsArray;

  }

 return $subjects;
}

  
private function getResults($subject){

$recordsTable = form_table_name("subject_records_",$this->session);

$results = collect_user_data4($this->conn,$recordsTable,"std_id","term","class","subject",$this->std_id,$this->term,$this->std_class,$subject,"isss");

   return $results;

  }  
  
  
 public function renderInputs(){

    $data = $this->getClassData();

    $pattern = $data['pattern'];
    $subjects = $data['subjects'];

    $ca_list = explode(':', $pattern);
    $maxca = array_sum($ca_list);
    $maxexam = 100 - $maxca;
   
echo '<table class="result-table">
  <tr>
    <th>S/N</th>
    <th>Subject Name</th>';

    foreach($ca_list as $index => $mark){

        $num = $index + 1;

        echo "<th>CA{$num}<br><small>({$mark})</small></th>";
    }

    echo "<th>Exam<br>
    <small>({$maxexam})</small></th>";
    echo '<th>Total<br>
    <small>(100)</small></th>
   <th style="font-size:10px;">Position
    <small style="font-size:8px;">In Subject</small></th>
    <th>Grade<br>
    <small>(A-F)</small></th></tr>';
    $sn=0;
    
  foreach($subjects as $subject){

   $result = $this->getResults($subject['id']);
   $sn++;
   echo '<tr>
   <td>'.$sn.'</td>
     <td>'.$subject['subject'].'</td>   
       <input
       type="hidden"
        name="subject_id[]"
       value="'.$subject['id'].'">';

       foreach($ca_list as $index => $mark){

            $field = 'ca'.($index + 1);

            $value = null_check($result[$field],"");

            echo '
            <td>
                <input
                    type="number"
                    name="'.$field.'[]"
                    value="'.$value.'"
                    max="'.$mark.'"
                    min="1"
                >
            </td>';
        }

      $exam = null_check($result['exam'], "");
      $total = null_check($result["total"],'Auto');
       $grade = null_check($result["grade"],'Auto');
       $pos = null_check($result["position"],'Auto');
    
        echo '
        <td>
            <input
                type="number"
                name="exam[]"
                value="'.$exam.'"
                max="'.$maxexam.'"
                min="10"
            >
        </td>  
         <td>
            <input
               id="total-auto"
               type="text"
               value="'.$total.'"
               readonly 
               disabled
            ></td>
            
             <td>
            <input
               id="total-auto"
               type="text"
               value="'.$pos.'"
               readonly 
               disabled
            ></td>
             <td>
            <input
               id="total-auto"
               type="text"
               value="'.$grade.'"
               readonly 
               disabled
            ></td>';

        echo '</tr>';
    }

    echo '</table>';
 }
}