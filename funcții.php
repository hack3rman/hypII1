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
  return $comandă -> fetchAll(PDO::FETCH_NUM);
}

function printează_tabela($date_sql){
  $lungime_date_sql = count($date_sql);
  for ($i = 0; $i < $lungime_date_sql; $i++){
    echo "<tr>";
    for ($j = 0; $j < count($date_sql[$i]); $j++){
      echo "<td>";
      echo $date_sql[$i][$j];
      echo "</td>";
    }
    echo "</tr>";
  }
}

function inserează($tabel, $var_1, $var_2, $var_3){
  $vector = [$var_1, $var_2, intval($var_3)];
  foreach ($vector as &$membru) {
    $membru = preg_replace("/[^a-zA-Z 0-9ăîâșțĂÎÂȘȚ]+/", "", $membru );
  }
  global $con;
  $comandă = $con->prepare("INSERT INTO $tabel VALUES (DEFAULT, ?, ?, ?)");
  $comandă -> execute($vector);
}

function șterge($tabel, $var1) {
  global $con;
  $comandă = $con->prepare("DELETE FROM $tabel WHERE id = ?");
  $comandă -> execute([$var1]);
}
?>