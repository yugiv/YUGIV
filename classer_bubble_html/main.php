<div id="classerbox">
	<div id="classertitle">Class by newest</div><br/>
	<table id="classertable">
		<tr>
			<td>
				load from:
			</td>
		</tr>
		<tr>
			<td width="400px">
				<table>
					<tr>
						<td width="140px">points:</td>
							<td width="170px"><input type="number" placeholder="min" class="classerfield" id="pointslimitmin" />-<input type="number" class="classerfield" placeholder="max" id="pointslimitmax" /></td>
					</tr>
					<tr>
						<td width="140px">upvotes:</td>
							<td width="80px"><input type="number" placeholder="min" class="classerfield" id="upvoteslimitmin" />-<input type="number" class="classerfield" placeholder="max" id="upvoteslimitmax" /></td>
					</tr>
					<tr>
						<td width="140px">downvotes:</td>
							<td width="80px"><input type="number" placeholder="min" class="classerfield" id="downvoteslimitmin" />-<input type="number" class="classerfield" placeholder="max" id="downvoteslimitmax" /></td>
					</tr>
				</table>
			</td>
			<?php
				if(strpos($_POST['url'], '@')){
			?>
			<td width="150px">
				<div>posts to load:</div><br />
				<label><input type="radio" id="postchoice" name="postchoice" value="all"/>all posts</label><br />
				<label><input type="radio" id="postchoice" name="postchoice" value="wall" checked/>wall only</label>
			</td>
			<?php
				}
			?>
		</tr>
		<tr>
			<td>view option:
				<ul style="list-style-type: none">
					<li>
						<label><input type="checkbox" value="globalcheck" id="globalcheckbox" checked/> global</label>
					</li>
					<li>
						<label><input type="checkbox" value="friendscheck" id="friendscheckbox" checked/> friends</label>
					</li>
					<li>
						<label><input type="checkbox" value="personalcheck" id="personalcheckbox" checked/> personal</label>
					</li>
				</ul>
			</td>
			<td>
				<button id="loadclasser" style="width: 100px; height: 40px;">
					load
				</button>
			</td>
		</tr>
	</table>
	<script>
		$('#loadclasser').on('click', function(){
			var url="";
			if($("#postchoice:checked").val()=="all"){
			url += 'postchoice=true,';
			}
			if(($("#pointslimitmin").val().length>0) || ($("#pointslimitmax").val().length>0)){
			url += 'pointscheck='+$("#pointslimitmin").val()+"_"+$("#pointslimitmax").val()+',';
			}
			if(($("#upvoteslimitmin").val().length>0) || ($("#upvoteslimitmax").val().length>0)){
			url +='upvotescheck='+$("#upvoteslimitmin").val()+"_"+$("#upvoteslimitmax").val()+',';
			}
			if(($("#downvoteslimitmin").val().length>0) || ($("#downvoteslimitmax").val().length>0)){
			url +='downvotescheck='+$("#downvoteslimitmin").val()+"_"+$("#downvoteslimitmax").val()+',';
			}
			if($("#globalcheckbox").prop('checked')==false){
			url +="global=false,";
			}
			if($("#friendscheckbox").prop('checked')==false){
				url +="friends=false,";
			}
			if($("#personalcheckbox").prop('checked')==false){
				url +="personal+false,";
			}
			if($("#personalcheckbox").prop('checked')==false&&$("#friendscheckbox").prop('checked')==false&&$("#globalcheckbox").prop('checked')==false){
				alert("at least 1 view option must be checked!");
			}else{
			window.location=getmeth("main",url);
			$.magnificPopup.close();
			$( "#classerbox" ).remove();
			}
		});
	</script>
</div>