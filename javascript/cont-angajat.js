var nume       = document.getElementById("numeAngajat").value;
var prenume    = document.getElementById("prenumeAngajat").value;
var telefon    = document.getElementById("telefonAngajat").value;
var email      = document.getElementById("emailAngajat").value;

function afiseazaOptiuni() {
    document.getElementById("modifica").style.visibility = "hidden";
    document.getElementById("modifica").style.width     = "0";

    document.getElementById("trimite").style.visibility  = "visible";
    document.getElementById("trimite").style.width      = "80px";
    document.getElementById("trimite").disabled = true;
    document.getElementById("anuleaza").style.visibility = "visible";
    document.getElementById("anuleaza").style.width    = "80px";

    document.getElementById("numeAngajat").readOnly           = false;
    document.getElementById("prenumeAngajat").readOnly        = false;
    document.getElementById("telefonAngajat").readOnly        = false;
    document.getElementById("emailAngajat").readOnly          = false;
    document.getElementById("parolaAngajat").readOnly         = false;
    document.getElementById("repetareParolaAngajat").readOnly = false;
  }

  function anuleazaModificari() {
    document.getElementById("modifica").style.visibility = "visible";
    document.getElementById("modifica").style.width     = "80px";

    document.getElementById("trimite").style.visibility  = "hidden";
    document.getElementById("trimite").style.width      = "0";
    document.getElementById("anuleaza").style.visibility = "hidden";
    document.getElementById("anuleaza").style.width     = "0";

    document.getElementById("numeAngajat").readOnly            = true;
    document.getElementById("prenumeAngajat").readOnly         = true;
    document.getElementById("telefonAngajat").readOnly         = true;
    document.getElementById("emailAngajat").readOnly           = true;
    document.getElementById("parolaAngajat").readOnly         = true;
    document.getElementById("repetareParolaAngajat").readOnly = true;

    document.getElementById("numeAngajat").value            = nume;
    document.getElementById("prenumeAngajat").value         = prenume;
    document.getElementById("telefonAngajat").value         = telefon;
    document.getElementById("emailAngajat").value           = email;
    document.getElementById("parolaAngajat").value         = "";
    document.getElementById("repetareParolaAngajat").value = "";
  }

  function schimbareInformatiiAngajat() {
    if((document.getElementById("numeAngajat").value != nume) ||
    (document.getElementById("prenumeAngajat").value != prenume) ||
    (document.getElementById("telefonAngajat").value != telefon) ||
    (document.getElementById("emailAngajat").value != email) ||
    (document.getElementById("parolaAngajat").value != "") ||
    (document.getElementById("repetareParolaAngajat").value != ""))
    {
      document.getElementById("trimite").disabled = false;
    }
    else
    {
      document.getElementById("trimite").disabled = true;
    }
  }
