<?php

defined('_DEFVAR') or exit('Restricted Access');

function selectează($tabel = 'elevi' , $coloană = '', $valoare = ''){
  global $con;
  $comandă = $con->prepare("SELECT * FROM $tabel");
  if ($coloană != '') {
    $comandă = $con->prepare("SELECT * FROM $tabel WHERE $coloană = ?");
    $comandă -> bindParam (1, $valoare);
  }
  $comandă -> execute();
  return $comandă -> fetchAll(PDO::FETCH_ASSOC);
}

function selectează_note($tabel = 'elevi' , $coloană = '', $valoare = ''){
  global $con;
  $comandă = $con->prepare("SELECT note.id,materie,notă FROM note INNER JOIN
  materii ON materii.id = note.id_materie where id_elev = ?;");
  $comandă -> bindParam (1, $valoare);
  $comandă -> execute();
  return $comandă -> fetchAll(PDO::FETCH_ASSOC);
}

function printează($date_sql, $numar_randuri, $harta_ieșire=[]){
  for ($rand = 0; $rand < $numar_randuri; $rand++){
    echo "<tr>";
    foreach ($date_sql[$rand] as $cheie => $valoare){
      if ( array_key_exists($cheie, $harta_ieșire)){
        continue;
      }
      echo "<td>";
      echo $valoare;
      echo "</td>";
    }
    echo "</tr>";
  }
}

function printează_note($date_sql, $numar_randuri, $harta_ieșire=[]){
  for ($rand = 0; $rand < $numar_randuri; $rand++){
    echo "<tr>";
    foreach ($date_sql[$rand] as $cheie => $valoare){
      if ( $cheie != 'prenume') 
        echo "<td>";
      echo $valoare." ";
      if ( $cheie != 'nume')
        echo "</td>";
    }
    echo "</tr>";
  }
}

function inserează($tabel, $var_1, $var_2 = '', $var_3 = ''){
  $vector = [$var_1];
  foreach ($vector as &$membru) {
    $membru = preg_replace("/[^a-zA-Z 0-9ăîâșțĂÎÂȘȚ]+/", "", $membru );
  }
  global $con;
  $text_comandă = "INSERT INTO $tabel VALUES (DEFAULT, ?";
  if ($var_2) {
    array_push($vector,$var_2);
    $text_comandă = $text_comandă . ", ?";
    if ($var_3) {
      array_push($vector, $var_3);
      $text_comandă = $text_comandă . ", ?";
    }
  }
  $text_comandă = $text_comandă . ")";
  $comandă = $con->prepare($text_comandă);
  $comandă -> execute($vector);
}

function șterge($tabel, $var1) {
  global $con;
  $comandă = $con->prepare("DELETE FROM $tabel WHERE id = ?");
  $comandă -> execute([$var1]);
}

function print_comandă_creare($tabelă){
  global $con;
  $comandă = $con->prepare("SHOW CREATE TABLE $tabelă");
  $comandă -> execute();
  return $comandă -> fetchAll()[0]['Create Table'];
  return $comandă;
}
?>