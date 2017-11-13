$(document).ready(function(){
	loadcart();
  $("#news").jCarouselLite({
		vertical: true,
		hoverPause:true,
		btnPrev: "#news-prev",
		btnNext: "#news-next",
		visible: 3,
		auto: 3000,
		speed: 500
	});
loadcart();


	$("#style-grid").click(function(){
	$("#block-tovar-grid").show();	
	$("#block-tovar-list").hide();
	$("#style-grid").attr("src","/images/icon-grid-active.png");
	$("#style-list").attr("src","/images/icon-list.png");

	$.cookie('select-style','grid')
	});

	$("#style-list").click(function(){
	$("#block-tovar-grid").hide();	
	$("#block-tovar-list").show();
	$("#style-list").attr("src","/images/icon-list-active.png");
	$("#style-grid").attr("src","/images/icon-grid.png");

	$.cookie('select-style','list')
	});

if ($.cookie('select-style') == 'grid' )
 {	
	$("#block-tovar-grid").show();	
	$("#block-tovar-list").hide();
	$("#style-grid").attr("src","/images/icon-grid-active.png");
	$("#style-list").attr("src","/images/icon-list.png");
}
else
{
	$("#block-tovar-grid").hide();	
	$("#block-tovar-list").show();
	$("#style-list").attr("src","/images/icon-list-active.png");
	$("#style-grid").attr("src","/images/icon-grid.png");
	
}

$("#select-sort").click(function(){
	
	$("#sorting-list").slideToggle(200);
});
	 $('#block-category > ul > li > a').click(function(){
               	        
            if ($(this).attr('class') != 'active'){
                
			$('#block-category > ul > li > ul').slideUp(400);
            $(this).next().slideToggle(400);
            
                    $('#block-category > ul > li > a').removeClass('active');
					$(this).addClass('active');
                    $.cookie('select_cat', $(this).attr('id'));
                    
				}
				else{
                                   
                    $('#block-category > ul > li > a').removeClass('active');
                    $('#block-category > ul > li > ul').slideUp(400);
                    $.cookie('select_cat', '');   
                }  
	});
	 	if ($.cookie('select_cat') != '')
{
$('#block-category > ul > li > #'+$.cookie('select_cat')).addClass('active').next().show();
}
  $('#genpass').click(function(){
 $.ajax({
  type: "POST",
  url: "/options/genpass.php",
  dataType: "html",
  cache: false,
  success: function(data) {
  $('#reg_pass').val(data);
  }
});
 
}); 



	$('#reloadcaptcha').click(function(){
	$('#block-captcha > img').attr("src","/reg/reg_captcha.php?r="+ Math.random());
	});
$('.top-auth').toggle(
	function() {
		$('.top-auth').attr("id", "active-button");
		$("#block-top-auth").fadeIn(300)
	},
	function() {
		$('.top-auth').attr("id", "");
		$("#block-top-auth").fadeOut(300)
	}

	);



 $('.top-auth').toggle(
       function() {
           $(".top-auth").attr("id","active-button");
           $("#block-top-auth").fadeIn(200);
       },
       function() {
           $(".top-auth").attr("id","");
           $("#block-top-auth").fadeOut(200);  
       }
    );


$('#button-pass-show-hide').click(function(){
 var statuspass = $('#button-pass-show-hide').attr("class");
  
    if (statuspass == "pass-show")
    {
       $('#button-pass-show-hide').attr("class","pass-hide");
       
     			            var $input = $("#auth_pass");
			                var change = "text";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
        
    }else
    {
        $('#button-pass-show-hide').attr("class","pass-show");
        
     			            var $input = $("#auth_pass");
			                var change = "password";
			                var rep = $("<input placeholder='Пароль' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;        
       
    }
    


  }); 

$("#button-auth").click(function(){                                                             //отслеживается клик по кнопке Войти
    var auth_login = $("#auth_login").val();                                                    //логин помещается в переменную
    var auth_pass = $("#auth_pass").val();                                                      //пароль помещается в переменную
        if (auth_login == "" || auth_login.length > 30 ){                                       //проверка: если в переменной пусто и символов больше 30
            $("#auth_login").css("borderColor","#FDB6B6");                                      //то рамка поля ввода приобретает красны цвет
            var send_login = 'no';                                                                  //создается переменная со значением 'no'
            }
        else {                                                                                  //если в поле ввода не пусто и количество символов в пределах нормы
            $("#auth_login").css("borderColor","#DBDBDB");                                      //происходит иное изменение цвета рамки поля ввода
            var send_login = 'yes';                                                                 //создается переменная со значением 'yes'
            }
        if (auth_pass == "" || auth_pass.length > 15 ){                                         //аналогичная проверка поля с паролем
            $("#auth_pass").css("borderColor","#FDB6B6");
            var send_pass = 'no';
            }
        else {
            $("#auth_pass").css("borderColor","#DBDBDB");
            var send_pass = 'yes';
            }
        if ($("#remember_me").prop('checked')){                                                 //проверка: активен ли чекбокс,если активен
            var auth_remember_me = 'yes';                                                            //создается переменная со значением 'yes'
            }
        else {                                                                                  //если не активен
            var auth_remember_me = 'no';                                                             //создается переменная со значением 'no'
            }
        if ( send_login == 'yes' && send_pass == 'yes' ){                                       //проверка: если данные введены корректно
            $("#button-auth").hide();                                                           //кнопка Войти скрывается
            $(".auth-loading").show();                                                          //появляется анимация входа
            $.ajax({                                                                            //с помощью яджакс происходит отправка данных обработчику
                type: "post",
                url: "include/auth.php",
                data: "login="+auth_login+"&pass="+auth_pass+"&remember_me="+auth_remember_me,  //"login="+auth_login+"&pass="+auth_pass+"&remember_me="+auth_remember_me,
                dataType: "html",
                cache: true,
                success: function(data) {                                                       // возвращаются данные от обработчика
                    if (data == 'yes_auth'){ 
                    	                                                  //при успешной авторизации
                        location.reload(); 
                                                                                                  //страница перезагружается
                        }
                    else {                                                                      //при не верных данных
                        $("#message-auth").slideDown(400);                                      //всплывает сообщение
                        $(".auth-loading").hide();                                              //анимация загрузки скрывается
                        $("#button-auth").show(); 
                                                                                                  //страница перезагружается
                        
                                                                      //кнопка Войти вновь становится видна
                       
                        }
                    }
                }); 
            }
    }); 

$('#remindpass').click(function(){
    
      $('#input-email-pass').fadeOut(200, function() {  
            $('#block-remind').fadeIn(300);
      });
});

$('#prev-auth').click(function(){
    
      $('#block-remind').fadeOut(200, function() {  
            $('#input-email-pass').fadeIn(300);
      });
});



$('#button-remind').click(function(){
    
 var recall_email = $("#remind-email").val();
 
 if (recall_email == "" || recall_email.length > 20 )
 {
    $("#remind-email").css("borderColor","#FDB6B6");

 }else 
 {
   $("#remind-email").css("borderColor","#DBDBDB");
   
   $("#button-remind").hide();
   $(".auth-loading").show();
    
  $.ajax({
  type: "POST",
  url: "/include/remind-pass.php",
  data: "email="+recall_email,
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'yes')
  {
     $(".auth-loading").hide();
     $("#button-remind").show();
     $('#message-remind').attr("class","message-remind-success").html("На ваш e-mail выслан пароль.").slideDown(400);
     
     setTimeout("$('#message-remind').html('').hide(),$('#block-remind').hide(),$('#input-email-pass').show()", 4000);
 
  }else
  {
      $(".auth-loading").hide();
      $("#button-remind").show();
      $('#message-remind').attr("class","message-remind-error").html(data).slideDown(400);
      
  }
  }
}); 
  }
  }); 

 $('#auth-user-info').toggle(
       function() {
        $("#block-user").fadeIn(300);
        },
       function() {
        $("#block-user").fadeOut(100);
       }


       );

$('#logout').click(function(){
    
    $.ajax({
  type: "POST",
  url: "/include/logout.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  if (data == 'logout')
  {
      location.reload();
  }
  
}
}); 
});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
    }
 
  $('#confirm-button-next').click(function(e){   

   var order_fio = $("#order_fio").val();
   var order_email = $("#order_email").val();
   var order_phone = $("#order_phone").val();
   var order_address = $("#order_address").val();
   
 if (!$(".order_delivery").is(":checked"))
 {
    $(".label_delivery").css("color","#E07B7B");
    send_order_delivery = '0';

 }else { $(".label_delivery").css("color","black"); send_order_delivery = '1';

  
   
 if (order_fio == "" || order_fio.length > 50 )
 {
    $("#order_fio").css("borderColor","#FDB6B6");
   send_order_fio = '0';
   
 }else { $("#order_fio").css("borderColor","#DBDBDB");  send_order_fio = '1';}

  
 
 if (isValidEmailAddress(order_email) == false)
 {
    $("#order_email").css("borderColor","#FDB6B6");
  send_order_email = '0';   
 }else { $("#order_email").css("borderColor","#DBDBDB"); send_order_email = '1';}
  
 
 
  if (order_phone == "" || order_phone.length > 50)
 {
    $("#order_phone").css("borderColor","#FDB6B6");
    send_order_phone = '0';   
 }else { $("#order_phone").css("borderColor","#DBDBDB"); send_order_phone = '1';}
 
 
 
  if (order_address == "" || order_address.length > 150)
 {
    $("#order_address").css("borderColor","#FDB6B6");
    send_order_address = '0';   
 }else { $("#order_address").css("borderColor","#DBDBDB"); send_order_address = '1';}
  
} 
 
 if (send_order_delivery == "1" && send_order_fio == "1" && send_order_email == "1" && send_order_phone == "1" && send_order_address == "1")
 {
 
   return true;
 }

e.preventDefault();

});


