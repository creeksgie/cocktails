
<?php

if(isset($_POST['submit']))
{
    $ClassLogin='ok';
    $ClassMdp='ok';
    $ClassNom='ok';
    $ClassPrenom='ok';
    $ClassSexe='ok';
    $ClassDN='ok';
    $ChampsIncorrects='';

    if((!isset($_POST['login']))){
        $ChampsIncorrects=$ChampsIncorrects.'<li>login</li>';
        $ClassLogin='error';
    }

    if((!isset($_POST['mdp']))){
        $ChampsIncorrects=$ChampsIncorrects.'<li>mdp</li>';
        $ClassLogin='error';
    }

    if((!isset($_POST['nom']))){
        $ChampsIncorrects=$ChampsIncorrects.'<li>nom</li>';
        $ClassLogin='error';
    }

    if((!isset($_POST['prenom']))){
        $ChampsIncorrects=$ChampsIncorrects.'<li>prenom</li>';
        $ClassLogin='error';
    }

    if((!isset($_POST['sexe'])) ||(  (trim($_POST['sexe'])!='f') &&(trim($_POST['sexe'])!='h'))) {
        $ChampsIncorrects=$ChampsIncorrects.'<li>sexe</li>';
        $ClassSexe='error';
    }

    if((!isset($_POST['dateN'])) || (trim($_POST['dateN'])=='')){
        $ChampsIncorrects=$ChampsIncorrects.'<li>dateN</li>';
        $ClassLogin='error';
    }
    else{
        $Naissance=trim($_POST['naissance']);
        list($Annee,$Mois, $Jour)=explode('-',$Naissance);
        if(!checkdate($Mois,$Jour,$Annee))
        { $ChampsIncorrects=$ChampsIncorrects.'<li>date de naissance</li>';
            $ClassNaissance='error';
        }
    }
}
?>
<form method="post" action="?page=index">
    <fieldset>
        <legend><h1>Inscriptions :</h1></legend>
        <h2>Votre login :</h2>
        <input type="text" class="<?php echo $ClassLogin; ?>" name="login" required="required"
               value="<?php if(isset($_POST['login'])) echo $_POST['login'];?>"/> <br />

        <h2>Votre Mot de Passe :</h2>
        <input type="password" class="<?php echo $ClassMdp; ?>" name="mdp" required="required"
               value="<?php if(isset($_POST['mdp'])) echo $_POST['mdp'];?>"/> <br />

        <h3>Votre Nom :</h3>
        <input type="text" class="<?php echo $ClassNom; ?>" name="nom"
               value="<?php if(isset($_POST['nom'])) echo $_POST['nom'];?>"/> <br />

        <h3>Votre Prenom :</h3>
        <input type="text" class="<?php echo $ClassPrenom; ?>" name="prenom"
               value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom'];?>"/> <br />

        <h3>Votre Sexe :</h3>
        <span class="<?php echo $ClassSexe; ?>">
	    <input type="radio" name="sexe" value="f"
	    <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='f') echo 'checked="checked"'; ?>
	    /> une femme
	    <input type="radio" class="<?php echo $ClassSexe; ?>" name="sexe" value="h"
	    <?php if((isset($_POST['sexe']))&&($_POST['sexe'])=='h') echo 'checked="checked"'; ?>
	    /> un homme
        </span>

        <h3>Votre Date de Naissance :</h3>
        <input type="date" class="<?php echo $ClassDN; ?>" name="dateN"

        <span>Votre Nom :</span>
        <input type="text" name="nom"
               value="<?php if(isset($_POST['nom'])) echo $_POST['nom'];?>"/> <br />

        <span>Votre Prenom :</span>
        <input type="text" name="prenom"
               value="<?php if(isset($_POST['prenom'])) echo $_POST['prenom'];?>"/> <br />

        <span>Votre Date de Naissance :</span>
        <input type="date" name="dateN"

               value="<?php if(isset($_POST['dateN'])) echo$_POST['dateN'];?>"/> <br />
    </fieldset>
<br/>
<input type="submit" name="submit" value="s'inscrire"/>
</form>

<?php
if(isset($_POST['submit'])){
    echo "<br/>Merci de remplir correctement le formulaire ci-dessous :<ul>".$ChampsIncorrects."</ul>";
}
?>