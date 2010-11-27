$(document).ready(function(){

var table_variable_info = document.getElementsByClassName("view-variable-info");

  $(table_variable_info).hide();
  $("div#show_vars_link").css("color", "blue").css("padding-bottom", "1em");
	
  $("div#show_vars_link").hover(
    function () {
      $(this).css("color", "red").css("text-decoration", "underline");
    },
    function () {
      $(this).css("color", "blue").css("text-decoration", "none");
    }
  );

  $("div#show_vars_link").click(function() {
    if ($(table_variable_info).is(":hidden")) {
      $(table_variable_info).slideDown("slow");
      $('html, body').animate({
        scrollTop: $(table_variable_info).offset().top
      }, 1000);
    } else {
      $(table_variable_info).hide();
    }
  });
});

