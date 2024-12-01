var $consultaCadena = null;
$(document).ready(function() {
    $("#nombreCadena").on("keyup paste", function(){
        $this = $(this);
        if($this.val().length >= 3) {
            $("#nombreCadena").addClass("loading-input");
            if ($consultaCadena != null){
                $consultaCadena.abort();
                $consultaCadena = null;
            }
            $consultaCadena = $.ajax({
                method: "POST",
                url: BASE_PATH + "/_Cadenas/afiliacion/ajax/consultaCadena.php",
                data: {'nombre': $this.val()},
                beforeSend: function () {
                },
            })
                .done(function (response) {
                    let resp = JSON.parse(response);
                    if(!resp.error){
                        if(resp.data.length > 0) {
                            jAlert("Ya existe la cadena, verifique el nombre o busquela en el area de consulta");
                        } else {
                            $("#selectGiro").attr("disabled",false);
                            $("#email").attr("disabled",false);
                            $("#numeroTelefono").attr("disabled",false);
                            $("#saveCadena").attr("disabled",false);
                            //$("#selectGiro option[value='0']").attr("disabled",true);
                        }
                        $("#nombreCadena").removeClass("loading-input");
                    }else{
                        jAlert("Problema al consultar si exite la cadena");
                        $("#nombreCadena").removeClass("loading-input");
                    }
                })
                .fail(function (error) {
                    if(error.statusText !== "abort") {
                        jAlert("Problema al consultar si exite la cadena");
                        $("#nombreCadena").removeClass("loading-input");
                    }
                });
        }
    })
});
$("#formInsertCadena").submit(function (e) {
    e.preventDefault();
    let error = false;
    if($("#nombreCadena").val() == "") error = true;
    if($("#selectGiro").val() == "" || $("#selectGiro").val() == null) error = true;
    if(error) {
        jAlert("Complete los campos requeridos [*]")
        return true;
    }
    $.ajax({
        method: "POST",
        url: BASE_PATH + "/inc/Ajax/insertCadena.php",
        data: $("#formInsertCadena").serialize(),
        beforeSend: function () {
            //document.querySelector("#main-content").classList.add("hidden");
            //document.querySelector("#carga").classList.remove("hidden");
            $("#loaderEmisor").removeClass("hidden");
        },
    })
        .done(function (response) {
            let resp = JSON.parse(response);
            if(!resp.error){
                //document.querySelector("#main-content").classList.remove("hidden");
                //document.querySelector("#carga").classList.add("hidden");
                $("#loaderEmisor").addClass("hidden");
                document.querySelector(".alert-success").classList.remove("hidden");
                setTimeout(function () {
                    document.querySelector(".alert-success").classList.add("hidden");
                }, 5000);
                $("#saveCadena").attr("disabled",true);
                $("#selectGiro").attr("disabled",true);
                $("#email").attr("disabled",true);
                $("#numeroTelefono").attr("disabled",true);
                $("#formInsertCadena")[0].reset();
            }else{
                //document.querySelector("#main-content").classList.remove("hidden");
                //document.querySelector("#carga").classList.add("hidden");
                $("#loaderEmisor").addClass("hidden");
                document.querySelector(".alert-error").classList.remove("hidden");
                setTimeout(function () {
                    document.querySelector(".alert-error").classList.add("hidden");
                }, 5000);
            }
        })
        .fail(function (error) {
            console.log(error);
            document.querySelector("#main-content").classList.remove("hidden");
            document.querySelector("#carga").classList.add("hidden");
            document.querySelector(".alert-error").classList.remove("hidden");
            setTimeout(function () {
                document.querySelector(".alert-error").classList.add("hidden");
            }, 5000);
        });
});
