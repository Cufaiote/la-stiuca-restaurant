function afiseazaModalPreparat(id)
{
  var id = id.split("-");

  $("#modalPreparat" + id[1]).modal('show');
}

function afiseazaPreparatAnterior(id) {
  var id = id.split("-");
  var urmator = parseInt(id[1]) - 1;

  $("#modalPreparat" + id[1]).modal('hide');
  $("#modalPreparat" + urmator).modal('show');
}

function afiseazaPreparatUrmator(id) {
  var id = id.split("-");
  var urmator = parseInt(id[1]) + 1;

  $("#modalPreparat" + id[1]).modal('hide');
  $("#modalPreparat" + urmator).modal('show');

}

function afiseazaModalRestaurant(id)
{
  var id = id.split("-");

  $("#modalRestaurant" + id[1]).modal('show');
}

function afiseazaAnterior(id) {
  var id = id.split("-");
  var urmator = parseInt(id[1]) - 1;

  $("#modalRestaurant" + id[1]).modal('hide');
  $("#modalRestaurant" + urmator).modal('show');
}

function afiseazaUrmator(id) {
  var id = id.split("-");
  var urmator = parseInt(id[1]) + 1;

  $("#modalRestaurant" + id[1]).modal('hide');
  $("#modalRestaurant" + urmator).modal('show');

}

//              MODAL ADMIN
function modificaImagineModal(id) {
  var id = id.split("-");

  $("#modificaImaginePreparat" + id[1]).modal('show');
}

function modificaImagineRestaurantModal(id) {
  var id = id.split("-");

  $("#modificaImagineRestaurant" + id[1]).modal('show');
}

function stergeImagineModal(id) {
  var id = id.split("-");

  $("#stergeImaginePreparat" + id[1]).modal('show');
}
