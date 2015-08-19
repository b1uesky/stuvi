$(document).ready(function(){
	$('.btn').on("click",function(){
    $this = $(this)
    if($this.attr('type') === 'submit'){
      $('#loader-wrapper').show();
      $this.closest('form').on('err.form.fv',function(){
        $('#loader-wrapper').hide();
      })
    }
	});
	// $('a').on("click",function(){
	// 	if (isURL($(this).attr('href')) && $(this).attr('target') != "_blank") {
	// 		$('#loader-wrapper').show();
	// 	};
	// });
});

$(document).ajaxStart(function(){
    $('#loader-wrapper').show();
});

$(document).ajaxComplete(function(event, XMLHttpRequest, ajaxOptions){
    $('#loader-wrapper').hide();
});

function isURL(str) {
    var strRegex = "^((https|http|ftp|rtsp|mms)?://)"
        + "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@
        + "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184
        + "|" // 允许IP和DOMAIN（域名）
        + "([0-9a-z_!~*'()-]+\.)*" // 域名- www.
        + "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名
        + "[a-z]{2,6})" // first level domain- .com or .museum
        + "(:[0-9]{1,4})?" // 端口- :80
        + "((/?)|" // a slash isn't required if there is no file name
        + "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";
    var re=new RegExp(strRegex);
    return re.test(str);
}