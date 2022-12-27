$(document).ready(function(){
    $("#live_search").keyup(function(){
      var input = $(this).val();
      // alert(input);
      if(input != ''){
        $.ajax({

          url:"livesearch.php",
          method:"post",
          data:{input:input},

          success:function(data){
            $("#searchresult").html(data);
          }
        });
      }else{
        $("#searchresult").html('');
      }
    });
    $(document).on('click','button',function(){
      $("#live_search").val($(this).text());
      $("#searchresult").html('');
    });
  });
