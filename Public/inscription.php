<article>
    <?php
    if (isset($_GET['use']) && $_GET['use'] == 1) {
        ?>
        vous ne pouvez pas utiliser ce Login
        <?php
    }

    ?>
    <div id="inscription">
        <form method="post" action="./" >
            Login * :
            <input name="Login" type="text" required="required" /><br /> 
            Mot de passe * : 
            <input name="mdp" type="password" required="required" /><br />  
            Nom :    
            <input type="text" name="nom" /><br />   
            Prénom : 
            <input type="text" name="prenom" /><br /> 
            Vous êtes :  
            <input type="radio" name="sexe" value="h"/> un homme	
            <input type="radio" name="sexe" value="f"/> une femme
            <br />
                
            Date de naissance : 
            <input type="date" name="naissance" /><br /> 	
            <br />
            <input type="submit" value="Valider" />   
        </form>
    </div>
</article>
