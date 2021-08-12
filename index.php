
<?php
/*
1. susikurti index.php, functions.php
2. index.php sukurti duomenu suvedimo forma su POST metodu. Forma kreipsis atgal į tą patį puslapį.
    2.1 formos turinys: name, surname, sport, country, gender, victories;
3. includiname functions.php į index.php failą jo viršuje. 

4. functions.php. susukuriame funkciją init. Ji patikrina ar sesijoje yra 'olympics' key, jei nėra - 
sukuria 'olympics' masyvą sesijoje bei 'id' kintamajį sesijoje. su defaultinėmis reikšmėmis, "[]" ir "0";
5. functions php paleisti init funkciją.

//darome duomenų įvedimą.
index.php susikuriame IF sąlygą kuri tikrina ar mes kuriame naują įrašą;
jo viduje iškviečiame store() funkciją kurią aprašysite functions.php faile. funkcijai baigus darbą, 
redirectinate į index.php;

store:
pasakote, kad į olypmics masyvą(kuris yra sesijoje) įdėsite dar vieną elementą, kuris bus:
a) masyvas;
b) sukonstruotas 'key'=> 'value' principu.
c) jums reikės įdėti id kurį gausite iš sesijos, nepamirškite jo padidinti.

atvaizduojame visus duomenis index.php faile. pasinaudojam table, ir jei pavyks -bootstrap.
(į html head dalį įkeliate šias eilutes)
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  nepamirškite edit/delete mygtukų. į juos abu perduodame athlete['id'];

edit
parašome index.php IF sąlygą kuri tikrina ar jūs paspaudėte edit mygtuką. mygtukas yra get, ir nešasi id.
kviečia edit funkcija, ir tai ką ji gražina - priskiria $athlete kintamąjam.
to kintamojo reikšmėmis užpildome formą. NEPAMIRŠKITE Į FORMĄ ĮDĖTI HIDDENT INPUT KURIS NEŠTŲSI ID
edit()
paima olypmics, suka ciklą per šį masyvą, tikrina kiekvieną masyvo elemento id, ir lygina jį su get[id]
kai randa tą konkretų atletą, JĮ returnina į ten kur buvo iškviesta funkcija.


update
parašome index.php IF sąlygą kuri tikrina ar jūs postinate formą ir ar forma turi id
kviečia update funkciją, ir redirectina.
update();
paima olypmics, suka ciklą per šį masyvą, tikrina kiekvieną masyvo elemento id, ir lygina jį su post[id]
ir kai randa tą konkretų atletą, pakeičia jo reikšmes reikšmėmis iš posto. ir iš karto returntina
(tušias returnas, kad nutraukti ciklą);

destroy
parašome index.php IF sąlygą kuri tikrina ar kreiptasi post metodu, ir ar NĖRA kurio nors iš formos
kintamojo(tik ne id). redirectiname.
paima olypmics, suka ciklą per šį masyvą, tikrina kiekvieną masyvo elemento id, ir lygina jį su post[id]
kai randa tą konkretų atletą, jį unsetina, ir iš karto returntina (tušias returnas, kad nutraukti ciklą);












*/







include('./functions.php');
//fill form for edit
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['id'])){
    $animal = edit();
}

//store
if($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['id'])){
    store();
    header("location:./");
    die;
}

//destroy
if($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['species'])){
    destroy();
    header("location:./");
    die; 
}

//update    
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['id'])  ){
    update();
    header("location:./");
    die;
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


        <?php $count = 0; foreach ($_SESSION['zoo'] as $animal) {  ?>
            <tr>
            <td> <?= ++$count."/".$animal['id']  ?> </td>
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