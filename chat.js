$(document).ready(() => {
    var fromUser = $("#mypage p").attr('id');
    var lastid = 0;
    var idleTime = 0;
    var width = $(window).width();
    var heightwindow = $(window).height();
    var heightfirst = $('.first').height();
    var heightusers = $('.users').height();
    var heightchatbottom = $('.chatBottom').height();
    var n = 0;
    (width > 800) ? 
        $('.chatMessages').height(heightwindow - (heightfirst + heightchatbottom + 55))
     : 
        $('.chatMessages').height(heightwindow - (heightfirst + heightchatbottom + heightusers + 65))
    
    // adding post
    $(document).on('submit', '#chatForm', () => {
        var text = $.trim($("#text").val());
        if (text != "") {
            var formData = new FormData();
            formData.append("text", text);
            formData.append("nameid", fromUser);
            formData.append("img", $("#myphoto")[0].files[0]);
            $.ajax({
                type: "POST",
                url: "ChatPoster.php",
                data: formData,
                processData: false,
                contentType: false,
                success: (data) => {
                    $("#text").val('');
                    $('#myphoto').val('');
                    
                }
            });
        } else {
            alert("Empty message!");
        }
    });
    // adding comment
    $(document).on('submit', 'form.comments', (e) => {
        var postId = e.target.parentNode.id;
        var text = $("#" + postId + " input").val();
        $.post('newcomment.php', {
            postId: postId,
            fromUser: fromUser,
            text: text
        }, function(data) {
            $("#" + postId + " input").val('');
        });
    });
    // activity
    $(this).mousemove((e) => {
        idleTime = 0;
    });
    $(this).mousedown((e) => {
        idleTime = 0;
    });
    $(this).scroll((e) => {
        idleTime = 0;
    });
    $(this).keypress((e) => {
        idleTime = 0;
    });
    $(this).keydown((e) => {
        idleTime = 0;
    });
    $(this).click((e) => {
        idleTime = 0;
    });
    $(this).on({
        'touchstart': () => {
            idleTime = 0;
        }
    });
    // load first 4 posts

    $.ajax({
        type: "POST",
        url: "GetMessages.php",
        data: {
            'n': n
        },
    }).done((data) => {
        n += 4;
        $(".allmessages").html(data);
        $('.like').on("click", like);
        if (width > 800) {
            $('.like').on("mouseenter", wholike);
            $('.like').on("mouseleave", out);
        } else {
            $('.who').on("click", wholike);
            $(document).on("click", out);
        }
        $('.myphoto').on("click", show);
    });
    
    // load more posts after scrolling
    $('.chatMessages').scroll(()  => {
        var amountOfDiv = $('.allmessages .container').length;
        var x = n + (amountOfDiv - n);
        var heightofchat = $('.chatMessages').height();
        var tempScrollTop = $('.chatMessages').scrollTop();
        var bodyheight = $('.allmessages').height();
        if (bodyheight == heightofchat + tempScrollTop) {
            $.ajax({
                type: "POST",
                url: "scroll.php",
                data: {
                    'n': x
                },
                context: document.body
            }).done((data) => {
                n += 4;
                $(".allmessages").append(data);
                $('.like').on("click", like);
                if (width > 800) {
                    $('.like').on("mouseenter", wholike);
                    $('.like').on("mouseleave", out);
                } else {
                    $('.who').on("click", wholike);
                    $(document).on("click", out);
                }
                $('.myphoto').on("click", show);
            });
        }
    });
    // function who listen changed	
    getData = () => {
        // adding comment to post
        $('.container').each((i, obj) => {
            var amount = $("#" + obj.id + " div.comment").length;
            $.post('isnewcomment.php', {
                postId: obj.id
            }, (data) => {
                if (data > amount) {
                    var value = data - amount;
                    $.post('getnewcomment.php', {
                        postId: obj.id,
                        value: value
                    }, (dat) => {
                        $("#" + obj.id + " div.comments").append(dat);
                    });
                }
            });
        });
        //adding like to post
        $.get('getlikes.php', (data) => {
            var tableoflikes = data.split(",");
            $('.container').each((i, obj) => {
                var count = tableoflikes.filter(x => x == obj.id).length;
                if (count > 0) {
                    $("#" + obj.id + " p.who").html(count);
                }
            });
        });
        // adding post
        var myname = $("#mypage p").html().slice(6);
        $.get('getlastmessage.php', (data) => {
            var amount = $(".allmessages div:first-child").attr('id');
            if (data != amount) {
                $.post('newpost.php', {
                    amount: amount
                }, (data) => {
                    $(".allmessages").prepend('' + data + '');
                    $('.like').on("click", like);
                    if (width > 800) {
                        $('.like').on("mouseenter", wholike);
                        $('.like').on("mouseleave", out);
                    } else {
                        $('.who').on("click", wholike);
                        $(document).on("click", out);
                    }
                    $('.myphoto').on("click", show);
                });
            }
        });
        // check users + conversation
        $.get('getusers.php', (data) => {
            $(".users").html(data);
            $('.user img').on("click", chatWithUser);
        });
        // check new message	
        $.post('newmessage.php', {
            fromUser: fromUser
        }, (data) => {
            if (lastid != data) {
                if (lastid != 0) {
                    var callid = data.split(',');
                    chatWithUser(null, callid[1]);
                }
            }
            lastid = data;
        });
        // wait to new message and open window after then
        $.post('isnewmessage.php', {
            fromUser: fromUser
        }, (data) => {
            var newalert = data.split(',');
            newalert = newalert.slice(0, -1);
            var uniqueChars = [...new Set(newalert)];
            uniqueChars.forEach(e => chatWithUser(null, e));
        });
        if (idleTime == 0) {
            $.post('islog.php', {
                myname: myname
            }, (data) => {});
        }
        idleTime = idleTime + 1;
    };
    setInterval(getData, 1000);
    // private chat
    chatWithUser = (e, data) => {
        if (data == undefined) {
            var person = e.target.nextElementSibling.firstChild.data;
            var toUser = e.target.id;
        } else {
            var toUser = data;
            var persons = jQuery(".user img");
            persons.each(function() {
                if (toUser == (jQuery(this).attr('id'))) {
                    person = jQuery(this).next().text();
                }
            });
        }
        var plus = toUser + "x";
        if ((!($('.newWindow').is('#' + toUser + ''))) && toUser != fromUser) {
            var newDiv = '<div id="' + toUser + '" class="newWindow ' + plus + '"><p>x </p><p>' + person + '</p><div></div><form class="private" onsubmit="return false;"><input class="mymessage ' + toUser + '" type="text"></form></div>';
            $('.chatWindows').append(newDiv);
            $.post('GetPrivateMessages.php', {
                toUser: toUser,
                fromUser: fromUser
            }, (data) => {
                var amount = $("." + plus + " p").length - 1;
                $('.' + plus + ' div').html(data);
                var countMsg = data.split('<p').length;
                if (countMsg > amount) {
                    $('.' + plus + ' div').scrollTop($('.' + plus + ' div')[0].scrollHeight);
                }
            })
            var myfunction = setInterval(newmessage = () => {
                $.post('GetPrivateMessages.php', {
                    toUser: toUser,
                    fromUser: fromUser
                }, function(data) {
                    var amount = $("." + plus + " p").length - 1;
                    var countMsg = data.split('<p').length;
                    if (countMsg > amount) {
                        var value = countMsg - amount;
                        $.post('GetNewPrivateMessage.php', {
                    toUser: toUser,
                    fromUser: fromUser,
                    value: value,
                }, (data) => {
                    $('.' + plus + ' div').append(data);
                    $('.' + plus + ' div').scrollTop($('.' + plus + ' div')[0].scrollHeight);
                }
                        )
                    }
                })
            }, 1000);
            $('.' + plus + ' p:first-child').on("click", function() {
                clearInterval(myfunction);
                $(this).parent().remove()
            });
            $('.' + plus + '').on('submit', '.private', () => {
                var message = $('.' + toUser + '').val();
                if (message) {
                    $.post('ChatPoster.php', {
                        message: message,
                        toUser: toUser,
                        fromUser: fromUser
                    }, (data) => {
                        $('.' + toUser + '').val('');
                    });
                }
            })
        }
    }
    // give like
    like = (e) => {
        var postId = e.target.parentNode.parentNode.id;
        $.post('like.php', {
            postId: postId,
            fromUser: fromUser
        }, (data) => {
        });
    }
    // check who is like post
    wholike = (e) => {
        var postId = e.target.parentNode.parentNode.id;
        $.post('wholike.php', {
            postId: postId
        }, (data) => {
            if (data) {
                $('#' + postId + ' p.like').append('<div class="wholikes">' + data + '</div>');
            }
        });
    }
    // close window check like
    out = (e) => {
        $('.wholikes').remove();
    }
    // get likes from database
    getlikes = (e) => {
        $.get('getlikes.php', (data) => {
            var tableoflikes = data.split(",");
            $('.container').each(function(i, obj) {
                var count = tableoflikes.filter(x => x == obj.id).length;
                if (count > 0) {
                    $("#" + obj.id + " p.like").append("<p class='who'>" + count + "</p>");
                }
            });
        });
    }
    // show img in full size
    show = (e) => {
        $('.coverimg').css({
            "width": width + "px",
            "height": heightwindow + "px",
            "margin": "auto",
            "background": "black",
            "position": "absolute",
            "z-index": "100",
            "background-image": "url('" + e.target.src + "')",
            "background-size": "contain",
            "background-repeat": "no-repeat",
            "background-position": "center"
        });
        $('.coverimg').on("click", hide = (e) => {
            $('.coverimg').css("width", "0");
            $('.coverimg').css("height", "0");
        })
    }
});