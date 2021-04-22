$(document).ready(function(){
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
				var amount = $(".chatMessages div").length;
				$(".chatMessages").html(data);	
				var countMsg = data.split('<div').length - 1;
				if(countMsg > amount) {
				$('.chatMessages').scrollTop($('.chatMessages')[0].scrollHeight);}
				});
			$.get('getusers.php', function(data){
				$(".users").html(data);
				$('.user img').on("click", chatWithUser);
			});	
			if (idleTime == 0) { 	
				$.post('islog.php', {myname: myname, status: 0}, function(data){	
				});
   			 }
			idleTime = idleTime + 1;
		};
		
		setInterval(getData,1000);
		
		chatWithUser = (e) => {
				var toUser = e.target.id;
				var plus = toUser+"x";
				if (!($('.newWindow').is('#'+ toUser +''))) {
					var newDiv = '<div id="'+ toUser +'" class="newWindow '+ plus +'"><p>X</p>'+ toUser +'<form class="private" onsubmit="return false;"><input class="mymessage '+ toUser +'" type="text"></form></div>';
					$('.chatWindows').append(newDiv);
					$('.newWindow p:first-child').on("click", function() {$(this).parent().remove()});
					
					$('.'+ plus +'').on('submit', '.private', function() {
						console.log(toUser);
						var message = $('.'+ toUser +'').val();
						console.log(message);
						$('.'+ toUser +'').val('');
						var fromUser = $("#mypage p").attr('id');
						console.log(fromUser);
						
					})
				}
				
			
		}
		
	});
	
