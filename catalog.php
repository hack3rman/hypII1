<!DOCTYPE html>
<head>
  <title> Copiuță Tehnologii Web </title>
  <link rel="stylesheet" type="text/css" href="resurse/css/index.css">
  <link rel="stylesheet" type="text/css" href="resurse/css/catalog.css">
  <script src="resurse/js/catalog.js"></script>
</head>

<?php
  define('_DEFVAR', 1);
  include("config.php");
  $con= new PDO($host_și_bd,$user,$pass);
  if ($_SERVER['REQUEST_METHOD'] != 'POST')
    echo "<script>încarcă_poziție();</script>";

  include ('funcții.php');
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
    <a href="detalii_tehnice/">Detalii tehnice</a>
    <a href="despre.html">Despre</a>
  </div>


  <div id="conținut">
    <h3> Elevi     <button>Tabelă</button>    <div class="creare_tabelă">
      <?php
        print_r(nl2br(print_comandă_creare('elevi')));  
      ?>
    </div></h3>

    <div class="bloc">

      <div id="tabelă_elevi" class="div_tabelă">

        <table id="elevi" class="tabela">
        <tr>
          <th> Nr. crt. </th>
          <th> Nume </th>
          <th> Prenume </th>
          <th> Vârstă </th>
        </tr>
        <?php 
          $date_mysql = selectează();
          printează($date_mysql, count($date_mysql));


        ?>
        </table>
      </div>

      <div id='modifică_tabela_elevi' class="modifică_tabela">
        <h4> Adaugă </h4>
        <form method="POST">
          <input type="text" name="nume_elev" placeholder="Nume">
          <input type="text" name="prenume_elev" placeholder="Prenume">
          <input type="text" name="varsta" placeholder="Vârstă">
          <input type="submit" value="Adaugă" onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nume_elev']) &&  
              isset($_POST['prenume_elev']) && isset($_POST['varsta']) && $_POST['nume_elev'] &&  
              $_POST['prenume_elev'] &&  $_POST['varsta']){
                if(count($date_mysql) < 10) {
                  inserează('elevi',$_POST['nume_elev'], $_POST['prenume_elev'],intval($_POST['varsta']));
                  echo "<script>location.replace(location.href);</script>";
                }
                else {
                  echo "<script>alert('Ai atins limta de intrări gratuite')</script>";
                }
              }
        ?>
        <h4> Elimină </h4>
        <form method="POST">
          <input type="text" name="id_elev_elim" placeholder="Număr ordine">
          <input type="hidden" name="elimină_elev" value="true">
          <input type="submit" value="Elimină"  onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['id_elev_elim']) && $_POST['elimină_elev'])
            {
              șterge('elevi',$_POST['id_elev_elim']);
              echo "<script>location.replace(location.href);</script>";
            }
        ?>
      </div>
    </div>

    <h3> Note <button>Tabelă</button>
    <div class="creare_tabelă">
      <?php
        print_r(nl2br(print_comandă_creare('note')));  
      ?>
    </div></h3>
      
    <div class="bloc">
      
      <div id="tabelă_note" class="div_tabelă">
        
        <form method="GET" id="form_selecție">
          <select name="id" id="selecție_select" onchange="înregistrează_poziție();this.form.submit();">
            <option value="">Elev</option>
            <?php
            
            $lungime_date_sql = count($date_mysql);
            foreach ($date_mysql as $rând){
              echo "<option value=\"".$rând['id']."\" >".$rând['nume']." ".$rând['prenume']."</option>";
            }
            
            ?>
          </select>
          
        </form>

        <table id="note" class="tabela">
        <tr>
          <th> Nr. crt. </th>
          <th> Materia </th>
          <th> Nota </th>
        </tr>
        <?php 
          
        if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['id']) {
          $date_mysql_note = selectează_note('note','id_elev',$_GET['id']);
          printează($date_mysql_note,count($date_mysql_note));
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
          <select name='id_materie'>
            <?php
              if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET['id']){
                $date_mysql_materii = selectează('materii');
                foreach($date_mysql_materii as $materie){
                  echo "<option value=\"".$materie['id']."\">".$materie['materie']."</option>";
                }
              }
            ?>
          </select name="materie">
          <input type="text" name="nota" placeholder="Notă">
          <input type="submit" value="Adaugă" onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['id_elev']) &&  
              isset($_POST['id_materie']) &&  isset($_POST['nota'])){
                if ($_POST['nota'] <11){
                if(count($date_mysql) < 200) {
                  inserează('note',$_POST['id_elev'], $_POST['id_materie'],intval($_POST['nota']));
                }
                else {
                  echo "<script>alert('Ai atins limta de intrări gratuite')</script>";
                }
              }
              echo "<script>location.replace(location.href);</script>";
            }
        ?>
        <h4> Elimină </h4>
        <form method="POST">
          <input type="text" name="id_nota" placeholder="Număr ordine">
          <input type="hidden" name="elimină_notă" value="true">
          <input type="submit" value="Elimină"  onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['id_nota']) && isset($_POST['elimină_notă']))
            {
              șterge('note',$_POST['id_nota']);
              echo "<script>location.replace(location.href);</script>";
            }
        ?>
      </div>
    </div>

    <h3> Materii <button>Tabelă</button>    <div class="creare_tabelă">
      <?php
        print_r(nl2br(print_comandă_creare('materii')));  
      ?>
    </div></h3>  

    <div class="bloc">

      <div id="tabelă_materii" class="div_tabelă">

        <table id="note" class="tabela">
        <tr>
          <th> Nr. crt. </th>
          <th> Materia </th>
        </tr>
        <?php 
          $date_mysql_materii = selectează('materii');
          printează($date_mysql_materii,count($date_mysql_materii));
        ?>
        </table>

      </div>

    

      <div id='modifică_tabela_materii' class="modifică_tabela">
      <h4> Adaugă </h4>
        <form method="POST">
          <input type="text" name="materie" placeholder="Materie">
          <input type="submit" value="Adaugă" onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  $_POST['materie']){
                if(count($date_mysql) < 20) {
                  inserează('materii',$_POST['materie']);
                }
                else {
                  echo "<script>alert('Ai atins limta de intrări gratuite')</script>";
                }
                echo "<script>location.replace(location.href);</script>";
              }
          
        ?>
        <h4> Elimină </h4>
        <form method="POST">
          <input type="text" name="id_materie" placeholder="Număr ordine">
          <input type="hidden" name="elimină_materie" value="true">
          <input type="submit" value="Elimină"  onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['id_materie']) && isset($_POST['elimină_materie']))
            {
              șterge('materii',$_POST['id_materie']);
              echo "<script>location.replace(location.href);</script>";
            }
        ?>
      </div>
    </div>
    
    <h3> Profesori <button>Tabelă</button>    <div class="creare_tabelă">
      <?php
        print_r(nl2br(print_comandă_creare('profesori')));  
      ?>
    </div></h3>  

    <div class="bloc">

      <div id="tabelă_profesori" class="div_tabelă">

        <table id="note" class="tabela">
        <tr>
          <th> Nr. crt. </th>
          <th> Nume</th>
          <th> Prenume </th>
        </tr>
        <?php 
          
        $date_mysql_note = selectează('profesori');
        printează($date_mysql_note,count($date_mysql_note));
        ?>
        </table>
      </div>

    

      <div id='modifică_tabela_profesori' class="modifică_tabela">
      <h4> Adaugă </h4>
        <form method="POST">
          <input type="text" name="nume_profesor" placeholder="Nume">
          <input type="text" name="prenume_profesor" placeholder="Prenume">
          <input type="submit" value="Adaugă" onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['nume_profesor']) &&  
              isset($_POST['prenume_profesor'])){
                if(count($date_mysql) < 20) {
                  inserează('profesori',$_POST['nume_profesor'], $_POST['prenume_profesor']);
                  echo "<script>location.replace(location.href);</script>";
                }
                else {
                  echo "<script>alert('Ai atins limta de intrări gratuite')</script>";
                }
              }
        ?>
        <h4> Elimină </h4>
        <form method="POST">
          <input type="text" name="id_profesor" placeholder="Număr ordine">
          <input type="hidden" name="elimină_profesor" value="true">
          <input type="submit" value="Elimină"  onclick="înregistrează_poziție()">
        </form>
        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['id_profesor']) &&  isset($_POST['elimină_profesor']))
            {
              șterge('profesori',$_POST['id_profesor']);
              echo "<script>location.replace(location.href);</script>";
            }
        ?>
      </div>
    </div>


  </div>
  <script>
  </script>
</body>
</html>