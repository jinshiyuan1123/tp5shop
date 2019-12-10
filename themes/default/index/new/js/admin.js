if(!window["befen"]) {
	window["befen"] = {};
}

befen.spinner = '<div class="befen-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';
befen.loading = '<div class="befen-loading"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>';

$(function(){
	//console.log("befen");
});

$(document).ready(function(){
	$("div").on("scroll", function(){
		$(".layui-laydate").each(function(){
			var obj = $(this);
			if(!obj.hasClass("layui-laydate-static")) {
				obj.remove();
				obj.blur();
			}
		});
	});
});

function reload() {
	window.location.reload();
}

function gotourl(the_url) {
	window.location = the_url;
}

function getEditor(id, html) {
	var id = id ? id : "content";
	var editor;
	KindEditor.ready(function(K){
		editor = K.create("textarea[name='" + id + "']",{
			resizeType: 1,
			shadowMode: false,
			filterMode: false,
			allowFileManager: true,
			dialogAlignType: "page",
			syncType: "form",
			afterBlur: function(){
				this.sync();
			},
			items: [
				'source', '|', 'undo', 'redo', '|',
				'fontname', 'fontsize', 'forecolor', 'hilitecolor', '|', 'bold', 'italic', 'underline', 'removeformat', '|',
				'image', 'multiimage', 'flash', 'insertfile', '|', 'link', 'unlink', '|',
				'table', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertunorderedlist', 'insertorderedlist', '|',
				'code', 'about',
			]
		});
		var val = html ? html : editor.html();
		if(val) {
			editor.html(val);
			editor.sync();
		}
	});
	return editor;
}

function isFunction(method) {
	if(Object.prototype.toString.call(method) === "[object Function]") {
		return true;
	} else {
		return false;
	}
}

var layer;
function _Layer(fun) {
	if(layer) {
		isFunction(fun) && fun();
	} else {
		layui.use("layer", function(){
			layer = layui.layer;
			layer.config({
				anim: -1,
				time: 0,
				shade: 0.5,
				isOutAnim: false
			});
			isFunction(fun) && fun();
		});
	}
}

_Layer();
function init_Layer(fun) {
	_Layer(fun);
}

var index_loading = 0;
function showLoader(msg) {
	$("*").blur();
	_Layer(function(){
		if(msg) {
			index_loading = layer.msg(msg, {time:0,anim:0,shade:0.5,isOutAnim:true});
		} else {
			index_loading = layer.open({
				type: 3,
				time: 0,
				anim: -0,
				shade: 0.5,
				isOutAnim: false,
				content: befen.loading
			});
		}
	});
}

function hideLoader() {
	_Layer(function(){
		layer.close(index_loading);
	});
}

var index_info;
function showInfo(msg, fun, time) {
	$("*").blur();
	var time = time ? time : 2000;
	_Layer(function(){
		index_info = layer.msg(msg, {time:time,anim:0,shade:0.5,isOutAnim:true}, function(index){
			layer.close(index);
			isFunction(fun) && fun();
		});
	});
}

var index_alert;
function showAlert(msg, fun) {
	$("*").blur();
	_Layer(function(){
		index_alert = layer.alert(msg, {anim:0,shade:0.5,isOutAnim:true}, function(index){
			layer.close(index);
			isFunction(fun) && fun();
		});
	});
}

var index_confirm;
function showConfirm(msg, fun, cancel) {
	$("*").blur();
	_Layer(function(){
		index_confirm = layer.confirm(msg, {anim:0,shade:0.5,isOutAnim:true}, function(index){
			layer.close(index);
			isFunction(fun) && fun();
		}, function(index){
			layer.close(index);
			isFunction(cancel) && cancel();
		});
	});
}

