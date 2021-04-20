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
			});	
			if (idleTime == 0) { 	
				$.post('islog.php', {myname: myname, status: 0}, function(data){	
				});
   			 }
			idleTime = idleTime + 1;
		};

		setInterval(getData,1000);
		
		chatWithUser = (e) => {
			var id=$(this).attr('id');
				console.log(id);
		}

		$('.users').on("click", chatWithUser);
	});
	
