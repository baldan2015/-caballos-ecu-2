



$(function(){

$("#txtBGNombre").on("keypress",function(e){
	var target = (e.target ? e.target : e.srcElement);
    var key = (e ? e.keyCode || e.which : window.event.keyCode);
    if (key == 13){
    	_buscar();
    }else{
		return true;
	}
	
});

 $("#btnBGBuscar").on("click",_buscar);

});

var _buscar=function(){
var request=$("#txtBGNombre").val().toUpperCase();
var hidCtrolId=$("#hidCtrolId").val();
var hidCtrolName=$("#hidCtrolName").val();
var hidParents=$("#hidTipoParents").val();
if($("#txtBGNombre").val()==""){
var hidflag="mine";
}else{
var hidflag="all";
}


		$.ajax({
				data:  {request:request,
						hidCtrolId:hidCtrolId,
						hidCtrolName:hidCtrolName,
						hidParents:hidParents,
						idUser:$("#hidIdProp").val(),
						idPoe:$("#hidIdPoe").val(),
						flag:hidflag
					},
				url:   'ajaxPOE/ajaxBusGralEjemplarold.php',
				type:  'post',
				success:  function (response) {
				    $("#divResultBG").html(response);
				    $('.gridHtmlBG tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
				},
            	statusCode: {
               		404: function() {
               			//se ta usango la busqueda general desde el admin.
                   			$.ajax({
										data:  {request:request,
												hidCtrolId:hidCtrolId,
												hidCtrolName:hidCtrolName,
												hidParents:hidParents,
												idUser:$("#hidIdProp").val(),
												idPoe:$("#hidIdPoe").val()
											},
										url:   '../ajaxPOE/ajaxBusGralEjemplarold.php',
										type:  'post',
										success:  function (response) {
										    $("#divResultBG").html(response);
										    $('.gridHtmlBG tbody tr ').hover(function () { $(this).addClass("ui-row-ltr ui-state-hover"); }, function () { $(this).removeClass("ui-row-ltr ui-state-hover"); });
										}
						});
               	}
            	}
		});

};



