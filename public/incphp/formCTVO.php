
    <?php
include('client.class.php');
$client = new Client();
?>


<hr>

<div class="container">
<form method="POST" id="formctvo">   
    <input name="currentID" value="<?php echo $_POST['currentid'] ?>" type="hidden">
    <!--<fieldset>
        <legend class="control-label">Date Démarche</legend>
        <div class="form-group">
            <input class="form-control" name="DateDemarche" type="date">
            <input class="form-control" name="TimeDemarche" type="time">
        </div>
    </fieldset>-->
    <fieldset>
        <legend class="control-label">Ancien Titulaire</legend>
        <div class="form-group">
            <select id="personne" name="personne"  class="form-control" onchange="titulaire()">
                <option value="phy" >Personne Physique</option>
                <option value="mor">Personne Morale</option>
            </select><br>

            <div id="titulaire"><label for="NomPrenom">Nom Prénom</label>
                <input class="form-control" name="NomPrenom" id="NomPrenom" required><br>
            </div>

        </div>
    </fieldset>
    <fieldset>
        <legend class="control-label">Nouveau Titulaire</legend>
        <div class="form-group">
            <select id="personne2" name="personne2"  class="form-control" onchange="acquereur()">
                <option value="phy">Personne Physique</option>
                <option value="mor">Personne Morale</option>
            </select><br>

            <div id="acquereur">
                <label for="Nom">Nom</label>
                <input class="form-control" name="Nom" required><br>

                <label for="Prenom">Prenom</label>
                <input class="form-control" name="Prenom" required><br>

                <label for="sexe">Sexe</label>
                <select id="sexe" name="sexe"  class="form-control" onchange="genre()">
                    <option value="F">Feminin</option>
                    <option value="M">Masculin</option>
                </select>
                <div id="genre">
                    <label for="NomUsage">NOM Usage</label>
                    <input class="form-control" name="NomUsage" required>
                </div>
                
            </div>

            <div id="naissance">
                <label for="DateNaissance">Née le:</label>
                <input class="form-control" name="DateNaissance" id="DateNaissance" type="date" required>

                <label for="LieuNaissance">Ville</label>
                <input class="form-control" name="LieuNaissance" id="LieuNaissance" required>
            </div>

            

               
        </div>
    </fieldset>

    <fieldset>
        <label class="control-label">Opposé à la réutilisation des données à des fins d’enquête et de prospection commerciale</label>
        <select class="form-control" name="DroitOpposition">
            <option value=1>oui</option>
            <option value=0>non</option>
        </select>
    </fieldset>
    <fieldset>
        <legend class="control-label">Adresse</legend>
        <div class="form-group">
            <label for="Numero">Numero de Rue</label>
             <input class="form-control" name="Numero" id="Numero" type="number" required><br>

             <label for="ExtensionIndice">Extension au numéro de rue (B, T, …)</label>
             <input class="form-control" name="ExtensionIndice" id="ExtensionIndice" placeholder="B" ><br>

             <label for="EtageEscAppt">Précision sur l’étage, l’appartement, l’escalier, le bâtiment, …</label>
             <input class="form-control" name="EtageEscAppt" id="EtageEscAppt" placeholder="Apt"><br>

             <label for="TypeVoie">Type de la voie</label>
             <select id="TypeVoie" name="TypeVoie"  class="form-control">
                    <option value="SANS">- - - - -</option>
                    <option value="RUE">Rue</option>
                    <option value="BLVD">Boulevard</option>
                    <option value="AVN">Avenue</option>
                    <option value="ALL">Allée</option>
                    <option value="PLC">Place</option>
                    <option value="IMP" selected="selected">Impasse</option>
                    <option value="CHM">Chemin</option>
                    <option value="QUAI">Quai</option>
                    <option value="FORT">Fort</option>
                    <option value="RTE">Route</option>
                    <option value="PASS">Passage</option>
                    <option value="CHAU">Chaussée</option>
                    <option value="COUR">Cour</option>
                    <option value="PARC">Parc</option>
                    <option value="FBG">Faubourg</option>
                    <option value="LDIT">Lieu-Dit</option>
                    <option value="SQUA">Square</option>
                    <option value="SENT">Sente</option>
                    <option value="SANS">Inconnu</option>
                </select><br>

             <label for="NomVoie">Nom de la voie</label>
             <input class="form-control" name="NomVoie" id="NomVoie" required><br>

             <label for="Complement">Complement</label>
             <input class="form-control" name="Complement" id="Complement" placeholder="Immeuble, Bâtiment, Résidence"><br>

             <label for="LieuDit">LieuDit</label>
             <input class="form-control" name="LieuDit" id="LieuDit"><br>

             <label for="CodePostal">Code Postal</label>
             <input class="form-control" name="CodePostal" id="CodePostal" required><br>

             <label for="Ville">Ville</label>
             <input class="form-control" name="Ville" id="Ville" required><br>

             <label for="BoitePostale">Boite Postale</label>
             <input class="form-control" name="BoitePostale" id="BoitePostale"><br>

             <label for="Pays">Pays</label>
             <input class="form-control" name="Pays" id="Pays" required><br>
        </div>
    </fieldset>
    <fieldset>
        <legend name="InfoVehicule">Information Véhicule</legend>
        <div class="form-group">
            
            <!--<input type="checkbox" name="CIPresent" id="CIPresent">-->
            <label for="CIPresent" >Carte Grise Remise</label>
            <select id="cip" name="CIPresent" class="form-control" onchange="cipresent()">
                <option value=1>oui</option>
                <option value=0>non</option>
            </select>
            <br>
            <div id="immatinfo">
                <label for="Immatriculation">Numero d'Immatriculation</label>

                <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation" required><br>

                <label for="VIN">VIN</label>
                <input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="VIN" id="VIN"><br>

                <label for="NumFormule">Numero de Formule</label>
                <input class="form-control" name="NumFormule" id="NumFormule"><br>

                <label for="DateCI">Date CG</label>
                <input type="date" class="form-control" name="DateCI" id="DateCI"><br>
            </div>

        </div>
        
    </fieldset>
    
    <fieldset>
        <legend name="Co-titulaire">Co-Titulaire</legend>
        <div class="form-group">
            <label for="NbCotitulaires">Nombre de Cotitulaires</label>
            <input type="number" class="form-control" name="NbCotitulaires" id="NbCotitulaires"><br>
            <a class="btn btn-secondary" id="addcotitulaire" onclick="return addCotitulaire()">Add Cotitulaires</a>

            <div id="cotitulaireList"></div>

    
    </fieldset>

    <fieldset>
        <!--<input type="submit" class="btn btn-primary" name="envoyer" value="envoyer">-->  <input value="enregistrer" type="submit" name="sauver" id="enregistrer">
    </fieldset>
