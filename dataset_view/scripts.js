$(document).ready(function(){
        
 // Show/hide variable tables
  var table_variable_info = document.getElementsByClassName("view-variable-info");

  $(table_variable_info).hide();
  $("div#show_vars_link").text("Show/Hide Variables").css("color", "blue").css("padding-bottom", "1em");

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

// Show more or less methods
  var adjustheight = 70;
  var moreText = "+  More";
  var lessText = "- Less";

  $(".more-less .more-block").css('height', adjustheight).css('overflow', 'hidden');
  $(".more-less").append('<p class="continued">[&hellip;]</p><a href="#" class="adjust"></a>');
  $("a.adjust").text(moreText);
  $(".adjust").toggle(function() {
            $(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
            $(this).parents("div:first").find("p.continued").css('display', 'none');
            $(this).text(lessText);
    }, function() {
            $(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
            $(this).parents("div:first").find("p.continued").css('display', 'block');
            $(this).text(moreText);
   });
});

