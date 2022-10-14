<article>
    <h1>Aliment Courant</h1>
    <?php
        if (!isset($_GET['page'])) {
           $Lien = $Hierarchie['Aliment'];  
           ?> 
            <a href="?page=Aliment">Aliment</a> /
            <?php 
        }else{
            $Lien = $Hierarchie[$_GET['page']];
            ?> 
            <a href="?page=<?= htmlentities($_GET['page']) ?>"><?= htmlentities($_GET['page']) ?></a> /
            <?php 
        }
    ?>
    <ul>
    <?php
        foreach ($Lien as $key => $val) { 
            ?><h2><?= htmlentities($key) ?></h2> <?php
            foreach ($val as $key2 => $val2) {
                ?> <li><a href="?page=<?php echo $Lien[$key][$key2]; ?>"><?php echo $Lien[$key][$key2]; ?></a></li> <?php
            }
           
        }
    ?>
    </ul>
</article>