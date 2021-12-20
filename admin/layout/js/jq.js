$(document).ready(function(){
    $("input[required]").each(function(){
        $(this).after("<span>*</span>")
    });
    $(".confirm").click(function(){
        console.log("hello rgdfgfgffd");
            return confirm("are you sure");
    });
  $(".cat span").click(function(){
      console.log("hello man");
  });
  $("table").click(function(){
console.log("table");
  });
  $(".stat").click(function(){
    console.log("stat")
  });
  $('[name=tags2]').tagify();

 

// Vanilla JavaScript

$('[name=tags2]').tagify({duplicates :false});


});









