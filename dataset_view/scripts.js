$(document).ready(function(){

var table_variable_info = document.getElementsByClassName("view-variable-info");

  $(table_variable_info).hide();
  $("#show_vars_link").css("color", "blue").css("padding-bottom", "1em");
	
  $("#show_vars_link").hover(
    function () {
      $(this).css("color", "red").css("text-decoration", "underline");
    },
    function () {
      $(this).css("color", "blue").css("text-decoration", "none");
    }
  );

  $("#show_vars_link").click(function() {
    if ($(table_variable_info).is(":hidden")) {
      $(table_variable_info).slideDown("slow");
    } else {
      $(table_variable_info).hide();
    }
		$('html, body').animate({
		  scrollTop: $(".view-variable-info").offset().top
		}, 0);
  });
});