var index_window;
function showWindow(title, the_url, area, id, skin_class) {
	$("*").blur();
	var area = area ? area : "500px";
	if(/^\d+$/.test(area)) {
		area += "px";
	}
	var skin_class = skin_class ? skin_class : "layui-window";
	$.ajax({
		type: "GET",
		dataType: "html",
		timeout: 50000,
		url: the_url,
		data: {"ajax":"html"},
		success: function(html){
			_Layer(function(){
				index_window = layer.open({
					type: 1,
					time: 0,
					anim: 0,
					shade: 0.5,
					isOutAnim: true,
					title: title,
					content: html,
					id: id,
					area: area,
					skin: skin_class,
				});
			});
		},
		error: function(html){
			showAlert("读取数据失败");
		},
		complete: function(){
			hideLoader();
		},
		beforeSend: function(){
			showLoader();
		}
	});
}

function op(action, the_url, callback) {
	showConfirm(action, function(){
		$.ajax({
			type: "POST",
			dataType: "json",
			timeout: 50000,
			url: the_url,
			data: {"ajax":"json"},
			success: function(data){
				if(data.status == "nologin") {
					showAlert(data.message, function(){
						window.location.reload();
					});
				} else if(data.status == 0) {
					showAlert(data.message);
				} else if(data.status == 1) {
					showInfo(data.message, function(){
						if(isFunction(callback)) {
							callback(data);
						} else {
							window.location.reload();
						}
					});
				}
			},
			error: function(data){
				showAlert("提交数据失败");
			},
			complete: function(){
				hideLoader();
			},
			beforeSend: function(){
				showLoader();
			}
		});
	});
}

function showDelete(the_url, callback) {
	op("确认要删除吗？", the_url, callback);
}

function submit(state, the_btn, the_form) {
	var the_btn = the_btn ? the_btn : "#submit";
	var the_form = the_form ? the_form : "#theform";
	if(state != 0) {
		showLoader();
		$(the_btn).attr("disabled", true);
	} else {
		hideLoader();
		$(the_btn).attr("disabled", false);
	}
}

function ajaxSubmit(the_btn, the_url, the_form, callback) {
	//var the_form = $(the_btn).closest("form");
	var the_btn = the_btn ? the_btn : "#submit";
	var the_form = the_form ? the_form : "#theform";
	$(the_form).ajaxForm({
		dataType: "json",
		timeout: 50000,
		data: {"ajax":"json"},
		success: function(data){
			if(data.status == "nologin") {
				showAlert(data.message, function(){
					window.location.reload();
				});
			} else if(data.status == 0) {
				showAlert(data.message);
			} else if(data.status == 1) {
				showInfo(data.message, function(){
					if(isFunction(callback)) {
						callback(data);
					} else {
						if(!the_url){
							reload();
						} else {
							gotourl(the_url);
						}
					}
				});
			}
		},
		error: function(data){
			showAlert("提交数据失败");
		},
		complete: function(){
			submit(0, the_btn, the_form);
		},
		beforeSend: function(){
			submit(1, the_btn, the_form);
		}
	});
}

function ShowTr(obj, elem) {
	var elem = elem ? elem : "#elem";
	if($(elem).css("display") == "none") {
		$(elem).show();
	} else {
		$(elem).hide();
	}
}

function Logout(the_url, location) {
	showConfirm("确认要注销吗？", function(){
		$.ajax({
			type: "GET",
			dataType: "html",
			timeout: 50000,
			url: the_url,
			data: {"ajax":"html"},
			success: function(data){
				showInfo("注销成功", function(){
					gotourl(location);
				});
			},
			error: function(data){
				showAlert("提交数据失败");
			},
			complete: function(){
				hideLoader();
			},
			beforeSend: function(){
				showLoader();
			}
		});
	});
}

function showTips(obj, msg, callback) {
	$(obj).addClass("input-warnning");
	layer.msg(msg, {anim:6,icon:2,time:2000}, function(){
		isFunction(callback) && callback();
	});
	$(obj).change(function(){
		$(this).removeClass("input-warnning");
	});
}


layui.config({
	base: '/public/layui/modules/'
});

var form;
function init_Form(object, filter) {
	if(form) {
		form.render(object, filter);
	} else {
		layui.use(["form"], function(){
			form = layui.form;
			form.render(object, filter);
		});
	}
}

var layarea;
function init_Layarea(object, callback) {
	layui.use(['layer', 'form', 'layarea'], function(){
		var layer = layui.layer;
		var form = layui.form;
		var layarea = layui.layarea;
		layarea.render({
			elem: object,
			change: function(res) {
				isFunction(callback) && callback(res);
			}
		});
	});
}

