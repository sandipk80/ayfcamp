<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> Bootstrap Step Wizard</title>
	<meta name="Generator" content="http://www.amitpatil.me">
	<meta name="Author" content="Amit Patil">
	<meta name="Keywords" content="jquery,bootstrap,step form, step, form, wizard, script, form script, step form script, jQuery Wizard, jQuery Tabs, 
    jQuery Steps, HTML5, JavaScript, Accessibility, jQuery Form Wizard, jQuery Form Validation, jQuery Step by Step">
	<meta name="Description" content="A simple and easy multi step form script with bootstrap and jquery">
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	
	<link rel="stylesheet" href="css/style.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.validate.js"></script>

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

 </head>
 <body>
   
   <div class="container">
	<br><br>
	<form class="form-horizontal form">
	  <div class="col-md-8 col-md-offset-2">   	
		<div class="progress">
		  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
		
		<div class="box row-fluid">	
			<br>
			<div class="step">
				  <div class="form-group">
				    <label for="name" class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				      <input type="text" name="name" class="form-control" id="name" placeholder="Name">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="email" class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-10">
				      <input type="text" name="email" class="form-control" id="email" placeholder="email">
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label for="country" class="col-sm-2 control-label">Country</label>
				    <div class="col-sm-10">
				      <select class="form-control" name="country" id="country">
				      	<option value="">Select</option>
				      	<option value="in">India</option>
				      	<option value="au">Australia</option>
				      	<option value="us">USA</option>
				      	<option value="ja">Japan</option>
				      	<option value="sg">Singapore</option>
				      	<option value="my">Malaysia</option>
				      </select>
				    </div>
				  </div>
			</div>
			<div class="step">
				  <div class="form-group">
				    <label for="username" class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				      <input type="text" name="username" value="" class="form-control" id="username" placeholder="Username">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="password" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				      <input type="password" name="password" value="" class="form-control" id="password" placeholder="Password">
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label for="rpassword" class="col-sm-2 control-label">Retype Password</label>
				    <div class="col-sm-10">
				      <input type="password" name="rpassword" class="form-control" id="rpassword" placeholder="Retype password">
				    </div>
				  </div>			  	
			</div>
			<div class="step display">
				<h4>Confirm Details</h4>
				  <div class="form-group">
				    <label class="col-sm-2 control-label">Name</label>
				    <div class="col-sm-10">
				    	<label data-id="name"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2 control-label">Email</label>
				    <div class="col-sm-10">
				    	<label data-id="email"></label>
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label class="col-sm-2 control-label">Country</label>
				    <div class="col-sm-10">
				    	<label data-id="country"></label>
				    </div>
				  </div>			  
				  <div class="form-group">
				    <label class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				    	<label data-id="username"></label>
				    </div>
				  </div>
				  <div class="form-group">
				    <label class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				    	<label data-id="password"></label>
				    </div>
				  </div>			  
			</div>

			<div class="row">
			  <div class="col-sm-12">
			      <div class="pull-right">
					<button type="button" class="action btn-sky text-capitalize back btn">Back</button>
					<button type="button" class="action btn-sky text-capitalize next btn">Next</button>
					<button type="button" class="action btn-hot text-capitalize submit btn">Submit</button>
			      </div>
			  </div>
			</div>			

		</div>
		
	  </div> 
	</form> 
   </div>

 </body>
</html>
<script type="text/javascript">
	$(document).ready(function(){
		var current = 1;
		
		widget      = $(".step");
		btnnext     = $(".next");
		btnback     = $(".back"); 
		btnsubmit   = $(".submit");

		// Init buttons and UI
		widget.not(':eq(0)').hide();
		hideButtons(current);
		setProgress(current);

		// Next button click action
		btnnext.click(function(){
			if(current < widget.length){
				// Check validation
				if($(".form").valid()){
					widget.show();
					widget.not(':eq('+(current++)+')').hide();
					setProgress(current);
				}
			}
			hideButtons(current);
		})

		// Back button click action
		btnback.click(function(){
			if(current > 1){
				current = current - 2;
				if(current < widget.length){
					widget.show();
					widget.not(':eq('+(current++)+')').hide();
					setProgress(current);
				}
			}
			hideButtons(current);
		})

	    $('.form').validate({ // initialize plugin
			ignore:":not(:visible)",			
			rules: {
				name     : "required",
				email    : {required : true, email:true},
				country  : "required",
				username : "required",
				password : "required",
				rpassword: { required : true, equalTo: "#password"},
			},
	    });

	});

	// Change progress bar action
	setProgress = function(currstep){
		var percent = parseFloat(100 / widget.length) * currstep;
		percent = percent.toFixed();
		$(".progress-bar").css("width",percent+"%").html(percent+"%");		
	}

	// Hide buttons according to the current step
	hideButtons = function(current){
		var limit = parseInt(widget.length); 

		$(".action").hide();

		if(current < limit) btnnext.show();
		if(current > 1) btnback.show();
		if (current == limit) { 
			// Show entered values
			$(".display label:not(.control-label)").each(function(){
				console.log($(this).find("label:not(.control-label)").html($("#"+$(this).data("id")).val()));	
			});
			btnnext.hide(); 
			btnsubmit.show();
		}
	}
</script>

