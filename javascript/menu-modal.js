

function deschideModal(id) {
  var phpClient = $("#phpClient").val();

  if(phpClient != '')
  {
    var modalId = "#myModal-" + id;

    $(modalId).modal("show");

    $(modalId).on('hidden.bs.modal', function () {
              $(".modal-body1").html("");
      });
  }
  else
  {
    $("#modalClientNeautentificat").modal("show");
  }

}

function modificaModal(id) {
  var phpAdmin = $("#phpAdmin").val();

  if(phpAdmin != '')
  {
    var modalId = "#modalAdmin-" + id;

    $(modalId).modal("show");

    $(modalId).on('hidden.bs.modal', function () {
              $(".modal-body1").html("");
      });
  }
  else
  {
    $("#modalClientNeautentificat").modal("show");
  }

}

function stergeModal(id) {
  var phpAdmin = $("#phpAdmin").val();

  if(phpAdmin != '')
  {
    var id = id.split("-");
    var modalId = "#stergePreparat-" + id[1];

    $(modalId).modal("show");

    $(modalId).on('hidden.bs.modal', function () {
              $(".modal-body1").html("");
      });
  }
  else
  {
    $("#modalClientNeautentificat").modal("show");
  }

}

function increaseValue(id) {
  var idPlus = parseInt(id.replace( /[^\d.]/g, ''), 10);

  var cantitate = parseInt(document.getElementById("number-" + idPlus).value, 10);
  cantitate = isNaN(cantitate) ? 1 : cantitate;
  var pret  = parseFloat(document.getElementById("schimbarePret-" + idPlus).innerText / cantitate);

  cantitate++;
  document.getElementById("number-" + idPlus).value = cantitate;
  document.getElementById("nr-" + idPlus).value = cantitate;

  var pretActualizat = cantitate * pret;

  document.getElementById("schimbarePret-" + idPlus).innerText = pretActualizat;
}

function decreaseValue(id) {
  var idMinus = parseInt(id.replace( /[^\d.]/g, ''), 10);

  var cantitate = parseInt(document.getElementById("number-" + idMinus).value, 10);
  cantitate = isNaN(cantitate) ? 1 : cantitate;

  var pret  = parseFloat(document.getElementById("schimbarePret-" + idMinus).innerText / cantitate);

  cantitate--;
  cantitate < 1 ? cantitate = 1 : "";

  document.getElementById("number-" + idMinus).value = cantitate;
  document.getElementById("nr-" + idMinus).value = cantitate;

  var pretActualizat = cantitate * pret;

  document.getElementById("schimbarePret-" + idMinus).innerText = pretActualizat;
}