var upload;
function init_upload(option) {
	layui.use(['upload'], function(){
		upload = layui.upload;
		upload.render({
			elem: option.elem,
			field: 'file',
			url: option.url,
			size: 10240,
			accept: 'file',
			exts: option.exts,
			acceptMime: option.acceptMime,
			done: function(data, index, upload){
				item = this.item;
				hideLoader();
				isFunction(option.callback) && option.callback(item, data, index, upload);
			},
			error: function(){
				hideLoader();
			},
			before: function(){
				showLoader();
			}
		});
	});
}

/* layui_option_upload */
var option_upload = {
	elem: '',
	url: '',
	exts: '',
	acceptMime: '',
	callback: function(item, data, index, upload){
		//callback()
	}
};

/* jQuery layui laydate */

(function(jQuery){
	jQuery.fn.calendar = function(type, value, callback, done_callback, change_callback){
		var elem = this.get(0);
		var type = type ? type : "date";
		if(laydate) {
			laydate.render({
				type: type,
				elem: elem,
				trigger: "click",
				ready: function(date){
					isFunction(callback) && callback(date);
				},
				done: function(value, date, endDate){
					isFunction(done_callback) && done_callback(value, date, endDate);
				},
				change: function(value, date, endDate){
					isFunction(change_callback) && change_callback(value, date, endDate);
				}
			});
		} else {
			layui.use("laydate", function(){
				laydate = layui.laydate;
				jQuery(elem).calendar(type, value, callback, done_callback, change_callback);
			});
		}
	}
})(jQuery);

/* jQuery layui laydate */

/* jQuery layui autoComplete */

