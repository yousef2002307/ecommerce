$(document).ready(function(){
    $("input[required]").each(function(){
        $(this).after("<span>*</span>")
    });
  
  //////////////////////////////////////////////////

  $(".xyz span.loginup").click(function(){
      $("form.login").fadeIn();
      $("form.signup").fadeOut();
     console.log("hjjh")
  });
  $(".xyz span.signup2").click(function(){
    $("form.signup").fadeIn();
    $("form.login").fadeOut();
    console.log("hjjh")
});
$("li.signup3").click(function(){
$(".signup2").click();
});
});









