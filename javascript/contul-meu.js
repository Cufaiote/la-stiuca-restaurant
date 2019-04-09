var nume           = document.getElementById("numeClient").value;
var prenume        = document.getElementById("prenumeClient").value;
var telefon        = document.getElementById("telefonClient").value;
var email          = document.getElementById("emailClient").value;
var parola         = document.getElementById("parolaClient").value;
var repetareParola = document.getElementById("repetareParolaClient").value;
var localitate     = document.getElementById("localitate").value;
var strada         = document.getElementById("strada").value;
var numar          = document.getElementById("numar").value;
var bloc           = document.getElementById("bloc").value;
var scara          = document.getElementById("scara").value;
var etaj           = document.getElementById("etaj").value;
var apartament     = document.getElementById("apartament").value;
var interfon       = document.getElementById("interfon").value;

function afisareOptiuni()
{
  document.getElementById("modifica").style.visibility = "hidden";
  document.getElementById("modifica").style.height     = "0";

  document.getElementById("form-modificariDetalii").style.visibility  = "visible";
  document.getElementById("form-modificariDetalii").style.height      = "32px";
  document.getElementById("trimite").disabled = true;
  document.getElementById("anuleaza").style.visibility = "visible";
  document.getElementById("anuleaza").style.height     = "32px";

  document.getElementById("numeClient").readOnly           = false;
  document.getElementById("prenumeClient").readOnly        = false;
  document.getElementById("telefonClient").readOnly        = false;
  document.getElementById("emailClient").readOnly          = false;
  document.getElementById("parolaClient").readOnly         = false;
  document.getElementById("repetareParolaClient").readOnly = false;
}

function anuleazaModificari() {
  document.getElementById("modifica").style.visibility = "visible";
  document.getElementById("modifica").style.height     = "32px";

  document.getElementById("form-modificariDetalii").style.visibility  = "hidden";
  document.getElementById("form-modificariDetalii").style.height      = "0";
  document.getElementById("anuleaza").style.visibility = "hidden";
  document.getElementById("anuleaza").style.height     = "0";

  document.getElementById("numeClient").readOnly           = true;
  document.getElementById("prenumeClient").readOnly        = true;
  document.getElementById("telefonClient").readOnly        = true;
  document.getElementById("emailClient").readOnly          = true;
  document.getElementById("parolaClient").readOnly         = true;
  document.getElementById("repetareParolaClient").readOnly = true;

  document.getElementById("numeClient").value           = nume;
  document.getElementById("prenumeClient").value        = prenume;
  document.getElementById("telefonClient").value        = telefon;
  document.getElementById("emailClient").value          = email;
  document.getElementById("parolaClient").value         = parola;
  document.getElementById("repetareParolaClient").value = repetareParola;

}

function schimbareDetaliiClient() {
  if((document.getElementById("numeClient").value != nume) ||
  (document.getElementById("prenumeClient").value != prenume) ||
  (document.getElementById("telefonClient").value != telefon) ||
  (document.getElementById("emailClient").value != email) ||
  (document.getElementById("parolaClient").value != parola) ||
  (document.getElementById("repetareParolaClient").value != repetareParola))
  {
    document.getElementById("hiddenFormNume").value           = document.getElementById("numeClient").value;
    document.getElementById("hiddenFormPrenume").value        = document.getElementById("prenumeClient").value;
    document.getElementById("hiddenFormTelefon").value        = document.getElementById("telefonClient").value;
    document.getElementById("hiddenFormEmail").value          = document.getElementById("emailClient").value;
    document.getElementById("hiddenFormParola").value         = document.getElementById("parolaClient").value;
    document.getElementById("hiddenFormRepetareParola").value = document.getElementById("repetareParolaClient").value;

    document.getElementById("trimite").disabled = false;
  }
  else
  {
    document.getElementById("trimite").disabled = true;
  }
}

