<?php

init();

function init()
{
    session_start();
    if( !isset( $_SESSION['zoo'])  ){
        $_SESSION['zoo'] = [];
        $_SESSION['id'] = 1;
    }
}

function edit(){
    foreach ($_SESSION['zoo'] as $animal) {
        if($animal['id'] == $_GET['id']){
           return $animal;
        }
     }
}

function store(){
    $animal['id'] = $_SESSION['id'];
    $animal['species'] = $_POST['species'];
    $animal['name'] = $_POST['name'];
    $animal['age'] = $_POST['age'];

    $_SESSION['id']++;
    
    $_SESSION['zoo'][] = $animal;
}

function destroy(){
    foreach ($_SESSION['zoo'] as $key => $animal) {
        if($animal['id'] == $_POST['id']){
         unset($_SESSION['zoo'][$key]);
         return;
        }
    }
}

function update(){
    foreach ($_SESSION['zoo'] as &$animal) {
        if($animal['id'] == $_POST['id']){
         $animal['species'] = $_POST['species'];
         $animal['name'] = $_POST['name'];
         $animal['age'] = $_POST['age'];
            return;
        }  
    }
}

?>