<script type="text/javascript">  
		//<![CDATA[
		function validate_form()
		{
		 
			if (document.MyForm.fname.value == "")
			{
				alert("Please enter the First Name");
				document.MyForm.fname.focus();
				return false;
			}
			if (document.MyForm.email.value == "")
			{
				alert("Please enter the Email");
				document.MyForm.email.focus();
				return false;
			}
			if (document.MyForm.email.value!='' && echeck(document.MyForm.email.value)  == false)
			{
				document.MyForm.email.focus();
				return false;
			}
			if (document.MyForm.yard.value == "")
			{
				alert("Please enter the Yard");
				document.MyForm.yard.focus();
				return false;
			}
			return true;
		}

function echeck(str) {

		var at='@'
		var dot='.'
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert('Invalid E-mail ID')
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert('Invalid E-mail ID')
		   return false
		}


		 if (str.indexOf(' ')!=-1){
		    alert('Invalid E-mail ID')
		    return false
		 }

 		 return true
	}

		//]]>
	</script>

	<form action="elist_form.php" method="post" class="extended" name="MyForm" onsubmit="return validate_form();" enctype="multipart/form-data">

		<input type="hidden" name="op" value="<?= $op; ?>" /> 

		<input type="hidden" name="subscriberid" value="<?= $subscriberid; ?>" /> 

		<p class="star_for_required"><?=_lang(star_for_required) ?></p>

		<table class="form_table">
		<tr><td>
		<label  class="required"  for="fname"> <span class="star">*</span> First Name</label>
		</td><td>
		<input type="text" name="fname" value="<?= $fname; ?>" id="fname"  />

		</td></tr>
		<tr><td>
		<label  for="lname">Last Name</label>
		</td><td>
		<input type="text" name="lname" value="<?= $lname; ?>" id="lname"  />

		</td></tr>
		<tr><td>
		<label  for="suburb">Suburb</label>
		</td><td>
		<input type="text" name="suburb" value="<?= $suburb; ?>" id="suburb"  />

		</td></tr>
		<tr><td>
		<label  for="tel">Telephone</label>
		</td><td>
		<input type="text" name="tel" value="<?= $tel; ?>" id="tel"  />

		</td></tr>
		<tr><td>
		<label  class="required"  for="email"> <span class="star">*</span> Email</label>
		</td><td>
		<input type="text" name="email" value="<?= $email; ?>" id="email"  />

		</td></tr>
		<tr><td>
		<label  for="source">Source</label>
		</td><td>
		<select name="source" id="source" >
		<?= ListOptions(array("walkin","Internet"),array("walkin","internet"),$source); ?>
		</select>
		</td></tr>
		<tr><td>
		<label  class="required"  for="yard">Yard</label>
		</td><td>
		<select name="yard" id="yard" >
		
		<?= ListOptions(array("","A","B","C","D","F","G","I","K","L","N","P","W"),array("","A","B","C","D","F","G","I","K","L","N","P","W"),$yard); ?>
		</select>
		</td></tr>
		<tr><td>
		<label  for="comp_id">Comp id</label>
		</td><td>
		<input type="text" name="comp_id" value="<?= $comp_id; ?>" id="comp_id"  />

		</td></tr>
		<tr><td>
		</td></tr>
		</table>
		<input class="button" type="submit" value="<?= $op; ?>" />  
	</form> 
		 

