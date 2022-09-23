


window.setInterval(function() {

  
  
  var current = new Date();
  var expiry = new Date("May 01, 2018 00:00:01");



  if (current.getTime() > expiry.getTime()) {
    $('.early').hide();
    $('.nonEarly').show();

  } else if (current.getTime() < expiry.getTime()) {
  	$('.early').show();
  	$('.nonEarly').hide();
    
  }

}, 0);

	$(function() {
    $( '#register' ).find( 'input' ).click(function() {

        var totalCost = $('#cost_calc_total_cost').html();
		$('#cost_calc_total_cost02').text(totalCost);

		var totalInt = totalCost.substring(1,totalCost.lenght);
		var AccompteCost = Math.round((totalInt /2)-1);
		$('#cost_calc_total_costAcc').text('(€'+AccompteCost+'.00)');
		var soldeCost = Math.round(totalInt /2);
		$('#cost_calc_total_costSolde').text('(€'+soldeCost+'.00)');


	
    });
});

	// function reductionMPS(){
		

	// 	if($('#otherMPS02').is(':checked')){
	// 		$('#otherMPS01').prop('disabled', true);
	// 		$('#otherMPS02').prop('disabled', false);
	// 	}else if($('#otherMPS01').is(':checked')){
	// 		$('#otherMPS02').prop('disabled', true);
	// 		$('#otherMPS01').prop('disabled', false);
			
	// 	}
	// }



	function showForm(){
		$('#formInfo').show();
		$('#formInfoBtn').hide();
	}



	

	// INAMI script next step & juste chiffres
$.noConflict();
jQuery( document ).ready(function( $ ) {

$("#INAMI").keyup(function () {
    if (this.value.length == 1) {
      $('#INAMI2').focus();
    }
});
$("#INAMI2").keyup(function () {
    if (this.value.length == 5) {
      $('#INAMI3').focus();
    }
});
$("#INAMI3").keyup(function () {
    if (this.value.length == 2) {
      $('#INAMI4').focus();
    }
});
$("#INAMI4").keyup(function () {
    if (this.value.length == 3) {
      $('#rue').focus();
    }
});


$("#Accompagnant_INAMI").keyup(function () {
    if (this.value.length == 1) {
      $('#Accompagnant_INAMI2').focus();
    }
});
$("#Accompagnant_INAMI2").keyup(function () {
    if (this.value.length == 5) {
      $('#Accompagnant_INAMI3').focus();
    }
});
$("#Accompagnant_INAMI3").keyup(function () {
    if (this.value.length == 2) {
      $('#Accompagnant_INAMI4').focus();
    }
});
$("#Accompagnant_INAMI4").keyup(function () {
    if (this.value.length == 3) {
      $('#rue_accompagnant').focus();
    }
});

});

function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

// INAMI script next step & juste chiffres

