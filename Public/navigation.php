<article>
    <h1>Aliment Courant</h1>
    <?php
        if (!isset($_GET['page'])|| $_GET['page'] == 'Aliment') {
           $Lien = $Hierarchie['Aliment'];  
           ?> 
            <a href="?page=Aliment">Aliment</a> /
            <?php 
            $chemin[] = "Aliment";
        }else{
            $chemin = $_SESSION['chemin'] ;
            $i = count($chemin);
            $Lien = $Hierarchie[$_GET['page']];
            $chemin[] = $_GET['page'];
            if ($chemin[$i] == $chemin[$i-1]) {
                array_splice($chemin, $i);
                $i--;
            }
            if ($i >= 3) {
                if ( $chemin[$i] == $chemin[$i-2] ||  $chemin[$i] == $chemin[$i-3]) {
                    do{
                        array_splice($chemin, $i);
                        $i--;
                    }while ($chemin[$i] != $_GET['page']);
                }
            }
            if ( $i > 1) {
                ?>
                <a href="?page=<?php echo $chemin[$i-2]; ?>"><?php echo $chemin[$i-2]; ?></a> /
                <?php
            }
            else
            ?> 
            <a href="?page=<?php echo $chemin[$i-1]; ?>"><?php echo $chemin[$i-1]; ?></a> /
            <a href="?page=<?= htmlentities($_GET['page']) ?>"><?= htmlentities($_GET['page']) ?></a> /
            <?php 
        }

        $_SESSION['chemin'] = $chemin;
        
    ?>
    <ul>
    <?php
        foreach ($Lien as $clé => $val) { 
            if ($clé != 'super-categorie') {
                ?><h2><?= htmlentities($clé) ?></h2> <?php
                foreach ($val as $clé2 => $val2) {
                    ?> <li><a href="?page=<?php echo $Lien[$clé][$clé2]; ?>"><?php echo $Lien[$clé][$clé2]; ?></a></li> <?php
                } 
            }
        }
    ?>
    </ul>
</article>