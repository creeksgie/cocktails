<article>
    <?php
    if (isset($_SESSION['like'])) {
        $indice = $_SESSION['like'];
        sort($indice);
        foreach ($indice as $index_a => $cocktails) {
            Afficher_Recette_synt($cocktails,$Recettes[$cocktails]);
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