<?php
require 'mysql_classes.php';
$pid=(int)$_POST['pid'];
$ano= new anoInfo($pid);
$ano= $ano->array;
?>
<div id="anobox" pid="<?=$pid?>">
	<label><input type="text" id="anonymousFirst" value="<?=$ano['name']?>" disabled/></label><br />
	<label><input type="password" id="anonymousSecond"/></label><br />
	<button>submit</button>
	<script>
		$('#anobox button').on('click', function(){
			var aname=$("#anonymousFirst").val();
			var password=$("#anonymousSecond").val();
			var name= $("#anobox").attr("pid").replace(/\D/g,'');
			$.post('http://localhost/YUGIV/xml/anonymouscheck.php',{name: aname, pid: name, password:password}, function(ddata){
				if(ddata!=""){
					alert(dddata);
					if(dddata!=""){
						$('#post').attr('papassword',password);
					}
					$.magnificPopup.close();
					$( "#anobox" ).remove();
				}else{
					alert("wrong password.");
				}
		});
		});
	</script>
	<?php
		if(empty($ano)){
			echo "<script>setTimeout(function() {
		    	$.magnificPopup.close();$( '#anobox').remove();
		  	}, 2);</script>";
		}
	?>
</div>