(function(jQuery){
	jQuery.fn.autoComplete = function(options, callback){
		/*
		this.each(function(){
			var _self = jQuery(this);
		});
		*/
		var _self = this;
		_self.attr("autocomplete", "off");
		_self.before('<i class="layui-edge layui-edge-autoComplete"></i>');
		var o = {};
		o.cfg = options;
		var _value = o.cfg.value;
		var min_width = 300;
		var time_limit = 500;
		var runTimer = null;
		var name_display = _self.attr("name");
		var list_template = '<span class="layui-badge layui-bg-gray">[data.field]</span>';
		var div_autoComplete = _self.next("div.autoComplete");
		if(!div_autoComplete[0]) {
			_self.after('<div class="autoComplete"></div>');
			div_autoComplete = _self.next("div.autoComplete");
		}
		var name_hidden = o.cfg.name_hidden;
		var value_hidden = o.cfg.value_hidden;
		if(name_hidden) {
			var input_autoComplete = _self.prev("input[name=" + name_hidden + "]");
			if(!input_autoComplete[0]) {
				_self.before('<input type="hidden" name="' + name_hidden + '" value="" />');
				input_autoComplete = _self.prev("input[name=" + name_hidden + "]");
			}
		}
		div_autoComplete.css("top", (_self.height() + 3) + "px");
		o.run = function(){
			if(!_self.val()) {
				o.set();
				return;
			}
			if(_value != _self.val()) {
				o.set(_self.val());
			}
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				timeout: 10000,
				url: o.cfg.url,
				data: "" + name_display + "=" + _self.val() + "",
				success: function(data){
					var dd_autoComplete = '';
					if(data.contents.list.length) {
						for (var k in data.contents.list) {
							var cur_val = "";
							if(name_hidden) {
								cur_val = data.contents.list[k][name_hidden];
							}
							var cur_txt = data.contents.list[k][name_display];
							var cur_text = cur_txt;
							if(o.cfg.field) {
								cur_text += list_template;
								cur_text = cur_text.replace('[data.field]', data.contents.list[k][o.cfg.field])
							}
							dd_autoComplete += '<dd val="' + cur_val + '" txt="' + cur_txt + '">' + cur_text + '</dd>';
						}
						div_autoComplete.html(dd_autoComplete).show();
					} else {
						div_autoComplete.html('').hide();
					}
				},
				error: function(xhr, status){
					div_autoComplete.html('').hide();
					console.log(xhr);
				},
				complete: function(){

				},
				beforeSend: function(){
					div_autoComplete.html('<dd val="" txt="">Loading...</dd>').show();
				}
			});
		}
		div_autoComplete.on("click", "dd", function(){
			o.set(jQuery(this).attr("txt"), jQuery(this).attr("val"));
		});
		o.del = function(){
			div_autoComplete.html('').hide();
		}
		o.set = function(value, value_hidden){
			o.del();
			_value = value;
			_self.val(value);
			if(name_hidden) {
				input_autoComplete.val(value_hidden);
			}
			if(isFunction(callback)) {
				callback(o, _self);
			}
		}
		o.set(o.cfg.value, o.cfg.value_hidden);
		if(!o.cfg.value && name_hidden && value_hidden) {
			jQuery.ajax({
				type: "POST",
				dataType: "json",
				timeout: 10000,
				url: o.cfg.url,
				data: "" + name_hidden + "=" + value_hidden + "",
				success: function(data){
					for (var k in data.contents.list) {
						var cur_val = data.contents.list[k][name_hidden];
						var cur_txt = data.contents.list[k][name_display];
						if(cur_val == value_hidden) {
							o.set(cur_txt, cur_val);
							break;
						}
					}
				},
			});
		}
		jQuery(document).keydown(function(event){
			if(event.keyCode == 13 || event.keyCode == 108) {
				if(_self.is(":focus")) {
					if(_value != _self.val()) {
						o.set(_self.val());
					}
					clearTimeout(runTimer), runTimer = setTimeout(function(){
						o.run();
					}, 0);
				};
				return false;
			}
		});
		_self.parent().find("i.layui-edge").click(function(){
			if(_value != _self.val()) {
				o.set(_self.val());
			}
			clearTimeout(runTimer), runTimer = setTimeout(function(){
				o.run();
			}, 0);
		});
		jQuery(document).click(function(){
			o.del();
		});
		_self.bind("blur", function(){
			//o.del();
		});
		_self.bind("focus", function(){
			if(_value != _self.val()) {
				o.set(_self.val());
				clearTimeout(runTimer), runTimer = setTimeout(function(){
					o.run();
				}, time_limit);
			}
		});
		_self.bind("input propertychange", function(){
			if(_value != _self.val()) {
				o.set(_self.val());
				clearTimeout(runTimer), runTimer = setTimeout(function(){
					o.run();
				}, time_limit);
			}
		});
		return o;
	}
})(jQuery);

/* jQuery layui autoComplete */


/* jQuery layui DetialSideShow */

(function(jQuery){
	jQuery.sideShow = function(title, the_url){
		jQuery("*").blur();
		jQuery.ajax({
			type: "GET",
			dataType: "html",
			timeout: 30000,
			url: the_url,
			data: {"ajax":"html"},
			success: function(html){
				var content = '';
				content += '<div class="side-show">';
				content += '<div class="side-head">';
				content += '<h3>' + title + '</h3>';
				content += '<a class="layui-icon layui-icon-close side-head-close" href="javascript:;"></a>';
				content += '</div>';
				content += '<div class="side-body">';
				content += html;
				content += '</div>';
				content += '</div>';
				jQuery("body").append(content);
				sideShowHeight();
				jQuery(".side-head-close").click(function(){
					jQuery(".side-show").remove();
				});
			},
			error: function(html){
				showAlert("读取数据失败");
			},
			complete: function(){
				jQuery(".side-loader").remove();
			},
			beforeSend: function(){
				jQuery("body").append('<div class="side-loader">' + befen.spinner + '</div>');
			}
		});
	}
})(jQuery);
// By Function sideShowHeight
$(function(){
	sideShowHeight();
});
// By Function sideShowHeight
$(window).resize(function(){
	sideShowHeight();
});
// By Function sideShowHeight
function sideShowHeight() {
	var _height = $(window).height() - $("#admin-header").height();
	$(".side-show .side-body").css("height", (_height + 40) + "px");
}

/* jQuery layui DetialSideShow */

