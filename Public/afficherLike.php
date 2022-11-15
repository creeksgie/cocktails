<article>
    <?php
    if (isset($_SESSION['like'])) {
        $indice = $_SESSION['like'];
        sort($indice);
        foreach ($indice as $index_a => $cocktails) {
    ?>
            <div>

                <button class="btn" id="<?php echo $cocktails; ?>">
                    <?php
                    if (isset($_SESSION['like'])) {
                        if (in_array($cocktails, $_SESSION['like'])) {
                    ?>
                            <img class="svg" src="..\svg\coeurplein.svg" alt="">
                        <?php
                        } else {
                        ?>
                            <img class="svg" src="..\svg\coeurvide.svg" alt="">
                        <?php
                        }
                    } else {
                        ?>
                        <img class="svg" src="..\svg\coeurvide.svg" alt="">
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
    }
    ?>
    <script>
        $('.btn').on('click', function() {
            var btn = $(this);
            var svg = btn.find("img");
            var indice = (this.id);
            if (svg.attr("src").match("coeurvide.svg")) {
                svg.attr("src", "../svg/coeurplein.svg");
            } else {
                svg.attr("src", "../svg/coeurvide.svg");
            }
            $.ajax({
                url: 'like.php',
                data: {
                    indice: indice
                }
            });
            location.reload();
        });
    </script>
</article>