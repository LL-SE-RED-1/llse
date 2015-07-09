/// <reference path="../typings/jquery/jquery.d.ts"/>
//根据scrollbar 调整table head的宽度
$(document).ready(function(){
	var a = $(".m-tmain"), b = $(".m-thead");
	if (!!a[0] && a[0].scrollHeight > a.innerHeight()){
	  b.addClass("scroll");
	}
});

//上传文件组建
//settring{desfunc:"", onloaded:function(){}, appendData:function(){}} 目标控制器函数
var uploaderInit = function (setting){
	var finput = $("#in-fileupload"), form = $("#form-upload"), 
		overlay = $(".overlay"), data;
	finput.change(function(e){
		$("#filename").text(finput[0].files[0].name);
		$("#filename").attr("title", finput[0].files[0].name);
		$(".overlay").fadeIn(500);
	});
	
	form.submit(function(evt){
		var xhr = null;
		evt.preventDefault();
		try {
			xhr = new XMLHttpRequest();
		} catch (error) {
			return false;
		}
		$("#cancel-btn").hide(0);
		data = new FormData();
		data.append("file", finput[0].files[0]);
		if (setting.appendData)
			setting.appendData(data);
		var progress = 0, intervalid = null;
		intervalid = setInterval(function(){
			$("#progress-bar").css("width", progress * 100 + "%");
		}, 200);
		
		xhr.open(form.attr("method"), setting.desfunc, true);
		
		xhr.addEventListener("load", function(evt){
			console.log("successfully uploaded", evt);
			progress = 1;
			$("#progress-bar").css("width", progress * 100 + "%");
			$("#success-info").show(0);
			clearInterval(intervalid);
			setTimeout(function(){
				overlay.fadeOut(500);
				setTimeout(function(){
					$("#progress-bar").css("width", "0");
					setting.onloaded(xhr.responseText);
					$("#success-info").hide(0);
					finput.val("");
				},500);
				},500
			);
			
		});
		xhr.upload.addEventListener("progress", function(evt){
			progress = evt.loaded / evt.total;
			console.log(evt);
		});
		xhr.send(data);
	});
	
	$(".overlay").click(function(e){
		$(this).fadeOut(500);
		finput.val("");
	});
	$(".upload-div").click(function(e){
		e.stopPropagation();
	});
	$("#cancel-btn").click(function(e){
		$(".overlay").fadeOut(500);
		finput.val("");
	});
	
	
	var highlightid = +location.hash.substr(1), time = 1000, int = 1000/30;
	if (highlightid){
		$(".row").each(function(i, item){
			var t = $(this);
			if (+t.data("homeworkid") == highlightid || +t.data("fileid") == highlightid){
				t.css("background-color", "rgba(240, 173, 78, 1)");
				setTimeout(function(){
					var curOp = 1;
					var tid = setInterval(function(){
						curOp -= int / time * 1;
						t.css("background-color", "rgba(240, 173, 78, " + curOp + ")");
						if (curOp < 0)
							clearInterval(tid);
					}, int);
				}, 1500);
			}
		});
	}
};

var alertMessage = function(str){
	return $('<div class="alert alert-danger" role="alert">...</div>').text(str);
};

var isValidTime = function(str, after){
	var reg = /(\d{2,4})-(\d{1,2})-(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})/, res = reg.exec(str), 
		upperbound = Date.parse("2100-1-1 00:00:00"), lowerbound = Date.parse("2015-1-1 00:00:00"), inputDate;
	if (!res)
		return false;
	if (res[1].length == 3)
		return false;
	if (res[1].length == 2)
		str = "20" + str;
	if (after)
		lowerbound = Date.now();
	inputDate = Date.parse(str);
	if (!inputDate || inputDate < lowerbound || inputDate > upperbound)
		return false;
	return inputDate;
};

var isValidScore = function(str){
	var reg = /^(\d{1,2}|100)$/;
	return reg.test(str);
};

var makeToast = function(){
	if ($("#toast").length > 0){
		return;
	}
	var toast = $(
	'<div id="toast" style="display:none">\
		<div style="display:none">\
			<span class="glyphicon glyphicon-remove"></span>\
			<p>提交成功</p>\
		</div>\
	</div>').appendTo($("body"));
	toast.show(0);
	window.showToast = function(str, fun){
		toast.find("p").text(str);
		toast.find("div").fadeIn(500);
		toast.find("span").on("click", function(){
			toast.fadeOut(500);
			setTimeout(function(){
				toast.remove();
				if (fun && typeof(fun) === "function")
					fun();
			}, 600);
		});
	};
	window.removeToast = function(){
		toast.fadeOut(500);
	};
};
