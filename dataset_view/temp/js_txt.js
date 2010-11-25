http://www.myacpl.org/koha/?p=463
//alert("Hello World");
//view view-variable-info view-id-variable_info view-display-id-panel_pane_1 view-dom-id-2
$("view-variable-info").hide();
$("table").show();

var header_cells = document.getElementsByClassName("view-variable-info");

http://webdesignfan.com/working-with-firebug-part-2-javascript/

console.log('5' + 5, 5 + 5)

views-field views-field-title

----- works: 
var header_cells = document.getElementsByClassName("view-variable-info");

$(header_cells).show();

console.log(header_cells);
----------
http://drupal.org/node/606294:

$myfield = $data->field_my_field;
$link = "<a href='javascript:callMyFunction($myfield)'>Click me</a>";
echo $link;

===========
http://oceaninformatics.ucsd.edu/datazoo/data/pallter/datasets?action=summary&id=49
  TODO: Variables - click and open whole table
  
ashipunova@sig-app11:/data/drupal/sites/all/themes/my_basic$ vim scripts.js

$(document).ready(function(){
//  alert("Hello World");
var table_variable_info = document.getElementsByClassName("view-variable-info");

$(table_variable_info).show();

//showDiv("columns", this.id);

//  $("#navbar ul li a")
//  .wrapInner("<span>" + "</span>");
});

//Drupal.behaviors.shadows = function (context) {
// Shawdow maker
//  $('.views-table').boxShadow( 10px, 10px, 5, #888;);
//};

