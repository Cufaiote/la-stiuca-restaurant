$("[data-toggle=popover]").popover({
    html: true,
	  content: function() {
          return $('#popover-content').html();
    }
});
/*$(document).ready(function(){
  $("input[type=checkbox]").click(function() {alert('gg8');
    if($(this).prop("checked")){
      $('#loginOrSignupButton').html('Sign up!');
    }else{
      $('#loginOrSignupButton').html('Log in!');
    }
   });
});
function btnQQd(){
   if( $('#signupCheckbox').is(':checked') ){alert('gg17');
      //$('#loginOrSignupButton').html('Sign up!');
    }else{alert('gg19');
      //$('#loginOrSignupButton').html('Log in!');
    }
}*/
