<?php



session_start();
if( !isset( $_SESSION['zoo'])  ){
    $_SESSION['zoo'] = [];
    $_SESSION['id'] = 1;
}

// echo "<pre>";
//     print_r($_SESSION);
// echo "</pre>";
// $_SESSION['id'] = 1;

if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
    foreach ($_SESSION['zoo'] as $entry) {
       if($entry['id'] == $_GET['id']){
            $animal = $entry;
            break;
       }
    }
}

// ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])) ? "true" : "false";

if($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['id'])){
    // $animal = [];
    $animal['id'] = $_SESSION['id'];
    $animal['species'] = $_POST['species'];
    $animal['name'] = $_POST['name'];
    $animal['age'] = $_POST['age'];

    $_SESSION['id']++;
    
    $_SESSION['zoo'][] = $animal;
    header("location:./");
    die;
}


if($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['species'])){
    foreach ($_SESSION['zoo'] as $key => $animal) {
        if($animal['id'] == $_POST['id']){
         unset($_SESSION['zoo'][$key]);
         header("location:./");
         die;
        }  
    }

    header("location:./");
    die;
    }

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])  ){
   foreach ($_SESSION['zoo'] as &$animal) {
       if($animal['id'] == $_POST['id']){
        $animal['species'] = $_POST['species'];
        $animal['name'] = $_POST['name'];
        $animal['age'] = $_POST['age'];
        header("location:./");
        die;
       }  
   }
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <form class="form" action="" method="POST">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" >Gyvūno rūšis</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="species" value="<?= (isset($animal))? $animal['species'] : "" ?>">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 col-form-label" >Gyvūno vardas</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="name" value="<?= (isset($animal))? $animal['name'] : "" ?>">
            </div>
         </div>
         <div class="form-group row">
            <label class="col-sm-2 col-form-label" >Gyvūno amžius</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="age" value="<?= (isset($animal))? $animal['age'] : "" ?>">
            </div>
            
         </div>
    <?php if(!isset($animal)){
            echo '<button class="btn btn-primary" type="submit">Pridėti gyvūną</button>';
    }else{
            echo '
            <input type="hidden" name="id" value="'. $animal['id'].' ">
            <button class="btn btn-info" type="submit">Atnaujinti gyvūną</button>';
    } ?>
    </form>



    <table class="table">
        <tr>
        <th>Id</th> 
        <th>Rūšis</th> 
        <th>Vardas</th> 
        <th>Amžius</th> 
        <th>edit</th> 
        <th>delete</th> 
        </tr>


        <?php foreach ($_SESSION['zoo'] as $animal) {  ?>
            <tr>
            <td> <?= $animal['id']  ?> </td>
                <td> <?= $animal['species']  ?> </td>
                <td> <?= $animal['name']  ?> </td>
                <td> <?= $animal['age']  ?> </td>
                <td><a class="btn btn-success" href="?id=<?= $animal['id']  ?>">edit</a></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?=$animal['id']?>"  >
                        <button class="btn btn-danger" type="submit">delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>