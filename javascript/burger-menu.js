function afiseazaMeniu(){
  document.getElementById("container-meniu").style.width    = "300px";
  document.getElementById("meniu-standard").style.display   = "block";
  document.getElementById("meniu-utilizator").style.display = "block";
  document.getElementById("afiseaza-meniu").style.display   = "none";
  document.getElementById("ascunde-meniu").style.display    = "block";

  $("#login").data('bs.popover').options.placement = "right";
}

function ascundeMeniu(){
  document.getElementById("container-meniu").style.width    = "100px";
  document.getElementById("meniu-standard").style.display   = "none";
  document.getElementById("meniu-utilizator").style.display = "none";
  document.getElementById("afiseaza-meniu").style.display   = "block";
  document.getElementById("ascunde-meniu").style.display    = "none";
}