~                                                                               
~                                                                               
~                                                                               
~                                                                               
~                                                                               
~                                                                               
"scripts.js" 17L, 399C written                                7,30          All
--------
$(document).ready(function(){
//  alert("Hello World");
// show_vars_link
//  $("#navbar ul li a")


var table_variable_info = document.getElementsByClassName("view-variable-info");

$(table_variable_info).hide();

//showDiv("columns", this.id);
//todo link here
  $("#show_vars_link").click(function() {
//      showDiv("columns", this.id)
  $(table_variable_info).show();
  }
//  .wrapInner("<span>" + "</span>");
});

//Drupal.behaviors.shadows = function (context) {
// Shawdow maker
//  $('.views-table').boxShadow( 10px, 10px, 5, #888;);
//};
================
$(document).ready(function(){
//  alert("Hello World");
// show_vars_link
//  $("#navbar ul li a")


var table_variable_info = document.getElementsByClassName("view-variable-info");

$(table_variable_info).hide();

//showDiv("columns", this.id);
//todo size/color or arrows - open/close, click again - hide
  $("#show_vars_link").click(function() {
   $(table_variable_info).show();
  });
});

//Drupal.behaviors.shadows = function (context) {
// Shawdow maker
//  $('.views-table').boxShadow( 10px, 10px, 5, #888;);
//};
============
JavaScript in Drupal
http://drupal.org/node/121997
------------
    content.style.display!='none' ? content.style.display='none' : content.style.display='block';    
    
W!    $("#show_vars_link").wrapInner("<span>" + "</span>");


//style.display='none';

var el = document.getElementById(id);
  el.style.color = "red";
============

// trigger the function when clicking on #img
$("#img").click(function () {
// check visibility
if ($("#div").is(":hidden")) {
// it's hidden - show it
$("#div").slideDown("slow");
} else {
// it's not hidden - slide it down
$("#div").hide();
}
});

W! if ($(".view-variable-info").is(":hidden")) { 
//alert("Ura!");
$(".view-variable-info").slideDown("slow");

};
=============
$(document).ready(function(){
//  alert("Hello World");
//var table_variable_info = document.getElementsByClassName("view-variable-info");

//$(table_variable_info).hide();
$(".view-variable-info").hide();
//$("#show_vars_link").style.color = "red";


//showDiv("columns", this.id);
//todo size/color or arrows - open/close, click again - hide
  $("#show_vars_link").click(function() {
//   $(table_variable_info)
$(".view-variable-info").show();
  });
});
===============

$(document).ready(function(){

var table_variable_info = document.getElementsByClassName("view-variable-info");

$(table_variable_info).hide();

//todo size/color or arrows - open/close, click again - hide
  $("#show_vars_link").click(function() {
   // $(table_variable_info).show();

		if ($(table_variable_info).is(":hidden")) {
			$(table_variable_info).slideDown("slow");
		} else {
			$(table_variable_info).hide();
		}
  });
});

//Drupal.behaviors.shadows = function (context) {
// Shawdow maker
//  $('.views-table').boxShadow( 10px, 10px, 5, #888;);
//};




$("#img").click(function () {
// check visibility
if ($("#div").is(":hidden")) {
// it's hidden - show it
$("#div").slideDown("slow");
} else {
// it's not hidden - slide it down
$("#div").hide();
}

});

if ($(".view-variable-info").is(":hidden")) { 
//alert("Ura!");
$(".view-variable-info").slideDown("slow");

};

a:link, a:visited {
color:blue;
text-decoration:none;
}

show_vars_link

document.getElementById('youridhere').scrollIntoView();


var position = table_variable_info.offsetParent && table_variable_info.offsetTop + absoluteOffset(table_variable_info.offsetParent);
window.scroll(absoluteOffset(table_variable_info));

/html/body/div[2]/div[2]/div/div/div[2]/div/div/div[2]/div/div/div/div/div/div/div[2]/div/div[2]/div/div/div[3]/ul/li[2]
1 of 4
<li class="pager-current">1 of 4</li>
div.item-list
ul.pager
li.pager-current

//  $("#navbar ul li a")
 $(".item-list ul li")

var position = $(".item-list ul li").offsetParent && $(".item-list ul li").offsetTop + absoluteOffset($(".item-list ul li").offsetParent);
window.scroll(absoluteOffset($(".item-list ul li")));

document.getElementByClass(".item-list").scrollIntoView();

scrollIntoView
$(".item-list ul.pager")

//$(".item-list ul.pager").scrollIntoView();

alert($(".item-list ul.pager").scrollIntoView());
 this[0].offsetParent

alert($(".item-list ul.pager").offsetParent);
 this[0].offsetParent

var objDiv = document.getElementByClass(".item-list ul.pager");
objDiv.scrollTop = objDiv.scrollHeight;

var objDiv = document.getElementById("divExample");
objDiv.scrollTop = objDiv.scrollHeight;

//alert($(".item-list ul.pager").scrollTop);
//scroll_clipper.scrollTop = 0;
//alert("HERE 1");
var objDiv = document.getElementsByClassName(".item-list");
alert($(objDiv));


function scrollToWindow()
{
 var xpos= document.getElementById('txtXpos').value;
 var ypos= document.getElementById('txtYpos').value;
 alert("Scroll to X-"+xpos+" and Y-"+ypos);
 window.scrollTo(xpos,ypos);
}


var xpos= document.getElementsByClassName(".item-list").value;
var ypos= document.getElementsByClassName(".item-list").value;
alert("Scroll to X-"+xpos+" and Y-"+ypos);
window.scrollTo(xpos,ypos);

var xpos = document.getElementsByClassName(".item-list").value;
alert($(ypos));
var ypos = document.getElementsByClassName(".item-list").value;
alert("Scroll to X-"+xpos+" and Y-"+ypos);
window.scrollTo(xpos,ypos);
document.getElementById("content").scrollTop = 0;


var objDiv = document.getElementsByClassName(".item-list");
alert($(objDiv));

var objDiv = document.getElementsByClassName(".view-dataset-info");
alert($(objDiv));

document.getElementsByClassName(".view-dataset-info").scrollTop = 0;

W!
var objDiv = document.getElementsByClassName("view-dataset-info");
$(objDiv).hide();

=================
http://oceaninformatics.ucsd.edu/datazoo/data/pallter/datasets?action=summary&id=49

DZDatasets.showColumnInfo(this, "603_unit"); return false;
id = 603_unit
class = display-box-contrast column-details
DZDatasets.showColumnInfo(this, "601_attribute"); return false;
