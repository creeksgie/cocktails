<span>
    
<?php
$TabCo = null;
$nom_photo = null;

if (isset($_COOKIE['L'.$_GET['Recettes']])) {
    if ($_COOKIE['L'.$_GET['Recettes']] != "false") {
        if (isset($_SESSION['like'])) {
            $TL = $_SESSION['like'];
         }
        if (!in_array($_GET['Recettes'], $TL)) {
         $TL[] = $_COOKIE['L'.$_GET['Recettes']];
         $_SESSION['like'] = $TL;
        }
         //var_dump($_SESSION['like']);
    }else
    {
        if (isset($_SESSION['like'])) {
            $TL = $_SESSION['like'];
            $pos = array_search($_GET['Recettes'], $TL);
            array_splice($TL, $pos);
            $_SESSION['like'] = $TL;
        }
    }
    
}
?>
<button class="btn" onclick="Like(<?php echo $_GET['Recettes']; ?>)">
            <?php 
            if(isset($_SESSION['like'])) {
                if (in_array($_GET['Recettes'],$_SESSION['like'])) {
                    ?>
                    <img id="<?php echo $_GET['Recettes'];?>" class="svg"  src="..\svg\coeurplein.svg" alt="">
                    <?php
                } else {
                    ?>
                    <img id="<?php echo $_GET['Recettes'];?>" class="svg"  src="..\svg\coeurvide.svg" alt="">
                    <?php
                }
            } else {
                ?>
                    <img id="<?php echo $_GET['Recettes'];?>" class="svg"  src="..\svg\coeurvide.svg" alt="">
                    <?php
            }

            ?>
</button>
<?php
Afficher_Image($Recettes[$_GET['Recettes']][array_keys($Recettes[$_GET['Recettes']])[0]]);
?>
<br>
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

<script>
        function Like(indice){
            var btn = document.querySelector(".btn");
            var svg = document.getElementById(indice);
            if (svg.src.match("coeurvide.svg")) {
                svg.src = "../svg/coeurplein.svg";
                document.cookie ='L'+indice+'='+indice;
            } else {
                svg.src = "../svg/coeurvide.svg";
                document.cookie ='L'+indice+'=false';
            }
            location.reload();
        }
    </script>