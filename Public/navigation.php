<article>
    <p>Aliment Courant</p>
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
    foreach ($Lien as $index_nav => $nav) {
        if ($index_nav != 'super-categorie') {
    ?>
            <p><?= htmlentities($index_nav) ?></p>
            <ul><?php
                foreach ($nav as $index_ing => $ingredient) {
                ?> <li><a href="?page=<?php echo $Lien[$index_nav][$index_ing]; ?>"><?php echo $Lien[$index_nav][$index_ing]; ?></a></li>
                <?php
                }
                ?> </ul>
    <?php
        }
    }
    ?>
</article>