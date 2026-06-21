<?php

$resultTableName = form_table_name("results_",$session);

$resultTableDetails = [
     
    "table_name" => $resultTableName,

    "table_columns" => [
        "id",
        "staff_id",
        "std_id",
        "std_cat",
        "term",
        "class",
        "total_score",
        "total_scorable",
        "subject_num",
        "overall_average",
        "overall_grade",
        "general_remark",
        "position_inclass",
        "teacher_comment",
        "principal_comment",
        "activeness",
         "attendance",
         "punctuality",
         "self_control",
         "honesty",
         "humility",
         "leadership",
         "hand_writing",
         "fluency",
         "musical_skills",
         "sports",
        "result_status",
        "date_created",
    ],

    "column_type" => [
        "INT",
        "INT",
        "INT",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
        "INT",
        "INT",
        "VARCHAR",
        "DECIMAL",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
        "TEXT",
        "TEXT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
       "VARCHAR",
       "VARCHAR",
    ],

    "column_length" => [
        "",
        "",
        "",
        "100",
        "100",
        "100",
         "",
         "",
        "100",
        "10,2",
         "100",
         "100",
         "100",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "",
         "100",
         "100",
    ],

    "column_default" => [
        "",
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
       "0.00",
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
      
    ],

    "column_null" => [
        "NOT NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
    ],

    "column_index" => [
        "staff_id",
        "std_id",
        "term",
        "class"
    ],

    "primary_column" => "id"
];


$subjectTableName = form_table_name("subject_records_",$session);

$subjectTableDetails = [
     
    "table_name" => $subjectTableName,

    "table_columns" => [
        "id",
        "staff_id",
        "std_id",
        "term",
        "class",
        "class_cat",// Science/Art/General
        "subject",
        "ca1",
        "ca2",
        "ca3",
        "ca4",
        "exam",
        "total",
        "position",
         "grade",
        "result_status",
        "date_created",
    ],

    "column_type" => [
        "INT",
        "INT",
        "INT",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "INT",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
       
    ],

    "column_length" => [
        "",
        "",
        "",
        "100",
        "100",
        "100",
        "100",
         "",
         "",
         "",
         "",
         "",
         "",
        "100",
        "100",
        "100",
        "100",
    ],

    "column_default" => [
        "",
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
      
    ],

    "column_null" => [
        "NOT NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
       
    ],

    "column_index" => [
        "staff_id",
        "std_id",
        "term",
        "class"
    ],

    "primary_column" => "id"
];


$classSetTableName = "class_set";
$classSetTableDetails = [
     
    "table_name" => $classSetTableName,

    "table_columns" => [
        "id",
        "staff_id",
        "session",
        "term",
        "class",
       "students",//implode std ids using :
       "subjects",//implode subjects offered by this class using :
       "date_created",
    ],

    "column_type" => [
        "INT",
        "INT",
        "VARCHAR",
        "VARCHAR",
        "VARCHAR",
        "TEXT",
        "TEXT",
        "VARCHAR",
      
    ],

    "column_length" => [
        "",
        "",
        "100",
        "100",
        "100",
         "",
         "",
        "100",
      
    ],

    "column_default" => [
        "",
        null,
        null,
        null,
        null,
        null,
        null,
        null,
      
    ],

    "column_null" => [
        "NOT NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
        "NULL",
     
    ],

    "column_index" => [
        "staff_id",
        "session",
        "term",
        "class"
    ],

    "primary_column" => "id"
];





