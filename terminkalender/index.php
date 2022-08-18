<?php
require_once 'db.php';

date_default_timezone_set('Europe/Berlin');

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

$heute = date('Y-m-j', time());

$monatsAnzeige = date('m / Y', $timestamp);

$vorigerMonat = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$naechsterMonat = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));
$anzahlTage = date('t', $timestamp);
 
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

$wochen = array();
$woche = '';
$woche .= str_repeat('<td></td>', $str);

for($tag=1;$tag <=$anzahlTage;$tag++, $str++) {
     $datum = $ym . '-' . $tag;
    if ($heute == $datum) {
        $woche .= '<td class="heute">' . $tag;
    } else {
        $woche .= '<td>' . $tag;
    }
    $woche .= '</td>'; 
    if ($str % 7 == 6 || $tag == $anzahlTage) {

        if ($tag == $anzahlTage) {
            $woche .= str_repeat('<td></td>', 6 - ($str % 7));
        }
        $wochen[] = '<tr>' . $woche . '</tr>';
        $woche = '';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PHP Kalendar</title>
    <style>
        .container {
            font-family: sans-serif;
            margin-top: 80px;
			border:1px solid black;
			display:inline-block;
			padding:4px;
        }
			
        h3 {
            margin-bottom: 30px;
			text-align: center;
        }
        th {
            height: 30px;
			width: 100px;
            text-align: center;
			border:1px solid black;
			display:inline-block;
			padding:4px;
        }
        td {
            height: 100px;
			width: 100px;
			text-align: top;
			border:1px solid black;
			display:inline-block;
			padding:4px;
        }
        .heute {
            background: green;
        }
		.termin {
			background: red;
		}	
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
    </style>
</head>
<body>
<h1>Terminkalender</h1>
<div class="container">
  <h3><a href="?ym=<?php echo $vorigerMonat; ?>">&lt;</a> <?php echo $monatsAnzeige; ?> <a href="?ym=<?php echo $naechsterMonat; ?>">&gt;</a></h3>
  <table class="table table-bordered">
      <tr>
      <th>So</th>
      <th>Mo</th>
      <th>Di</th>
      <th>Mi</th>
      <th>Do</th>
      <th>Fr</th>
      <th>Sa</th>
      </tr>
<?php
foreach ($wochen as $woche) {
    echo $woche;
}
?>
   </table>
<?php echo "Legende: </br> Grün: für aktuellen Tag </br>Rot: für Termine"; ?>
<form action="terminhinzufuegen.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="submit" value="Termin hinzufügen" />
</form>
<form action="terminloeschen.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="submit" value="Termin löschen" />
</form>
<form action="terminbearbeiten.php" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
<input type="submit" value="Termin bearbeiten" />
</form>  
</div>
</body>
</html>