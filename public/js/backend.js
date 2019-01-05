$(function(){
    $(".ajax").on("click",function(){
        if(confirm("确定要进行该操作？")){
            var id = $(this).attr("value")
            var url = $(this).attr("href")
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                type : "POST",
                url : url,
                data : {"id":id},
                success : function(re){
                    switch(re){
                        case "0":
                            alert("找不到该记录")
                            break;
                        case "1":
                            alert("操作完成")
                            location.reload()
                            break;
                        case "2":
                            alert("操作失败，请稍后再试")
                            break;
                    }
                },
                error : function(data){
                    alert("服务器无响应，请稍后再试")
                }
            });
        }
        return false;
    });
});