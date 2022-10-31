<span>
<?php
echo $Recettes[$_GET['Recettes']]["titre"];
?> <br>
<?php
echo $Recettes[$_GET['Recettes']]["ingredients"];
?> <br>
<?php
echo $Recettes[$_GET['Recettes']]["preparation"];
foreach ($Recettes[$_GET['Recettes']]["index"] as $key4) {
?> <li><?= htmlentities($key4) ?></li>
<?php
}

?>
</span>