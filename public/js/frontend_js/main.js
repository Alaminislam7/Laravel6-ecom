
/*price range*/

$('#sl2').slider();

var RGBChange = function() {
  $('#RGB').css('background', 'rgb('+r.getValue()+','+g.getValue()+','+b.getValue()+')')
};	
		
/*scroll to top*/

$(document).ready(function(){
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollUp', // Element ID
	        scrollDistance: 300, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 300, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 200, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});
});



	//AKAHE JAVASCRIPT ERROR ASE TAI KAJ HOCCE NA


//Change price with size
$(document).ready(function(){
	
	// Change Price with Size
	$("#selSize").change(function(){
		var idSize = $(this).val();
		if(idSize==""){
			return false;
		}
		$.ajax({
			type:'get',
			url:'/get-product-price',
			data:{idSize:idSize},
			success:function(resp){
				var arr = resp.split('#');
				//alert(resp); return false;
				$("#getPrice").html("TK "+arr[0]);
				$("#price").val(arr[0]);
				//var arr1 = arr[0].split('-');
				//$("#getPrice").html("INR "+arr1[0]+"<br><h2>USD "+arr1[1]+"<br>GBP "+arr1[2]+"<br>EUR "+arr1[3]+"</h2>");
				//$("#price").val(arr[0]);
				if(arr[1]==0){
					$("#cartButton").hide();
					$("#Availability").text("Out Of Stock");
				}else{
					$("#cartButton").show();
					$("#Availability").text("In Stock");
				}
				
				
			},error:function(){
				alert("Error");
			}
		});
	});

	// Change Image
	$("#ChangImages").click(function(){
		var image = $(this).attr('src');
		$("#MainImage").attr("src", image);
		/*$("#mainImgLarge").attr("href", image);*/
	});

	// Instantiate EasyZoom instances
	var $easyzoom = $('.easyzoom').easyZoom();

	// Setup thumbnails example
	var api1 = $easyzoom.filter('.easyzoom--with-thumbnails').data('easyZoom');

	$('.thumbnails').on('click', 'a', function(e) {
		var $this = $(this);

		e.preventDefault();

		// Use EasyZoom's `swap` method
		api1.swap($this.data('standard'), $this.attr('href'));
	});

	// Setup toggles example
	var api2 = $easyzoom.filter('.easyzoom--with-toggle').data('easyZoom');

	$('.toggle').on('click', function() {
		var $this = $(this);

		if ($this.data("active") === true) {
			$this.text("Switch on").data("active", false);
			api2.teardown();
		} else {
			$this.text("Switch off").data("active", true);
			api2._init();
		}
	});

});



$().ready(function(){
	// Validate Register form on keyup and submit
	$("#registerForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept: "[a-zA-Z]+"
			},
			password:{
				required:true,
				minlength:6
			},
			email:{
				required:true,
				email:true,
				remote:"/check-email"
			}
		},
		messages:{
			name:{ 
				required:"Please enter your Name",
				minlength: "Your Name must be atleast 2 characters long",
				accept: "Your Name must contain letters only"		
			}, 
			password:{
				required:"Please provide your Password",
				minlength: "Your Password must be atleast 6 characters long"
			},
			email:{
				required: "Please enter your Email",
				email: "Please enter valid Email",
				remote: "Email already exists!"
			}
		}
	});
	// Validate Register form on keyup and submit
	$("#accountForm").validate({
		rules:{
			name:{
				required:true,
				minlength:2,
				accept: "[a-zA-Z]+"
			},
			address:{
				required:true,
				minlength:6
			},
			city:{
				required:true,
				minlength:2
			},
			state:{
				required:true,
				minlength:2
			},
			country:{
				required:true
			}
		},
		messages:{
			name:{ 
				required:"Please enter your Name",
				minlength: "Your Name must be atleast 2 characters long",
				accept: "Your Name must contain letters only"		
			}, 
			address:{
				required:"Please provide your Address",
				minlength: "Your Address must be atleast 10 characters long"
			},
			city:{
				required:"Please provide your City",
				minlength: "Your City must be atleast 2 characters long"
			},
			state:{
				required:"Please provide your State",
				minlength: "Your State must be atleast 2 characters long"
			},
			country:{
				required:"Please select your Country"
			},
		}
	});
	// Validate Register form on keyup and submit
	$("#loginForm").validate({
		rules:{
			email:{
				required:true,
				email:true,
			},
			password:{
				required:true,
			}
		},
		messages:{ 
			email:{
				required: "Please enter your Email",
				email: "Please enter valid Email",
			},
			password:{
				required:"Please provide your Password",
			},
		}
	});

	// Password Strength Script
	$('#myPassword').passtrength({
		minChars: 4,
		passwordToggle: true,
		tooltip: true,
		eyeImg : "/images/frontend_images/eye.svg"
	});

	// Check Current User Password
	$("#current_pwd").keyup(function(){
		var current_pwd = $("#current_pwd").val();
		$.ajax({
			type:'get',
			url:'/check-user-pwd',
			data:{current_pwd:current_pwd},
			success:function(resp){
				if(resp=="false"){
					$("#chkPwd").html("<font color='red'>Current Password is incorrect</font>");
				}else if(resp=="true"){
					$("#chkPwd").html("<font color='green'>Current Password is correct</font>");
				}
			},error:function(){
				alert("Error");
			}
		});
	});

	//Updated password validation
	$("#passwordForm").validate({
		rules:{
			current_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			new_pwd:{
				required: true,
				minlength:6,
				maxlength:20
			},
			confirm_pwd:{
				required:true,
				minlength:6,
				maxlength:20,
				equalTo:"#new_pwd"
			}
		},
		errorClass: "help-inline",
		errorElement: "span",
		highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).parents('.control-group').removeClass('error');
			$(element).parents('.control-group').addClass('success');
		}
	});

	//Copy biling address to shiping address script
	$("#copyAddress").click(function(){
		if(this.checked){
			$("#shipping-name").val($("#billing-name").val());
			$("#shipping-address").val($("#billing-address").val());
			$("#shipping-city").val($("#billing-city").val());
			$("#shipping-state").val($("#billing-state").val());
			$("#shipping-pincode").val($("#billing-pincode").val());
			$("#shipping-mobile").val($("#billing-mobile").val());
			$("#shipping-country").val($("#billing-country").val());
		}else{
			$("#shipping-name").val('');
			$("#shipping-address").val('');
			$("#shipping-city").val('');
			$("#shipping-state").val('');
			$("#shipping-pincode").val('');
			$("#shipping-mobile").val('');
			$("#shipping-country").val('');
		}
	});
	

});

function selectPaymentMethod(){
	if($('#paypal').is(':checked') || $('#COD').is(':checked')){

	}else{
		alert('Please Select payment mathod');
		return false;
	}
}

/*--------------------current pincode showing not working----------------------*/
//check pincode
function checkPincode(){
	var pincode = $("#chkPincode").val();
	if(pincode==""){
		alert("Please enter Pincode"); return false;	
	}
	$.ajax({
		type:'post',
		data:{pincode:pincode},
		url:'/check-pincode',
		success:function(resp){
			if(resp>0){
				$("#pincodeResponse").html("<font color='green'>This pincode is available for delivery</font>");
			}else{
				$("#pincodeResponse").html("<font color='red'>This pincode is not available for delivery</font>");	
			}
		},error:function(){
			alert("Error");
		}
	});
}




