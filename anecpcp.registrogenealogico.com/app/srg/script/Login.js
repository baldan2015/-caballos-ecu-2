/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {

  $("#btmSubmit").click(function () {

    grecaptcha.execute('6LcsW1QnAAAAAKqGcFVLrUHq7gPrB9C5LLnDFfuf', {
        action: 'qradmin'
      })
      .then(function (token) {
        var recaptchaResponse = document.getElementById('recaptchaResponse');
        recaptchaResponse.value = token;
        var login = {
          opc: "login",
          usr: $("#username").val(),
          pwd: $("#password").val(),
          recaptcha_response: token
        };
        validar(login);
        return false;
      });
  });


});

var validar = function (data) {
  $.ajax({
    data: data,
    url: 'ajax/ajaxLogin.php',
    type: 'post',
    beforeSend: function () {},
    success: function (response) {
      if ($.trim(response) == "OK") {
        document.location.href = "shared.php";
        $("#result").html("Bienvenido al Sistema");
      } else {
        $("#result").html(response);
      }
    }
  });
};