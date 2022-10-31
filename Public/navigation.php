<article>
    <h2>Aliment Courant</h2>
    <span>
    <?php
    if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {
        $Lien = $Hierarchie['Aliment'];
    ?>
        <a href="?page=Aliment">Aliment</a> /
        <?php
        $chemin[] = "Aliment";
    } else {
        $chemin = $_SESSION['chemin'];
        $i = count($chemin);
        $Lien = $Hierarchie[$_GET['page']];
        $chemin[] = $_GET['page'];
        if ($chemin[$i] == $chemin[$i - 1]) {
            array_splice($chemin, $i);
            $i--;
        }
        if ($i >= 3) {
            if ($chemin[$i] == $chemin[$i - 2] ||  $chemin[$i] == $chemin[$i - 3]) {
                do {
                    array_splice($chemin, $i);
                    $i--;
                } while ($chemin[$i] != $_GET['page']);
            }
        }
        foreach ($chemin as $index_chemin => $page) {
        ?>
            <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a> /
    <?php
        }
    }

    $_SESSION['chemin'] = $chemin;

    ?>
    </span>
    <?php
    foreach ($Lien as $clé => $val) {
        if ($clé != 'super-categorie') {
    ?><h2><?= htmlentities($clé) ?></h2>
            <ul><?php
                foreach ($val as $clé2 => $val2) {
                ?> <li><a href="?page=<?php echo $Lien[$clé][$clé2]; ?>"><?php echo $Lien[$clé][$clé2]; ?></a></li>
                <?php
                }
                ?> </ul>
    <?php
        }
    }
    ?>
</article>