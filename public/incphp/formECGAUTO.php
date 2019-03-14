<form method="POST" id="formecgauto">
    <div class="col-11 col-md-6 mx-auto search-box">
        <div class="row col-12 mx-auto input-group ">
            <label for="Immatriculation" class="col-12 search-box--titre">Numero d'Immatriculation</label>
            <input class="mx-auto search-form" onkeyup="this.value = this.value.toUpperCase();" 
            placeholder="AB-123-CD ou 1234 AB 56 " pattern="[0-9]{1,4} [A-Z]{1,4} [0-9]{1,2}|[A-Z]{1,2}-[0-9]{1,3}-[A-Z]{1,2}" 
            name="Immatriculation" id="Immatriculation" required><br>
        </div>
    </div>
    <div class="col-11 col-md-6 mx-auto search-box">
        <div class="row col-12 mx-auto input-group ">
            <label for="Departement" class="col-12 search-box--titre">Departement d'immatriculation</label>
            <input type="text" class="mx-auto search-form" name="Departement" id="Departement" 
            pattern="[0-9,A-B]{2,3}" maxlength="3" minlength="2" required><br>
        </div>
    </div>
    <div class="col-12 col-md-6 mx-auto text-center search-box">
        <input value="COMMANDER" type="submit" name="sauver" id="enregistrer" class="btn btn-primary btn-sm mx-auto">
        <div id="loader" style="display:none;"><img src="http://dev2.cgofficiel.fr/img/ajax-loader.gif" alt="loader"></div>
    </div>

</form>
    <div id="resultecg"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
    $('#formecgauto').submit(function( event ) {

            event.preventDefault();
            $('#loader').show();
            dataseri = $(this).serialize();
            $.ajax({
                url: "incphp/submitECGAUTO.php",
                type: "POST",
                async: false,
                timeout: 3000,
                cache: false,
                data: dataseri,
                success: function (data) {
                    $('#loader').hide();
                    $("#resultecg").html(data);
                }
            });
        });
    </script>



