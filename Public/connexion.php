<span id="login">
<?php
    function est_vide($chaine)
    {
        return(trim($chaine)=='');
    }

    $complet=true;
    if(isset($_GET["submit"]))
    {
        if(   !est_vide($_GET["login"])
           && !est_vide($_GET["mdp"])
           && !est_vide($_GET["nom"])
            && !est_vide($_GET["prenom"])
            && !est_vide($_GET["dateN"])
           )
        {
            $_SESSION['user']['nom'] =$_GET["nom"];
            $_SESSION['user']['prenom'] = $_GET["prenom"];
            $_SESSION['user']['dateN'] = $_GET["dateN"];
            $complet = true;
        }
    }

    if($complet)
    {
        //include('index.php');
    }
    else{
        if(isset($_GET['submit']))
        {
            echo 'Veuillez compléter tous les champs si vous plait';
        }
        else{
            echo 'Veuillez remplir le formulaire';
        }
    }
?>
</span>

    <form method="get" action="?page=connexion">
        Votre login :
        <input type="text" name="login"
               value="<?php echo (isset($_GET['login'])?$_GET['login']:'');?>"> <br />

        Votre Mot de Passe :
        <input type="text" name="mdp"
               value="<?php echo (isset($_GET['mdp'])?$_GET['mdp']:'');?>"> <br />

        Votre Nom :
        <input type="text" name="nom"
               value="<?php echo (isset($_GET['nom'])?$_GET['nom']:'');?>"> <br />

        Votre Prenom :
        <input type="text" name="prenom"
               value="<?php echo (isset($_GET['prenom'])?$_GET['prenom']:'');?>"> <br />

        Votre Date de Naissance :
        <input type="date" name="dateN"
               value="<?php echo (isset($_GET['dateN'])?$_GET['dateN']:'');?>"> <br />
    </form>