$('.add-cart-style-list,.add-cart-style-grid,.add-cart,.random-add-cart').click(function(){
              
 var  tid = $(this).attr("tid");

 $.ajax({
  type: "POST",
  url: "/include/addtocart.php",
  data: "id="+tid,
  dataType: "html",
  cache: false,
  success: function(data) { 
  loadcart();
      }
});

});

function loadcart(){
     $.ajax({
  type: "POST",
  url: "/include/loadcart.php",
  dataType: "html",
  cache: false,
  success: function(data) {
    
  if (data == "0")
  {
  
    $("#block-basket > a").html("Корзина пуста");
  
  }else
  {
    $("#block-basket > a").html(data);

  }  
    
      }
});    
       
}



 function fun_group_price(intprice) { 
  var result_total = String(intprice);
  var lenstr = result_total.length;
  
    switch(lenstr) {
  case 4: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4);
    break;
  }
  case 5: {
  groupprice = result_total.substring(0,2)+" "+result_total.substring(2,5);
    break;
  }
  case 6: {
  groupprice = result_total.substring(0,3)+" "+result_total.substring(3,6); 
    break;
  }
  case 7: {
  groupprice = result_total.substring(0,1)+" "+result_total.substring(1,4)+" "+result_total.substring(4,7); 
    break;
  }
  default: {
  groupprice = result_total;  
  }
}  
    return groupprice;
    }