function afisareFormularModificare(id) {
  document.getElementById("formularAdrese").style.height = "300px";
  document.getElementById("formularModificare").style.visibility = "visible";
  document.getElementById("formularModificare").style.height = "auto";
  document.getElementById("hiddenForm-modificari").style.visibility = "visible";
  document.getElementById("hiddenForm-modificari").style.height = "auto";
  document.getElementById("hiddenForm-adaugareAdresa").style.visibility = "hidden";
  document.getElementById("hiddenForm-adaugareAdresa").style.height = "0px";
  document.getElementById("trimiteModificari").disabled = true;

  var index     = id.split("-");

  var domiciliu = document.getElementById(index[2] + "domiciliu").innerText;

  domiciliu = domiciliu.split(", ");
  domiciliu[7] = domiciliu[7].replace(";", "");

  document.getElementById("modificareIdAdresa").value = index[0];

  document.getElementById("localitate").value = domiciliu[0];
  document.getElementById("strada").value     = domiciliu[1];
  document.getElementById("numar").value      = domiciliu[2];
  document.getElementById("bloc").value       = domiciliu[3];
  document.getElementById("scara").value      = domiciliu[4];
  document.getElementById("etaj").value       = domiciliu[5];
  document.getElementById("apartament").value = domiciliu[6];
  document.getElementById("interfon").value   = domiciliu[7];
}

function anuleazaModificariAdresa() {
  document.getElementById("formularAdrese").style.height = "10px";
  document.getElementById("formularModificare").style.visibility = "hidden";
  document.getElementById("formularModificare").style.height = "0px";
  document.getElementById("hiddenForm-modificari").style.visibility = "hidden";
  document.getElementById("hiddenForm-modificari").style.height = "0px";
  document.getElementById("hiddenForm-adaugareAdresa").style.visibility = "hidden";
  document.getElementById("hiddenForm-adaugareAdresa").style.height = "0px";

  document.getElementById("localitate").value = localitate;
  document.getElementById("strada").value     = strada;
  document.getElementById("numar").value      = numar;
  document.getElementById("bloc").value       = bloc;
  document.getElementById("scara").value      = scara;
  document.getElementById("etaj").value       = etaj;
  document.getElementById("apartament").value = apartament;
  document.getElementById("interfon").value   = interfon;
}

function modificareDetaliiAdresa() {
  if((document.getElementById("localitate").value != localitate) || (document.getElementById("strada").value != strada) ||
     (document.getElementById("numar").value !=numar) || (document.getElementById("bloc").value != bloc) ||
     (document.getElementById("scara").value != scara) || (document.getElementById("etaj").value != etaj) ||
     (document.getElementById("apartament").value !=apartament) || (document.getElementById("interfon").value != interfon))
  {
    document.getElementById("trimiteModificari").disabled = false;

    document.getElementById("modificareLocalitate").value     = document.getElementById("localitate").value;
    document.getElementById("modificareStrada").value         = document.getElementById("strada").value;
    document.getElementById("modificareNumar").value          = document.getElementById("numar").value;
    document.getElementById("modificareBloc").value           = document.getElementById("bloc").value;
    document.getElementById("modificareScara").value          = document.getElementById("scara").value;
    document.getElementById("modificareEtaj").value           = document.getElementById("etaj").value;
    document.getElementById("modificareApartament").value     = document.getElementById("apartament").value;
    document.getElementById("modificareInterfon").value       = document.getElementById("interfon").value;

  }
  else
  {
    document.getElementById("trimiteModificari").disabled = true;
  }
}

function afisareAdresa() {
  document.getElementById("formularAdrese").style.height = "300px";
  document.getElementById("formularModificare").style.visibility = "visible";
  document.getElementById("formularModificare").style.height = "auto";
  document.getElementById("hiddenForm-adaugareAdresa").style.visibility = "visible";
  document.getElementById("hiddenForm-adaugareAdresa").style.height = "auto";
  document.getElementById("hiddenForm-modificari").style.visibility = "hidden";
  document.getElementById("hiddenForm-modificari").style.height = "0px";

  document.getElementById("localitate").value = "";
  document.getElementById("strada").value     = "";
  document.getElementById("numar").value      = "";
  document.getElementById("bloc").value       = "";
  document.getElementById("scara").value      = "";
  document.getElementById("etaj").value       = "";
  document.getElementById("apartament").value = "";
  document.getElementById("interfon").value   = "";
}

function afisareModal(id) {
  var idPrep = id.split("-");

  var modalId = "#myModal-" + idPrep[1];

  $(modalId).modal("show");

  $(modalId).on('hidden.bs.modal', function () {
            $(".modal-body1").html("");
    });
}
