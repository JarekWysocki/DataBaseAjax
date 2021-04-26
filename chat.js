$(document).ready(function(){
	var fromUser = $("#mypage p").attr('id');
	var lastid = 0;
	var idleTime = 0;
	$(document).on('submit', '#chatForm', function(){
			var text = $.trim($("#text").val());
			var name = $.trim($("#name").val());
			if(text != "") {
				$.post('ChatPoster.php', {text: text, name: name}, function(data){
					$("#text").val('');
				});
			} else {
				alert("Empty message!");
			}
		});
		$(this).mousemove(function(e){
			 idleTime = 0;
		 });
		 $(this).mousedown(function(e){
			 idleTime = 0;
		 });
		 $(this).scroll(function(e){
			 idleTime = 0;
		 });
		 $(this).keypress(function(e){
			 idleTime = 0;
		 });
		 $(this).keydown(function(e){
			 idleTime = 0;
		 });
		 $(this).click(function(e){
			 idleTime = 0;
		 });
		getData = () => {
			var myname = $("#mypage p").html().slice(6);
			$.get('GetMessages.php', function(data){
				$(".chatMessages").html(data);	
				});	
			$.get('getusers.php', function(data){
				$(".users").html(data);
				$('.user img').on("click", chatWithUser);
			});	
			$.post('newmessage.php', {fromUser: fromUser}, function(data){		
				if (lastid != data) {
					if (lastid !=0) {
					var callid = data.split(',');
					chatWithUser(null, callid[1]);
				}}
				lastid = data;
			});
			if (idleTime == 0) { 	
				$.post('islog.php', {myname: myname, status: 0}, function(data){	
				});
   			 }
			idleTime = idleTime + 1;
		};
		
		setInterval(getData,1000);
		
		chatWithUser = (e, data) => {
			if (data == undefined) {
			var person = e.target.nextElementSibling.firstChild.data;
			var toUser = e.target.id;
			}
			else {
			var toUser = data;
			var persons = jQuery(".user img[id]");
			persons.each(function() {
				if (toUser == (jQuery(this).attr('id'))){
					person = jQuery(this).next().text();
				}
			});
			
			}
			var plus = toUser+"x";
				if ((!($('.newWindow').is('#'+ toUser +''))) && toUser != fromUser) {
					var newDiv = '<div id="'+ toUser +'" class="newWindow '+ plus +'"><p>x </p><p>'+ person +'</p><div></div><form class="private" onsubmit="return false;"><input class="mymessage '+ toUser +'" type="text"></form></div>';
					$('.chatWindows').append(newDiv);
					var x = 0;
					var myfunction = setInterval(newmessage = () => {
						$.post('GetPrivateMessages.php', {toUser: toUser, fromUser: fromUser}, function(data){
							var amount = $("."+ plus +" p").length -1;	
							$('.'+ plus +' div').html(data);
							var countMsg = data.split('<p').length;
							if(countMsg > amount) {
								$('.'+ plus +' div').scrollTop($('.'+ plus +' div')[0].scrollHeight);
							}
						})	
					},1000);
					$('.'+ plus +' p:first-child').on("click", function() {
						clearInterval(myfunction);
						
						$(this).parent().remove()});
					$('.'+ plus +'').on('submit', '.private', function() {	
						var message = $('.'+ toUser +'').val();	
						if (message) {
							$.post('ChatPoster.php', {message: message, toUser: toUser, fromUser: fromUser}, function(data){
								$('.'+ toUser +'').val('');							
								$('.'+ plus +' div').html(data);
								$('.'+ plus +' div').scrollTop($('.'+ plus +' div')[0].scrollHeight);		
										
							});
						}
					})
				}
			
			
		}
		
	});
