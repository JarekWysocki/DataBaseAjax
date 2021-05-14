$(document).ready(function(){
	var fromUser = $("#mypage p").attr('id');
	var lastid = 0;
	var idleTime = 0;
	var width = $(window).width();
	var heightwindow = $(window).height();
	var heightfirst = $('.first').height();
	var heightusers = $('.users').height();
	var heightchatbottom = $('.chatBottom').height();
	if(width > 800) {
	$('.chatMessages').height(heightwindow - (heightfirst + heightchatbottom +55));
	}
	else {
	$('.chatMessages').height(heightwindow - (heightfirst + heightchatbottom + heightusers +65));
	}
	$(document).on('submit', '#chatForm', function(){
			var text = $.trim($("#text").val());
			if(text != "") {
				var formData = new FormData();
				formData.append("text", text);
    			formData.append("nameid", fromUser);
				formData.append("img", $("#myphoto")[0].files[0]);
				$.ajax
				({
				  type: "POST",
				  url: "ChatPoster.php",
				  data: formData,
				  processData : false,
				  contentType : false,
				  success: function (data) {
					$("#text").val('');
					$('#myphoto').val('');
				  }
				});
			} else {
				alert("Empty message!");
			}
		});
		$(document).on('submit','form.comments',function(e){
			var postId = e.target.parentNode.id;
			var text = $("#"+postId+" input").val();
			$.post('newcomment.php', {postId: postId, fromUser: fromUser, text: text}, function(data){	
				$("#"+postId+" input").val('');
			});
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
		 $(this).on({'touchstart' : function() {
			idleTime = 0;
		 }});
		 $.get('GetMessages.php', function(data){
			$(".chatMessages").html(data);
			$('.like').on("click", like);
			if(width > 800) {
			$('.like').on("mouseenter", wholike);
			$('.like').on("mouseleave", out);}
			else {
				$('.who').on("click", wholike);
				$(document).on("click", out);
			}
			});	
			
		getData = () => {
				$('.container').each(function(i, obj) {
				var amount = $("#"+ obj.id +" div.comment").length;
				$.post('isnewcomment.php', {postId: obj.id}, function(data){
					if (data > amount) {
						var value = data - amount;
						$.post('getnewcomment.php', {postId: obj.id, value: value}, function(dat){
							$("#"+obj.id+" div.comments").append(dat);
							
						});
					}
				});
			});
			$.get('getlikes.php', function(data){
				var tableoflikes = data.split(",");
				$('.container').each(function(i, obj) {
					var count = tableoflikes.filter(x => x == obj.id).length;
					if (count > 0) {
					$("#"+obj.id+" p.who").html(count);
					}
				});
			});
			var myname = $("#mypage p").html().slice(6);	
				$.get('GetMessages.php', function(data){
					var amount = $(".chatMessages div.container").length;
					var countMsg = data.split("<div class='container'").length -1;
					if (countMsg > amount) {
					var value = countMsg - amount;
					$.post('newpost.php', {value: value}, function(data){
						$(".chatMessages").prepend(''+data+'');
						$('.like').on("click", like);
						if(width > 800) {
						$('.like').on("mouseenter", wholike);
						$('.like').on("mouseleave", out);}
						else {
							$('.who').on("click", wholike);
							$(document).on("click", out);
						}
					});
					}
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
			$.post('isnewmessage.php', {fromUser: fromUser}, function(data){		
			
					var newalert = data.split(',');
					newalert = newalert.slice(0, -1);
					var uniqueChars = [...new Set(newalert)];
					uniqueChars.forEach(e => chatWithUser(null, e));
			
			});
			if (idleTime == 0) { 	
				$.post('islog.php', {myname: myname}, function(data){	
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
			var persons = jQuery(".user img");
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
							});
						}
					})
				}	
			
		}
	
		like = (e) => {
			var postId = e.target.parentNode.parentNode.id;
			$.post('like.php', {postId: postId, fromUser: fromUser}, function(data){
						
			});
		}
		wholike = (e) => {
			var postId = e.target.parentNode.parentNode.id;
			$.post('wholike.php', {postId: postId}, function(data){
				if (data) {
				$('#'+ postId +' p.like').append('<div class="wholikes">'+ data + '</div>');}		
			});
		}
		out = (e) => {
			$('.wholikes').remove();
		}
		getlikes = (e) => {
			$.get('getlikes.php', function(data){
				var tableoflikes = data.split(",");
				$('.container').each(function(i, obj) {
					var count = tableoflikes.filter(x => x == obj.id).length;
					if (count > 0) {
					$("#"+obj.id+" p.like").append("<p class='who'>"+ count +"</p>");
					}
				});
			});
		}
	});
