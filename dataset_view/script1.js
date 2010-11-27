$('html, body').scrollTop($(".view-variable-info").offset().top);

$('html, body').animate({
  scrollTop: $(".view-variable-info").offset().top
}, 2000);

// #show_vars_link {
//   color: blue;
//   padding-bottom: 1em;
// }
// 
// #show_vars_link:hover, #show_vars_link:active{
//   color: red;
//   text-decoration: underline;
// }

// $('html, body').animate({
// scrollTop: $(".pager").offset().top
// }, 0);

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