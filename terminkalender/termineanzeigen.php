<?php

function alleTermineLaden() {
    $termine=array();
    $result=$db->query("select * from termin");
    while($thema=$result->fetch_object('Termin')) {
      $termine[]=$termin;
    }
    $result->free();
    return $termin;
}

$id=isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(empty($id)) {
  //keine valide ID von der URL bekommen: zurück zur Liste
  header('Location:index.php');
  exit;
}

?>