$('.count-minus').click(function(){

  var iid = $(this).attr("iid");      
 
 $.ajax({
  type: "POST",
  url: "/include/count-minus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);
  
  
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" тг");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
location.reload();
      }
});
  
});

$('.count-plus').click(function(){

  var iid = $(this).attr("iid");      
  
 $.ajax({
  type: "POST",
  url: "/include/count-plus.php",
  data: "id="+iid,
  dataType: "html",
  cache: false,
  success: function(data) {   
  $("#input-id"+iid).val(data);  
  
  
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
  
  result_total = Number(priceproduct) * Number(data);
 
  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" тг");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  
  itog_price();
location.reload();
      }
});
  
});

 $('.count-input').keypress(function(e){
    
 if(e.keyCode==13){
     
 var iid = $(this).attr("iid");
 var incount = $("#input-id"+iid).val();        
 
 $.ajax({
  type: "POST",
  url: "/include/count-input.php",
  data: "id="+iid+"&count="+incount,
  dataType: "html",
  cache: false,
  success: function(data) {
  $("#input-id"+iid).val(data);  
    
  var priceproduct = $("#tovar"+iid+" > p").attr("price"); 
 
  result_total = Number(priceproduct) * Number(data);


  $("#tovar"+iid+" > p").html(fun_group_price(result_total)+" тг");
  $("#tovar"+iid+" > h5 > .span-count").html(data);
  itog_price();

      }
}); 
  }
});

function  itog_price(){
 $.ajax({
  type: "POST",
  url: "/include/itog_price.php",
  dataType: "html",
  cache: false,
  success: function(data) {

  $(".itog-price > strong").html(data);
location.relod();

}
}); 
       
}

$('#button-send-review').click(function(){
                
   var name = $("#name_review").val();
   var good = $("#good_review").val();
   var bad = $("#bad_review").val();
   var comment = $("#comment_review").val();
   var iid = $("#button-send-review").attr("iid");

    if (name != "")
     {
          name_review = '1';
          $("#name_review").css("borderColor","#DBDBDB");
      }else {
           name_review = '0';
           $("#name_review").css("borderColor","#FDB6B6");
      }
                  
    if (good != "")
       {
          good_review = '1';
          $("#good_review").css("borderColor","#DBDBDB");
      }else {
          good_review = '0';
          $("#good_review").css("borderColor","#FDB6B6");
      }
            
    if (bad != "")
     {
          bad_review = '1';
          $("#bad_review").css("borderColor","#DBDBDB");
     }else {
          bad_review = '0';
          $("#bad_review").css("borderColor","#FDB6B6");
     } 
                                         
            
            // Глобальная проверка и отправка отзыва
            
    if ( name_review == '1' && good_review == '1' && bad_review == '1')
      {
         $("#button-send-review").hide();
         $("#reload-img").show();
                  
      $.ajax({
         type: "POST",
         url: "/include/add_review.php",
         data: "id="+iid+"&name="+name+"&good="+good+"&bad="+bad+"&comment="+comment,
         dataType: "html",
         cache: false,
         success: function() {
         setTimeout("$.fancybox.close()", 1000);
         location.reload();
         }
         });  
         }         
});

});