</form>



</div>

<div id="resultform"></div>

<script>

    $('#formctvo').on('submit',function(e) {

        e.preventDefault();
        dataseri = $(this).serialize();
        console.log(dataseri);
        $.ajax({
            url: 'incphp/submitCTVO.php',
            type: 'POST',
            data: dataseri,
            success: function(data) {
                console.log(data);
                console.log("test submit form");
                $('#resultform').html(data);
            }               
        });
    });



    function addCotitulaire(){
        //check number
        var number = document.getElementById("NbCotitulaires").value;

        var listcotitulaire = document.getElementById("cotitulaireList");

        while(listcotitulaire.hasChildNodes()){
            listcotitulaire.removeChild(listcotitulaire.lastChild);
        }

        for (i=0; i<number; i++){

            //TExt
            listcotitulaire.appendChild(document.createTextNode("Cotitulaires " + (i+1) + " "));

            //input
            var input = document.createElement("input");
            input.type = "text";
            input.name = "cotitulaire" + i;
            //listcotitulaire.appendChild(input);
            //listcotitulaire.appendChild(document.createElement("br"));



            //select personne physique or morale
            var select3 = document.createElement("SELECT");
            select3.setAttribute("id", "personne3["+i+"]");
            select3.setAttribute("name","personne3["+i+"]");
            select3.setAttribute("class","form-control");
            select3.setAttribute("onchange", "cotitulairetype(this)");
            select3.setAttribute("data-index", i);

            listcotitulaire.appendChild(select3);
            

            var phy = document.createElement("OPTION");
            phy.setAttribute("value", "PersonnePhysique");
            var t = document.createTextNode("physique");
            phy.appendChild(t);
            //console.log(phy);
            var y = document.createElement("OPTION");
            y.setAttribute("value", "PersonneMorale");
            var t2 = document.createTextNode("morale");
            y.appendChild(t2);
            document.getElementById("personne3["+i+"]").appendChild(phy);
            document.getElementById("personne3["+i+"]").appendChild(y);


            //div cotitulaire
            var divcotitl = document.createElement("div");
            divcotitl.setAttribute("name","cotitulaire" + i);
            divcotitl.setAttribute("id","cotitulaire" + i);



            //create nnom input
            var inputname = document.createElement("input");
            inputname.type = "text";
            inputname.name = "nomct[" + i+"]";
            inputname.className = "form-control col-3";
            inputname.required = true;


            //label creation nom
            var labeln = document.createElement("LABEL");
            var labeltextn = document.createTextNode("nom");
            labeln.setAttribute("for", "nomct[" + i +"]");
            labeln.appendChild(labeltextn);


            //create prenom input
            var inputprenom = document.createElement("input");
            inputprenom.type = "text";
            inputprenom.name = "prenomct[" + i+"]";
            inputprenom.className = "form-control col-3";
            inputprenom.required = true;


            //label creation prenom
            var labelp = document.createElement("LABEL");
            var labeltextp = document.createTextNode("prenom");
            labelp.setAttribute("for", "prenomct[" + i +"]");
            labelp.appendChild(labeltextp);


            //sexe/genre
            
            var select4 = document.createElement("SELECT");
            select4.setAttribute("id", "sexe3["+i+"]");
            select4.setAttribute("name","sexe3["+i+"]");
            select4.setAttribute("class","form-control col-3");
            //select4.setAttribute("onchange", "cotitulairesexe(this)");
            select4.setAttribute("data-index", i);

            listcotitulaire.appendChild(select4);
            

            var male = document.createElement("OPTION");
            male.setAttribute("value", "M");
            var textsexe = document.createTextNode("Homme");
            male.appendChild(textsexe);
            //console.log(phy);
            var female = document.createElement("OPTION");
            female.setAttribute("value", "F");
            var textsexe2 = document.createTextNode("Femme");
            female.appendChild(textsexe2);
            document.getElementById("sexe3["+i+"]").appendChild(male);
            document.getElementById("sexe3["+i+"]").appendChild(female);

            //label sexe/genre
            var labels = document.createElement("LABEL");
            var labeltexts = document.createTextNode("sexe");
            labels.setAttribute("for", "sexe3[" + i +"]");
            labels.appendChild(labeltexts);

            
            //listcotitulire appending
            listcotitulaire.appendChild(document.createElement("br"));
            listcotitulaire.appendChild(divcotitl);


            //div appending
            divcotitl.appendChild(labeln);
            divcotitl.appendChild(inputname);
            divcotitl.appendChild(labelp);
            divcotitl.appendChild(inputprenom);
            divcotitl.appendChild(labels);
            divcotitl.appendChild(document.getElementById("sexe3["+i+"]"));

            listcotitulaire.appendChild(document.createElement("br"));

        }
    }



    function cotitulairetype(option){
        var type6 = option.value;
        var indexcot = "cotitulaire"+option.dataset.index;
        var indexc = option.dataset.index;
        console.log(type6);
        console.log(indexcot);
       
        
        if(type6 == "PersonnePhysique"){
            document.getElementById(indexcot).innerHTML = '<label for="nomct['+indexc+']">nom</label><input type="text" name="nomct['+indexc+']" class="form-control col-3"><label for="prenomct['+indexc+']">prenom</label><input type="text" name="prenomct['+indexc+']" class="form-control col-3"><label for="sexe3['+indexc+']">sexe</label><select id="sexe3['+indexc+']" name="sexe3['+indexc+']" class="form-control col-3" data-index="'+indexc+'"><option value="M">Homme</option><option value="F">Femme</option></select>';
        }
        else{
            document.getElementById(indexcot).innerHTML = '<label for="raisonct['+indexc+']">Raison sociale</label><input type="text" name="raisonct['+indexc+']" class="form-control col-3">';
        }

    }


    function titulaire(){
        var type = document.getElementById("personne").value;
        if(type == "phy" ){
            document.getElementById("titulaire").innerHTML = '<label for="NomPrenom">Nom Prénom</label><input class="form-control" name="NomPrenom" id="NomPrenom" required>';
        }
        else{
             document.getElementById("titulaire").innerHTML = '<label for="RaisonSociale1">Raison Sociale</label><input class="form-control" name="RaisonSociale1" id="RaisonSociale" required>';
        }
        
    }

    function acquereur(){
        var type2 = document.getElementById("personne2").value;
        if(type2 == "phy"){
            document.getElementById("acquereur").innerHTML = '<label for="Nom">Nom</label><input class="form-control" name="Nom"><br><label for="Prenom">Prenom</label><input class="form-control" name="Prenom"><br><label for="sexem">Sexe</label><select name="sexe" class="form-control"><option value="F">Feminin</option><option value="M">Masculin</option></select><label for="NomUsage">NOM Usage</label><input class="form-control" name="NomUsage">';
        }
        else{
             document.getElementById("acquereur").innerHTML = '<label for="RaisonSociale2">Raison Sociale</label><input class="form-control" name="RaisonSociale2"><br><label for="SocieteCommerciale" >Societe Commerciale</label><select id="societe" name=SocieteCommerciale class="form-control" onchange="societec()"><option value=1>oui</option><option value=0>non</option></select><br><div id="sirendisplay"><label for="SIREN">SIREN</label><input class="form-control" name="SIREN"></div><hr>';
        }
    }

    function societec(){
        var type5 = document.getElementById("societe").value;
        if(type5 == 1){
            document.getElementById("sirendisplay").innerHTML = '<label for="SIREN">SIREN</label><input class="form-control" name="SIREN" required>';
        }
        else{
            document.getElementById("sirendisplay").innerHTML = "";
        }
    }

    function genre(){
        var type3 = document.getElementById("sexe").value;
        if(type3 == "F"){
            document.getElementById("genre").innerHTML = '<label for="NomUsage">NOM Usage</label><input class="form-control" name="NomUsage">';
        }
        else{
            document.getElementById("genre").innerHTML = "";
        }
    }

    function cipresent(){
        var type4 = document.getElementById("cip").value;
        if(type4 == 1 ){
            document.getElementById("immatinfo").innerHTML = '<label for="Immatriculation">Numero d\'Immatriculation</label><input class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation"><br><label for="VIN">VIN</label><input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="VIN" id="VIN"><br><label for="NumFormule">Numero de Formule</label><input class="form-control" name="NumFormule" id="NumFormule"><br><label for="DateCI">Date CG</label><input type="date" class="form-control" name="DateCI" id="DateCI"><br>';
        }
        else{
            document.getElementById("immatinfo").innerHTML = '<label for="Immatriculation">Numero d\'Immatriculation</label><input class="form-control" onkeyup="this.value = this.value.toUpperCase();" placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" name="Immatriculation" id="Immatriculation"><br><label for="VIN">VIN</label><input class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="VIN" id="VIN"><br>'
        }
    }


</script>
