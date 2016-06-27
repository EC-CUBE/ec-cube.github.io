$(function(){
    var menu = function(){
        var menu = '<dl><dt class="top"><a href="/">目次へ</a></dt>';
        var i = 1;
        return {
            getMenu : function(){
                return menu;
            },
            getNum : function(){
                return i;
            },
            setMenu : function(str){
                menu += str;
            },
            setNum : function(num){
                i += num;
            }
        }
    }

    // 文字数が15文字を超えるものに「...」を付与し返却
    function cutStr(str) {
        if(str.length > 15){
            str = str.slice(0, 15);
            return str += '...';
        }
        return str;
    }

    // 目次対象
    var $headers = $('h1, h2, h3, h4');

    var m = menu();

    // 目次対象から目次を生成
    $.each($headers, function(i, val){
        if($(val).text() != 'EC-CUBE3' && $(val).text() != 'EC open platform EC-CUBE'){
            $(val).attr('id', 'link' + i);
            var tag = $(val)[0].nodeName;
            if (tag == 'H1') {
                m.setMenu('<dl class="top">' + '<a href="#link' + i + '">' + cutStr($(val).text()) + '</a>' + '</dt>');
            } else if (tag == 'H2') {
                m.setMenu('<dt class="top-second">' + '<a href="#link' + i + '">' + cutStr($(val).text()) + '</a>' + '</dt>');
            } else if(tag == 'H3') {
                m.setMenu('<dd class="second-top">' + '<a href="#link' + i + '">' + cutStr($(val).text()) + '</a>' + '</dd>');
            } else if(tag == 'H4') {
                m.setMenu('<dd class="second-second">' + '<a href="#link' + i + '">' + cutStr($(val).text()) + '</a>' + '</dd>');
            }
        }
    });

    $('#menu').html(m.getMenu());

    // メニューが画面上部から450pxスクロールした際に、上面固定メニューにする
    $(window).scroll(function(){
      var scr_count = $(document).scrollTop();
      if(scr_count < 450){
          $('#menu').css('top', '450px')
      }else{
          $('#menu').css('top', '0px')
      }
    });
});

