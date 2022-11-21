
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
    <fieldset>
        <h2>Votre login :</h2>
        <input type="text" name="login"
               value="<?php if(isset($_POST['login'])) echo $_POST['login'];?>"/> <br />

        <h2>Votre Mot de Passe :</h2>
        <input type="text" name="mdp"
               value="<?php if(isset($_POST['mdp'])) echo $_POST['mdp'];?>"/> <br />

        Votre Nom :
        <input type="text" name="nom"
               value="<?php if(isset($_POST['nom'])) echo $_POST['nom'];?>"/> <br />

        Votre Prenom :
        <input type="text" name="prenom"
               value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom'];?>"/> <br />

        Votre Date de Naissance :
        <input type="date" name="dateN"
               value="<?php if(isset($_POST['dateN'])) echo$_POST['dateN'];?>"/> <br />
    </fieldset>
<br/>
<input type="submit" name="inscrire" value="inscrit"/>
</form>

<?php
if (isset($_POST["login"]) && isset($_POST["mdp"])){
    foreach ($users as $user){
        if ( $user["login"] === $_POST["login"] && $user["mdp"] === $_POST["mdp"]){
            $loggedUser = ['email' => $user['login'],];
        }
        else{
            $php_errormsg = sprintf('Erreur: Login et/ou mot de passe incorrecte : (%s/%s)',$_POST['login'],$_POST['mdp']);
        }
    }
}
?>