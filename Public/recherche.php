<nav>

</nav>
<main>
<span>
<?php
    $x = $_POST['ingredient'];
    echo $x . "<br>";
    //match les s dans $x 
    $regex = '/s/';
    $matches = array();
    preg_match_all($regex, $x, $matches);
    var_dump($matches);
    echo "<br>";
    //affiche le nombre de s dans $x
    var_dump($_SESSION['like']);
?>
</span>
</main>
