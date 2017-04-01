// JS for setting the "active" step class

// 'Next' buttons:
$(".next").click(function(){
  var oParent = $(this).closest(".step");
  setActiveStep(oParent.next());
});

// 'Back' buttons:
$(".back").click(function(){
  var oParent = $(this).closest(".step");
  setActiveStep(oParent.prev());
});


function setActiveStep(p_oDiv){
  
  // Set styles:  
  $(".step.active").removeClass("active");
 $(".step.inactive").removeClass("inactive");
  $(p_oDiv).addClass("active");
  $(p_oDiv).nextAll().addClass("inactive");

  // Scroll to active step:
    $('html, body').animate({
        scrollTop: $(p_oDiv).offset().top
    }, 500);
}

//Init the first step:
setActiveStep($(".step")[0]);