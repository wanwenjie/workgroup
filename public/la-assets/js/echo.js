function getCookie(name)
{
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
	return unescape(arr[2]);
	else
	return null;
}

var g_id = getCookie('group_id');
echo.channel('chat-room.'+g_id)
    .listen('ChatMessageWasReceived', function (data) {



        if(u_id == data.message.user_id){
          make_msg(data);
        }else{
          make_msg(data,false);
        }


        
    });