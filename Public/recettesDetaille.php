<span>
    <?php
    Afficher_Bouton_like($_GET['Recettes']);

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
    });
</script>