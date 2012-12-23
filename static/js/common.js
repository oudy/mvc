//公用命名空间
$.g=new Object;

/**
 * 生成随机数字
 */
$.g.GetRandomNum = function(Min, Max) {
    var Range = Max - Min;
    var Rand = Math.random();
    return (Min + Math.round(Rand * Range));
}
/**
 * 确定提示
 */
$.g.confirm_notice = function(notice){
	if(confirm(notice)){
	return true; 
	}else{
	return false;  
	}
}

// 设置居中浏览器  oudy
$.g.setCenterBrowse = function(obj){
	var w_h = $(window).height();
	var s_h = $(window).scrollTop(); 
	var o_h = $(obj).height(); 
	h = parseInt(w_h - o_h)/2  + s_h;
	var w_w = $(window).width();
	var o_w = $(obj).width();
	w = parseInt(w_w-o_w)/2;
	$(obj).css("top",h);
	$(obj).css("left",w);	
}

// 是否超过字数 二个英文当一个中文 by oudy
$.g.isExceedWordsLen = function(val,len) {
	var result = true;
	len = len*2;
	var byteValLen = 0;
	for (var i = 0; i < val.length; i++) {
		if(val.charCodeAt(i)>128){
			byteValLen += 2;
		}else{
			byteValLen += 1;
		} 
	}
	if(parseInt(byteValLen)>parseInt(len)){result = false;}
	return result;
}
// 截取中文 二个英文当一个中文 by oudy
$.g.countCharacters = function(val, maxnum) {
    var returnValue = '';
    var byteValLen = 0;
	maxnum = maxnum*2;
    for (var i = 0; i < val.length; i++) {
        if (val.charCodeAt(i) > 128) {
            byteValLen += 2;
        } else byteValLen += 1;

        if (byteValLen > maxnum) {
            break
        };
        var x = val.charCodeAt(i)
        n = String.fromCharCode(x);
        returnValue += n
    }
    return returnValue;
}

// 得到字符串字个数 二个英文当一个中文 by oudy
$.g.getWordsLen = function(val) {
	var byteValLen = 0;
	for (var i = 0; i < val.length; i++) {
		if(val.charCodeAt(i)>128){
			byteValLen += 2;
		}else{
			byteValLen += 1;
		} 
	}
	return Math.round(byteValLen);
}