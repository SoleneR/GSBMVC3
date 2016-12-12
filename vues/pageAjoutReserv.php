<div data-role= "page" id="pageAjoutReserv" data-theme="b"> 
    <?php 
        include "vues/entetePage.html"; 
    ?> 
    <div data-role = "content"> 
        <label id="ltDescr">Brève description</label>
        <input type="text" name="ltDescr" id="ltDescr" value=""/>  
        
        <label id="descrComplete">Description complète</label>
        <textarea name="descrComplete" id="descrComplete" class="required"></textarea>
        
        <label id="debut">Début</label>
        <input type="date" name="jdebut" id="jdebut" value=""/>
        <form>
           <select name="hdebut" data-mini="true" id="hdebut" data-inline="true">
            <?php
            $step  = 30 * 60;   // 15 minutes
            $limit = 19 * 60 * 60;  // 24 heures
            for($heureDebut=6*60*60; $heureDebut<$limit; $heureDebut+=$step)
            {
                $heure=date('H:i:s', $heureDebut);
                echo'<option value="'.$heure.'">'.$heure.'</option>'; 
            }  
           ?> 
        </select>
        </form>
        
        <label id="fin">Fin</label>
        <input type="date" name="jfin" id="jfin" value=""/>
        <form>
           <select name="hfin" data-mini="true" id="hdebut" data-inline="true">
            <?php
            $step  = 30 * 60;   // 15 minutes
            $limit = 19 * 60 * 60;  // 24 heures
            for($heureDebut=6*60*60; $heureDebut<$limit; $heureDebut+=$step)
            {
                $heure=date('H:i:s', $heureDebut);
                echo'<option value="'.$heure.'">'.$heure.'</option>'; 
            }  
           ?> 
            </select>
        </form>
        <label id="domaine">Domaine</label>
        <form>
            <select id="domaine" name="domaine" data-mini="true" data-inline="true">
                <option value="">Informatique - multimédia</option>
                <option value="">Salle de réception</option>
                <option value="">Salle de réunion</option>
            </select>
        </form>
        
        <label id="salle">Salles</label>
        <form>
            <select id="salle" name="salle" data-mini="true" data-inline="true">
                <option value="">Multimédia</option>
                <option value="">Salle informatique</option>
            </select>
        </form>
        
        <label id="types">Types</label>
        <form>
            <select id="types" name="types" data-mini="true" data-inline="true">
                <option value="">Régulier</option>
                <option value="">Occasionnel/option>
            </select>
        </form>
        
        <label id="etat">Etat de la confirmation</label>
        <form>
            <fieldset data-role="controlgroup" data-type="horizontal">
                <input type="radio" name="radioChoix" id="radioChoixC" value="Confirmé"  checked="checked">
                <label for="radioChoixC">Confirmé</label>
                <input type="radio" name="radioChoix" id="radioChoixP" value="Provisoire">
        <label for="radioChoixP">Provisoire</label>
            </fieldset>
        </form>
        
        
        
        
        <a href ="#" data-role="button" id="btnEnregistrerAjout" data-inline="true">
                    Enregistrer
        </a>
   
    </div> <!-- /fin content --> 
        <?php 
            include "vues/piedsPage.html"; 
        ?> 
</div> <!-- /fin page -->
