
  var numeInitial    = document.getElementById("numeClient").value;
  var prenumeInitial = document.getElementById("prenumeClient").value;
  var telefonInitial = document.getElementById("telefonClient").value;
  var emailInitial   = document.getElementById("emailClient").value;

  function schimbareDetaliiClient() {
    if((document.getElementById("numeClient").value != numeInitial) || (document.getElementById("prenumeClient").value != prenumeInitial) || (document.getElementById("telefonClient").value != telefonInitial) || (document.getElementById("emailClient").value != emailInitial))
    {
      document.getElementById("modificariClient").style.visibility="visible";

      document.getElementById("hiddenFormNumeClient").value    = document.getElementById("numeClient").value;
      document.getElementById("hiddenFormPrenumeClient").value = document.getElementById("prenumeClient").value;
      document.getElementById("hiddenFormTelefonClient").value = document.getElementById("telefonClient").value;
      document.getElementById("hiddenFormEmailClient").value   = document.getElementById("emailClient").value;

      document.getElementById("butonPas2").style.visibility = "hidden";
    }
    else
    {
      document.getElementById("modificariClient").style.visibility="hidden";
      document.getElementById("butonPas2").style.visibility = "visible";
    }
  }

  function anuleazaModificariClient() {

      document.getElementById("numeClient").value    = numeInitial;
      document.getElementById("prenumeClient").value = prenumeInitial;
      document.getElementById("telefonClient").value = telefonInitial;
      document.getElementById("emailClient").value   = emailInitial;

      document.getElementById("modificariClient").style.visibility= "hidden";
      document.getElementById("butonPas2").style.visibility = "visible";
  }


/*  var localitate = document.getElementById("localitate").value;
  var strada     = document.getElementById("strada").value;
  var numar      = document.getElementById("numar").value;
  var bloc       = document.getElementById("bloc").value;
  var scara      = document.getElementById("scara").value;
  var etaj       = document.getElementById("etaj").value;
  var apartament = document.getElementById("apartament").value;
  var interfon   = document.getElementById("interfon").value;*/

  function schimbareDetaliiAdresa() {
   /*if((document.getElementById("localitate").value != localitate) || (document.getElementById("strada").value != strada) ||
       (document.getElementById("numar").value !=numar) || (document.getElementById("bloc").value != bloc) ||
       (document.getElementById("scara").value != scara) || (document.getElementById("etaj").value != etaj) ||
       (document.getElementById("apartament").value !=apartament) || (document.getElementById("interfon").value != interfon))
    {*/
      document.getElementById("modificariAdresa").style.visibility="visible";

      document.getElementById("hiddenFormLocalitate").value = document.getElementById("localitate").value;
      document.getElementById("hiddenFormStrada").value     = document.getElementById("strada").value;
      document.getElementById("hiddenFormNumar").value      = document.getElementById("numar").value;
      document.getElementById("hiddenFormBloc").value       = document.getElementById("bloc").value;
      document.getElementById("hiddenFormScara").value      = document.getElementById("scara").value;
      document.getElementById("hiddenFormEtaj").value       = document.getElementById("etaj").value;
      document.getElementById("hiddenFormApartament").value = document.getElementById("apartament").value;
      document.getElementById("hiddenFormInterfon").value   = document.getElementById("interfon").value;
    /*}
    else
    {
      document.getElementById("modificariAdresa").style.visibility="hidden";
    }*/
  }

  function afisareAdresa() {
    var adresa = document.getElementById("alegereAdresaDropdown").value;
    var splitAdresa = adresa.split(", ");
    splitAdresa[7] = splitAdresa[7].replace(";", "");

    document.getElementById("localitate").value    = splitAdresa[0];
    document.getElementById("localitate").readOnly = true;
    document.getElementById("strada").value        = splitAdresa[1];
    document.getElementById("strada").readOnly     = true;
    document.getElementById("numar").value         = splitAdresa[2];
    document.getElementById("numar").readOnly      = true;
    document.getElementById("bloc").value          = splitAdresa[3];
    document.getElementById("bloc").readOnly       = true;
    document.getElementById("scara").value         = splitAdresa[4];
    document.getElementById("scara").readOnly      = true;
    document.getElementById("etaj").value          = splitAdresa[5];
    document.getElementById("etaj").readOnly       = true;
    document.getElementById("apartament").value    = splitAdresa[6];
    document.getElementById("apartament").readOnly = true;
    document.getElementById("interfon").value      = splitAdresa[7];
    document.getElementById("interfon").readOnly   = true;

    document.getElementById("informatii-adresa").style.visibility = "visible";
    document.getElementById("modificariAdresa").style.visibility="hidden";
    document.getElementById("adresaComanda").style.height="400px";
    document.getElementById("buton-trimite-comanda").style.visibility = "visible";
  }

  function adresaNoua() {
    if(document.getElementById("informatii-adresa").style.visibility != "visible")
    {
      document.getElementById("informatii-adresa").style.visibility = "visible";
      document.getElementById("adresaComanda").style.height="400px";
      document.getElementById("buton-trimite-comanda").style.visibility = "hidden";
    }
    else
    {
      document.getElementById("localitate").value    = "";
      document.getElementById("localitate").readOnly = false;
      document.getElementById("strada").value        = "";
      document.getElementById("strada").readOnly     = false;
      document.getElementById("numar").value         = "";
      document.getElementById("numar").readOnly      = false;
      document.getElementById("bloc").value          = "";
      document.getElementById("bloc").readOnly       = false;
      document.getElementById("scara").value         = "";
      document.getElementById("scara").readOnly      = false;
      document.getElementById("etaj").value          = "";
      document.getElementById("etaj").readOnly       = false;
      document.getElementById("apartament").value    = "";
      document.getElementById("apartament").readOnly = false;
      document.getElementById("interfon").value      = "";
      document.getElementById("interfon").readOnly   = false;

      document.getElementById("buton-trimite-comanda").style.visibility = "hidden";

      document.getElementById("adresaComanda").style.height="400px";
    }
  }

 function anuleazaModificariAdresa() {
    document.getElementById("informatii-adresa").style.visibility ="hidden";
    document.getElementById("modificariAdresa").style.visibility="hidden";
  }
/*  function verificareTotalDePlata() {
    alert("s-a schimbat");
    if(document.getElementById("totalDePlata") == "0 lei")
    {
      document.getElementById("continua1").style.visibility = "hidden";
    }
  }*/

  function afiseazaModal() {
    $("#myModal").modal('show');
  }
