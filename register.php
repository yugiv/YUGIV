<?php
require ("require.php");
if(isset($_SESSION['uid'])){
	header("Location: ".$originallink."@");
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>yugiv</title>
		<meta charset="utf8_unicode_ci">
		<link href='https://fonts.googleapis.com/css?family=Bree+Serif' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="<?=$originallink?>css/mystyle.css">
		<script type='text/javascript' src='<?=$originallink?>src/jquery-2.1.4.min.js'></script>
		<link rel="stylesheet" type="text/css" href="<?=$originallink?>css/tipsy.css">
		<script type="text/javascript" src="<?=$originallink?>src/jquery.tipsy.js"></script>
		<script type="text/javascript" src="<?=$originallink?>ajax/login.js"></script>
		<script>
			$.fn.tipsy.defaults = {
			    delayIn: 0,      // delay before showing tooltip (ms)
			    delayOut: 0,     // delay before hiding tooltip (ms)
			    fade: true,     // fade tooltips in/out?
			    fallback: '',    // fallback text to use when no tooltip text
			    gravity: 'n',    // gravity
			    html: true,     // is tooltip content HTML?
			    live: false,     // use live event support?
			    offset: 0,       // pixel offset of tooltip from element
			    opacity: 0.8,    // opacity of tooltip
			    title: 'title',  // attribute/callback containing tooltip text
			    trigger: 'manual' // how tooltip is triggered - hover | focus | manual
			};
		</script>
	</head>

	<body>
	<header>
		<div style="float: right;">
		<input class="log" type="text" placeholder="full name or phone number" name="username" autocomplete="on"/>
		<input class="log" placeholder="password" type="password" name="password" autocomplete="on"/>
		<input type="button" value="Log in!" name="login" id="log"/>
		</div>
		
	</header>
	<table cellpadding="4" id="register">
		<tr>
			<td class="texttable" colspan="2"><div class="allftext font">Sign Up!</div></td>
		</tr>
		<tr>
			<td><input type="text" class="fu" title="juuuuub" placeholder="first name" name="fname"/></td>
			<td><input type="text" class="fu" placeholder="last name" name="lname"/></td>
		</tr>
		<tr>
			<td colspan="2"><input class="fu" type="text" placeholder="Phone number" name="pnumber"/></td>
		</tr>
		<tr>
			<td colspan="2"><input class="fu" type="password" placeholder="choose a password" name="fpass"/></td>
		</tr>
		<tr>
			<td colspan="2"><input class="fu" type="password" placeholder="comfirm password" name="spass"/></td>
		</tr>
		<tr>
			<td class="birthc">Birthday:<br />
				<select class="birth" name="day">
				<?php
				for ($i=1; $i <=31 ; $i++) {
					if ($i<10) {
					echo "<option value=".$i.">0".$i."</option>";	
					} else {
					echo "<option value=".$i.">".$i."</option>";
					}
					
				}
				?>
				</select>
			<select class="birth" name="month">
				<option value="01">January</option>
				<option value="02">February</option>
				<option value="03">March</option>
			    <option value="04">April</option>
			    <option value="05">May</option>
			    <option value="06">June</option>
			    <option value="07">July</option>
			    <option value="08">August</option>
			    <option value="09">September</option>
			    <option value="10">October</option>
			    <option value="11">November</option>
			    <option value="12">December</option>
			</select>
			<select class="birth" name="year">
				<?php for ($i = 2015; $i >= 1880; $i--){
				
				echo "<option value=".$i.">".$i."</option>";
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td><input type="button" value="sign up!" class="submitsignup"/></td>
		</tr>
	
	</table>
	<script type='text/javascript' src='ajax/register.js'></script>
	<script>

		$(".fu[name='lname']").tipsy("show");
	function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}
		function log(){
		  var x= document.forms["loginform"]["username"].value;
		  var y= document.forms["loginform"]["password"].value;
		  if(x!=="" && y!==""){
		  document.cookie="username="+x+";";
		  document.cookie="password="+y+";";
		  window.location.replace("localhost/YUGIV/index.php");
		  }
		}
		function reg(){
		  var x= document.forms["regisform"]["one"].value;
		  var y= document.forms["regisform"]["two"].value;
		  var z= document.forms["regisform"]["three"].value;
		  var w= document.forms["regisform"]["four"].value;
		  var t= document.forms["regisform"]["five"].value;
		  var u= document.forms["regisform"]["year"].value;
		  var str= x+y;
		  var res = str.toLowerCase(); 
		  if(x!=="" && y!=="" && z!=="" && w!=="" && t!=="" && t===w && u<=2005){
		  document.cookie="username="+res+";";
		  document.cookie="password="+t+";";
		  
		  }
		}
	</script>
	</body>
</html>