<article>
    <?php
    $i = 0;
    if (!isset($_GET['page']) || $_GET['page'] == 'Aliment') {
        $Lien = $Hierarchie['Aliment'];
    } else {
        $Lien = $Hierarchie[$_GET['page']];
    }
    $i = -1;
    $sc = null;
    do {
        foreach ($Recettes as $index_c => $cocktails) {
            foreach ($cocktails[array_keys($cocktails)[3]] as $index_ing => $ingredients) { 
                if (isset($Lien["sous-categorie"])) {
                    foreach ($Lien["sous-categorie"] as $index_sc => $sous_categorie) {
                        if (!isset($sc)) {
                            $sc[] = $sous_categorie;
                        } elseif (!in_array($sous_categorie, $sc)) {
                            $sc[] = $sous_categorie;
                        }
                        if ($ingredients == $sous_categorie) {
                            if (!isset($afficher)) {
                                $afficher[] = $index_c;
                            } elseif (!in_array($index_c, $afficher)) {
                                $afficher[] = $index_c;
                            }
                        }
                    }
                }
                if (!isset($_GET['page']) || $ingredients == $_GET['page']) {
                    if (!isset($afficher)) {
                        $afficher[] = $index_c;
                    } elseif (!in_array($index_c, $afficher)) {
                        $afficher[] = $index_c;
                    }
                }
            }
        }
        $i++;
        if (isset($sc[$i])) {
            $Lien = $Hierarchie[$sc[$i]];
        }
    } while ($i < count($sc));
    sort($afficher);
    foreach ($afficher as $index_a => $cocktails) {
        $TabCo = null;
    ?>
        <div>
             <?php
            if (isset($_COOKIE['L'.$cocktails])) {
                if ($_COOKIE['L'.$cocktails] != "false") {
                    if (isset($_SESSION['like'])) {
                        $TL = $_SESSION['like'];
                     }
                     $TL[] = $_COOKIE['L'.$cocktails];
                     $_SESSION['like'] = $TL;
                     //var_dump($_SESSION['like']);
                }else
                {
                    if (isset($_SESSION['like'])) {
                        $TL = $_SESSION['like'];
                        $pos = array_search($cocktails, $TL);
                        array_splice($TL, $pos);
                        $_SESSION['like'] = $TL;
                    }
                }
                
            }
            //setcookie('L'.$cocktails, null, time() - 3600);
            ?>
                
            <button class="btn" onclick="Like(<?php echo $cocktails; ?>)">
            <?php 
            if(isset($_SESSION['like'])) {
                if (in_array($cocktails,$_SESSION['like'])) {
                    ?>
                    <img id="<?php echo $cocktails;?>" class="svg"  src="..\svg\coeurplein.svg" alt="">
                    <?php
                } else {
                    ?>
                    <img id="<?php echo $cocktails;?>" class="svg"  src="..\svg\coeurvide.svg" alt="">
                    <?php
                }
            } else {
                ?>
                    <img id="<?php echo $cocktails;?>" class="svg"  src="..\svg\coeurvide.svg" alt="">
                    <?php
            }

            ?>
            
            </button>
           
            <p>
                <?php
                Afficher_Image($Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]);
                ?>
                <br>

                <a href="?page=<?php echo $_GET['page']; ?>&Recettes=<?php echo $cocktails; ?>"><?php echo $Recettes[$cocktails][array_keys($Recettes[$cocktails])[0]]; ?></a>
            </p>
            <ul>
                <?php
                foreach ($Recettes[$cocktails][array_keys($Recettes[$cocktails])[3]] as $ing) {
                ?> <li><?= htmlentities($ing) ?></li>
                <?php
                }
                ?> </ul>
        </div>
    <?php
    }
    ?>

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
</article>
