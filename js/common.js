$(function(){
    if (!$('#menu-buff').html()) {
        $.ajax({
            type: 'GET',
            url: '../index.html',
            dataType: 'html',
            success: function(data){
                $('#menu-buff').html(data);
            },
            error:function() {
                       alert('問題がありました。');
            }
        });
    }

    menu_list = '\t\t<ul>\n';
    var $menu = $('#menu-buff a');

    $.each($menu, function(i, val){
        menu_list += '\t\t\t\t<li><a href="' + $(this).attr('href') + '">' + $(this).text() + '</a></li>\n';
    });

    menu_list += '\t\t</ul>\n';

    $('#menu').html(menu_list);

    $(window).scroll(function(){ // スクロール毎にイベントが発火します。
      var scr_count = $(document).scrollTop();
      if(scr_count < 300){
          $('#menu').css('top', '300px')
      }else{
          $('#menu').css('top', '0px')
      }
    })
});
