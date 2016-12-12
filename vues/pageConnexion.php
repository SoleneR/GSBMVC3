<div data-role="page" data-theme="b" id="pageConnexion">
    <?php
        include "vues/entetehtml.html";
    ?>
        <div data-role="content" id="divconnexion">
            <div id="entetePageConnexion">
                <h1 id="titrePageConnexion">Connexion</h1>
            </div>
            
            <div class="ui-field-contain">
                <p style="text-align:center;">Connectez-vous pour accéder au système de réservations de salles de la Maison des Ligues</p>
                <label for="login" style="text-align:left;">Nom :</label>
                <input type="text" name="login" id="login" value=""/>
                <label for="mdp" style="text-align:left;">Mot de passe :</label>
                <input type="password" name="mdp" id="mdp" value=""/>
            </div>
                                   
            <div id="message">  </div>
                <p>
                    <a href="#" data-role="button" id="btnconnexion" data-line="true">
                        S'identifier
                    </a>
                </p>
          <?php   include "vues/logo.html";   ?>
        </div><!-- /content -->
        <?php
            //include "vues/piedpage.html";
        ?>
</div><!-- /page 1 -->
