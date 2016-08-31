function cEditable(obj){
  var color = {sending:"#FFCBCB",idle:"#fff"};
  obj.style.backgroundColor = color.sending;
  var data = obj.getAttribute('data-cEditable');
  data = JSON.parse(data);

  $.ajax({
    url:data.url,
    type:"post",
    data:{data:data,value:$(obj).val()},
    headers: {
        "X-CSRF-TOKEN" : data.csrf
    },
    dataType:"json",
    success:function(e){
        if(e.status == 1){
            obj.style.backgroundColor = color.idle;
        }else{
            alert(e.msg);
        }

    }
  });
}