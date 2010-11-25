$(document).ready(function(){

var table_variable_info = document.getElementsByClassName("view-variable-info");

  $(table_variable_info).hide();

  $("#show_vars_link").click(function() {
    if ($(table_variable_info).is(":hidden")) {
      $(table_variable_info).slideDown("slow");
    } else {
      $(table_variable_info).hide();
    }   
  });
});
