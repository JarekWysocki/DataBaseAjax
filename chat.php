
<div class="chatContainer">
	
	<div class="chatBottom">
			<form action="#" onSubmit='return false;' id="chatForm">
					<input type="hidden" id="name" value="<?php echo $name; ?>"/>
					<input type="text" name="text" id="text" value="" placeholder="Your message" />
					<input type="file" name="file" id="myphoto">
					<input type="submit" name="submit" value="send"/>
			</form>
	</div>
	
	<div class="chatMessages">
	<div class="allmessages"></div>
	</div>
	
</div>


