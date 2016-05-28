$(".submitsignup").on('click', function(){
	var checker = true;
	var fname = $(".fu[name='fname']").val();
	var lname = $(".fu[name='lname']").val();
	var phone = $(".fu[name='pnumber']").val();
	var fpass = $(".fu[name='fpass']").val();
	var spass = $(".fu[name='spass']").val();
	var day = $(".birth[name='day']").val();
	var month = $(".birth[name='month']").val();
	var year = $(".birth[name='year']").val();
	if(phone.length != 10 && phone.length !=9 && phone.length != 0 && $.isNumeric(phone) == false){
		$(".fu[name='pnumber']").attr('title','please, make sure the phone number is correct!');
		$(".fu[name='pnumber']").tipsy({trigger: 'manual', gravity: 'e'});
		$(".fu[name='pnumber']").tipsy("show");
		setTimeout( function(){ 
			$(".fu[name='pnumber']").tipsy("hide");
		}  , 10000 );
		checker=false;
		$(".fu[name='pnumber']").attr('title','');
	}
	if(fname == ""){
		$(".fu[name='fname']").attr('title','please, input first name.');
		$(".fu[name='fname']").tipsy({trigger: 'manual', gravity: 'e'});
		$(".fu[name='fname']").tipsy("show");
		setTimeout( function(){ 
			$(".fu[name='fname']").tipsy("hide");
		}  , 10000 );
		checker=false;
		$(".fu[name='name']").attr('title','');
	}
	if(lname == ""){
		$(".fu[name='lname']").attr('title','please, input last name.');
		$(".fu[name='lname']").tipsy({trigger: 'manual', gravity: 'w'});
		$(".fu[name='lname']").tipsy("show");
		setTimeout( function(){ 
			$(".fu[name='lname']").tipsy("hide");
		}  , 10000 );
		checker=false;
		$(".fu[name='lname']").attr('title','');
	}
	if(fpass == ""){
		$(".fu[name='fpass']").attr('title','please, choose a password.');
		$(".fu[name='fpass']").tipsy({trigger: 'manual', gravity: 'e'});
		$(".fu[name='fpass']").tipsy("show");
		setTimeout( function(){ 
			$(".fu[name='fpass']").tipsy("hide");
		}  , 10000 );
		checker=false;
		$(".fu[name='fpass']").attr('title','');
	}
	if(spass != fpass){
		$(".fu[name='spass']").attr('title','please, make sure both passwrds are the same.');
		$(".fu[name='spass']").tipsy({trigger: 'manual', gravity: 'e'});
		$(".fu[name='spass']").tipsy("show");
		setTimeout( function(){ 
			$(".fu[name='spass']").tipsy("hide");
		}  , 10000 );
		checker=false;
		$(".fu[name='spass']").attr('title','');
	}
	if(year > 2007){
		$(".birthc").attr('title','you are too young to make an account.');
		$(".birthc").tipsy({trigger: 'manual', gravity: 'e'});
		$(".birthc").tipsy("show");
		setTimeout( function(){ 
			$(".birthc").tipsy("hide");
		}  , 10000 );
		checker=false;
		$(".birthc").attr('title','');
	}
	if(checker){
		$.post('http://localhost/YUGIV/xml/new_user_checker.php', {fname:fname,lname:lname,phone:phone,fpass:fpass,spass:spass,day:day,month:month,year:year}, function(data){
			alert(data);
			if(data == 'done'){
				window.location="http://localhost/YUGIV/";
			}else{
				alert(data);
			}
		});
	}
});