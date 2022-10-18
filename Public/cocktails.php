<article>
    <?php
        //affichage synthétique (bon pas encore mis en forme mais voila comment récuperer les infos)
        echo $Recettes[0]["titre"];
        ?><button><img class="svg" src="..\svg\coeurvide.svg" alt=""></button>
        <img src="..\Photos\cocktail.png" alt=""><?php
        foreach ($Recettes[0]["index"] as $key) {
            echo "<br>",$key;
        }
    ?>
</article>