<!DOCTYPE html>
<head>
  <title> Copiuță Tehnologii Web </title>
  <link rel="stylesheet" type="text/css" href="resurse/css/index.css">
  <link rel="stylesheet" type="text/css" href="resurse/css/catalog.css">
  <script src="resurse/js/mysql.js"></script>
</head>

<?php

$host_și_bd='mysql:host=localhost;dbname=BAZA_DE_DATE';
$user='UTILIZATOR';
$pass='PAROLA';

$con= new PDO($host_și_bd,$user,$pass);
?>
<body>
  <div id="titlu">
    <h1> Hack the Net!!! </h1>
    <h2> Catalog</h2>
  </div>
  <div id="meniu">
    <a href="index.html">Acasă</a>
    <a href="copiuțe.html">Copiuțe</a>
    <a href="catalog.php">Catalog</a>
    <a href="referințe.html">Referințe</a>
    <a href="despre.html">Despre</a>
  </div>


  <div id="conținut">
    <h3> Elevi </h3>
    <div class="bloc"> 
      <div id="tabelă_elevi" class="div_tabelă">

        <table id="elevi" class="tabela">
        <tr>
          <th> Număr de ordine </th>
          <th> Nume </th>
          <th> Prenume </th>
          <th> Vârstă </th>
        </tr>
        <?php 
          // verificat în include
          define('_DEFVAR', 1);

          include ('funcții.php');
          $date_mysql = selectează();
          printează_tabela($date_mysql);


        ?>
        </table>
      </div>
      <div id='modifică_tabela_elevi' class="modifică_tabela">
        <h4> Adaugă </h4>
        <form method="POST">
          <input type="text" name="nume" placeholder="Nume">
          <input type="text" name="prenume" placeholder="Prenume">
          <input type="text" name="varsta" placeholder="Vârstă">
          <input type="submit" value="Adaugă">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  $_POST['nume'] &&  
              $_POST['prenume'] &&  $_POST['varsta']){
                if(count($date_mysql) < 10) {
                  inserează('elevi',$_POST['nume'], $_POST['prenume'],intval($_POST['varsta']));
                  header("Refresh:0");
                }
                else {
                  echo "<script>alert('Ai atins limta de intrări gratuite')</script>";
                }
              }
        ?>
        <h4> Elimină </h4>
        <form method="POST">
          <input type="text" name="id_elev_elim" placeholder="Număr ordine">
          <input type="submit" value="Elimină">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['id_elev_elim']))
            {
              șterge('elevi',$_POST['id_elev_elim']);
              header("Refresh:0");
            }
        ?>
      </div>
    </div>

    <div class="bloc">
      <h3> Note </h3>  
      <div id="tabelă_note" class="div_tabelă">
        
        <form method="GET" id="form_selecție">
          <select name="id" id="selecție_select">
            <?php
            
            $lungime_date_sql = count($date_mysql);
            for ($i = 0; $i < $lungime_date_sql; $i++){
              echo "<option value=\"".$date_mysql[$i][0]."\" >".$date_mysql[$i][1]." ".$date_mysql[$i][2]."</option>";
            }
            
            ?>
          <input type="submit" value="Afișează">
          </select>
          
        </form>

        <table id="note" class="tabela">
        <tr>
          <th> Număr de ordine </th>
          <th> Număr de ordine elev </th>
          <th> Materia </th>
          <th> Nota </th>
        </tr>
        <?php 
          
        if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['id']) {
          $date_mysql_note = selectează('note','id_elev',$_GET['id']);
          printează_tabela($date_mysql_note);
        }

        ?>
        </table>
      </div>

    

      <div id='modifică_tabela_note' class="modifică_tabela">
      <h4> Adaugă </h4>
        <form method="POST">
          <?php
          if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['id']){
            echo "<input type=\"hidden\" name=\"id_elev\" value=\"".$_GET['id']."\">";
          }
          ?>
          <input type="text" name="materie" placeholder="Materie">
          <input type="text" name="nota" placeholder="Notă">
          <input type="submit" value="Adaugă">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  $_POST['id_elev'] &&  
              $_POST['materie'] &&  $_POST['nota']){
                if(count($date_mysql) < 200) {
                  inserează('note',$_POST['id_elev'], $_POST['materie'],intval($_POST['nota']));
                  header("Refresh:0");
                }
                else {
                  echo "<script>alert('Ai atins limta de intrări gratuite')</script>";
                }
              }
        ?>
        <h4> Elimină </h4>
        <form method="POST">
          <input type="text" name="id_nota" placeholder="Număr ordine">
          <input type="submit" value="Elimină">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  $_POST['id_nota'])
            {
              șterge('note',$_POST['id_nota']);
              header("Refresh:0");
            }
        ?>
      </div>
    </div>
  </div>
  <script>
    let search = new URLSearchParams(document.location.search);
    let rezultat = search.get('id');
    if (rezultat) {
      let opțiuni = document.getElementById('selecție_select');
      for (i = 0; i < opțiuni.options.length; i++){
        if(opțiuni.options[i].value == rezultat){
          document.querySelector('#selecție_select').value = rezultat;
        }
      }
    }
  </script>
</body>
</html>