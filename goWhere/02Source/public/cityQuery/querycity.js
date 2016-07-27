(function($){
    $.querycity = function(input,options){
        var input = $(input);
        input.attr('autocomplete','off');
        if($.trim(input.val())=='' || $.trim(input.val())==options.defaultText){ 
            input.val(options.defaultText);
        }
        var t_pop_focus = false;
        var t_suggest_focus = false;
        var t_suggest_page_click = false;
        $('body').append("<div id='pop_city_"+input.attr('id')+"' class='pop_city' style='display:none'><p class='pop_head'></p><ul class='list_label'></ul><div class='pop_city_container'></div></div>");
        $('body').append("<div id='suggest_city_"+input.attr('id')+"' class='list_city' style='display:none'><div class='list_city_head'></div><div class='list_city_container'></div><div class='page_break'></div></div>");
        var popMain = $("#pop_city_"+input.attr('id'));
        var popContainer = popMain.find('.pop_city_container');
        var labelMain = popMain.find('.list_label');
        var suggestMain = $("#suggest_city_"+input.attr('id'));
        popInit();
        resetPosition(); 	    
        
        $(window).resize(function(){
            resetPosition();
        });        
        
        input.focus(function(){
            if(t_suggest_page_click){
                t_suggest_page_click = false;
                return true;
            }
            suggestMain.hide();
		    if($.trim($(this).val())==options.defaultText){
			    $(this).val('');
	    	}
		    popMain.show();
        }).click(function(){		
            if(t_suggest_page_click){
                t_suggest_page_click = false;
                return;
            }
            suggestMain.hide();
		    popMain.show();		
	    }).blur(function(){				
		    if(t_pop_focus == false){
			    popMain.hide();				
			    if($.trim(input.val())=='' || $.trim(input.val())==options.defaultText){				
				    input.val(options.defaultText);
			    }
		    }
	    });
        labelMain.find('a').on('click',function(){
		    input.focus();//使焦点在输入框，避免blur事件无法触发
		    t_pop_focus = true;
		    var labelId = $(this).attr('id');
		    labelMain.find('li a').removeClass('current');
		    $(this).addClass('current');
		    popContainer.find('ul').hide();
		    $("#"+labelId+'_container').show();
	    });
	    popContainer.find('a').on('click',function(){
        var _val = $(this).attr("data-val");
		    input.val($(this).html()).attr("data-cid",_val);
		    popMain.hide();
	    });
	    popMain.mouseover(function(){	
		    t_pop_focus = true;
	    }).mouseleave(function(){
		    t_pop_focus = false;
	    });

        input.blur(function(){
		    if( t_suggest_focus == false ){
          $(this).val( suggestMain.find('.list_city_container a.selected').children('span').text())
                 .attr("data-val",suggestMain.find('.list_city_container a.selected').attr("data-val"));
          suggestMain.hide();
		    }
        }).keydown(function(event){
            popMain.hide();
    		event = window.event || event;
	    	var keyCode = event.keyCode || event.which || event.charCode;		
		    if (keyCode == 37) {//左
                prevPage();    
            } else if (keyCode == 39) {//右
                nextPage();
            }else if(keyCode == 38){//上
                prevResult();
            }else if(keyCode == 40){//下
                 nextResult();
            }
    	}).keypress(function(event){
            event = window.event || event;
            var keyCode = event.keyCode || event.which || event.charCode;
            if(13 == keyCode){
                if(suggestMain.find('.list_city_container a.selected').length > 0){
                    input.val(suggestMain.find('.list_city_container a.selected').children('span').text());
                    suggestMain.hide();
                }
            }
        }).keyup(function(event){
            event = window.event || event;
            var keyCode = event.keyCode || event.which || event.charCode;        
            if(keyCode != 13 && keyCode != 37 && keyCode != 39 && keyCode !=9 && keyCode !=38 && keyCode !=40 ){
			    //keyCode == 9是tab切换键
                queryCity();
              setTopSelect();
            }
        });
      
        $(document).on('click', '.list_city_container a',function(){
            input.val($(this).children('span').text()).attr("data-val",$(this).attr("data-val"));
            suggestMain.hide();
        }).on('mouseover','.list_city_container a',function(){
            t_suggest_focus = true;        
        }).on('mouseleave','.list_city_container a',function(){
            t_suggest_focus = false;
        });
      $(document).on('mouseover','.page_break a',function(){
        t_suggest_focus = true;
      }).on('mouseleave','.page_break a',function(){
        t_suggest_focus = false;
      }).on('click','.page_break a',function(){
            t_suggest_page_click = true;
		    if($(this).attr('inum') != null){
			    setAddPage($(this).attr('inum'));
    		}
	    });

        function nextPage(){
              var add_cur= suggestMain.find(".page_break a.current").next();
                if (add_cur != null) {                
                    if ($(add_cur).attr("inum") != null) {
                        setAddPage($(add_cur).attr("inum"));
                    }
                }
        }
        function prevPage(){
                var add_cur = suggestMain.find(".page_break a.current").prev();
                if (add_cur != null) {
                    if ($(add_cur).attr("inum") != null) {
                        setAddPage($(add_cur).attr("inum"));
                    }
                }
        }
        function nextResult(){
                  var t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a.selected')[0]);
                    suggestMain.find('.list_city_container').children().removeClass('selected');          
                    t_index += 1;
                    var t_end =  suggestMain.find('.list_city_container a').index( suggestMain.find('.list_city_container a:visible').filter(':last')[0]);
                    if(t_index > t_end ){
                        t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a:visible').eq(0));
                    } 
                    suggestMain.find('.list_city_container a').eq(t_index).addClass('selected'); 
        }
        function prevResult(){
                 
                     var t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a.selected')[0]);
                suggestMain.find('.list_city_container').children().removeClass('selected');
                t_index -= 1;
                var t_start = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a:visible').filter(':first')[0]);
                if( t_index < t_start){
                    t_index = suggestMain.find('.list_city_container a').index(suggestMain.find('.list_city_container a:visible').filter(':last')[0]);
                }
                suggestMain.find('.list_city_container a').eq(t_index).addClass('selected');      
        }
    	function loadCity(){		
	    	var cityList = suggestMain.find('.list_city_container');		
		    cityList.empty();
            if(options.hotList){
                var hotList = options.hotList;
            }else{
                var hotList = [0,1,2,3,4,5,6,7,8,9];
            }
	    	for(var item in hotList){
			    if(item>options.suggestLength){
				    return;
			    }
			    var _data = options.data[hotList[item]];
	    		cityList.append("<a href='javascript:void(0)' data-val=" + _data[0] + "><span>"+_data[2]+"</span><b>"+_data[1]+"</b></a>");
		    }		
    		suggestMain.find('.list_city_head').html(options.suggestTitleText);
            setAddPage(1);
	    	suggestMain.show();
		    setTopSelect();
	    }
    	function queryCity(){
            popMain.hide();
            var value = input.val().toLowerCase();
            if( value.length == 0){
                loadCity();
                return; 
            }
            var city_container = suggestMain.find('.list_city_container');        
		    var isHave = false;
            var _tmp = new Array();
            for(var item in options.data){			
                var _data = options.data[item];		
                if(typeof (_data) != 'undefined'){
                    if(_data[2].indexOf(value) >= 0 || _data[3].indexOf(value) >= 0 || _data[1].indexOf(value) >=0 || _data[0].indexOf(value) >=0 ){					                   
                        isHave = true;
                        _tmp.push(_data);
                    }
                }
             }
		    if(isHave){
                city_container.empty();
                for(var item in _tmp){
                var _data= _tmp[item];
                city_container.append("<a href='javascript:void(0)' style='display:none' data-val=" + _data[0] + "><span>"+_data[2]+"</span><b>"+     _data[1] +"</b></a>");
                }
			    suggestMain.find('.list_city_head').html(value+",按拼音排序");
                setAddPage(1);
                setTopSelect()
    		}else{
	    		suggestMain.find('.list_city_head').html("<span class='msg'>对不起,找不到"+value+"</span>");
		    }
            suggestMain.show();
	    }
        function setAddPage(pageIndex){
            suggestMain.find('.list_city_container a').removeClass('selected');
            suggestMain.find('.list_city_container').children().each(function(i){			
                var k = i+1;
                if(k> options.suggestLength*(pageIndex-1) && k <= options.suggestLength*pageIndex){
                    $(this).css('display','block');
                }else{
                    $(this).hide();    
                }
             });
            setTopSelect();
            setAddPageHtml(pageIndex);
        }
        function setAddPageHtml(pageIndex){
            var cityPageBreak = suggestMain.find('.page_break');
            cityPageBreak.empty();	
            if(suggestMain.find('.list_city_container').children().length > options.suggestLength){
                var pageBreakSize = Math.ceil(suggestMain.find('.list_city_container').children().length/options.suggestLength);	
    			if(pageBreakSize <= 1){
	    			return;
		    	}			
                var start = end = pageIndex;
                for(var index = 0 ,num = 1 ; index < options.pageLength && num < options.pageLength; index++){
                    if(start > 1){
                        start--;num++;
                    }
                    if(end<pageBreakSize){
                        end ++;num++;
                    }
                }
                if(pageIndex > 1){
                    cityPageBreak.append("<a href='javascript:void(0)' inum='"+(pageIndex-1)+"'>&lt;-</a>");
                }	
                for(var i=start;i<=end;i++){
                    if(i == pageIndex){
                        cityPageBreak.append("<a href='javascript:void(0)' class='current' inum='"+(i)+"'>"+(i)+"</a");
                    }else{
                        cityPageBreak.append("<a href='javascript:void(0)' inum='"+(i)+"'>"+(i)+"</a");
                    }        
             }         
			    if (pageIndex<pageBreakSize) {
                    cityPageBreak.append("<a href='javascript:void(0);' inum='"+ (i-1) +"'>-&gt;</a>");
                }
                cityPageBreak.show();           
            }else{
                cityPageBreak.hide();    
            }
	    	return;
        }
	    function setTopSelect(){		
		    if(suggestMain.find('.list_city_container').children().length > 0 ){
			    suggestMain.find('.list_city_container').children(':visible').eq(0).addClass('selected');
		    }
	    }
        function onSelect(){
            if( typeof options.onSelect == 'function'){
                alert(1);
            }
        }
        function popInit(){
            var index = 0;
            popMain.find('.pop_head').html(options.popTitleText);
            if(!options.tabs){
                popContainer.append("<ul id='label_"+input.attr('id')+"_container' class='current'></ul>");
                labelMain.remove();
                for( var item in options.data){
                      $("#label_"+input.attr('id')+"_container").append("<li><a href='javascript:void(0)'>"+options.data[item][1]+"</a></li>");
                }
                return;
            }
    		for(var itemLabel in options.tabs){
			    index++;
			    if(index == 1){
				    popContainer.append("<ul id='label_"+input.attr('id')+index+"_container' class='current clear' data-type='"+itemLabel+"'></ul>");
				    labelMain.append("<li><a id='label_"+input.attr('id')+index+"' class='current' href='javascript:void(0)'>"+itemLabel+"</a></li>");
			    }else{
				    popContainer.append("<ul style='display:none' id='label_"+input.attr('id')+index+"_container' class='clear' data-type='"+itemLabel+"'></ul>");
				    labelMain.append("<li><a id='label_"+input.attr('id')+index+"' href='javascript:void(0)'>"+itemLabel+"</a></li>");
			    }
			    for(var item in options.tabs[itemLabel]){
				    var cityCode = options.tabs[itemLabel][item];
				    if(!options.data[cityCode]){
					    break;
    			    }
				    $("#label_"+input.attr('id')+index+"_container").append("<li><a data-val=" + options.data[cityCode][0] + " title=" + options.data[cityCode][2] + " href='javascript:void(0)'>"+options.data[cityCode][2]+"</a></li>");
			    }
		    }
        }
        function resetPosition(){
            popMain.css({'top':input.offset().top+input.outerHeight(),'left':input.offset().left});
            suggestMain.css({'top':input.offset().top+input.outerHeight(),'left':input.offset().left});
        }
    };
    $.fn.querycity = function(options){
        var defaults = {
            'data'          : {},
            'tabs'          : '',
            'hotList'       : '',            
            'defaultText'   : '中文/拼音',
            'popTitleText'  : '请选择城市或输入城市名称的拼音或英文',
            'suggestTitleText' : '输入中文/拼音或↑↓选择',
            'suggestLength' : 10,
            'pageLength'    : 5, 
            'onSelect'      : '' 
        };
        var options = $.extend(defaults,options);
        this.each(function(){
            new $.querycity(this,options);            
        });
        return this;
    };
})(jQuery);

