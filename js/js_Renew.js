$(document).ready(function(){ 

    var str = $("#Cost_NEW_JS").val();
    var COSTFIX = parseInt(str);
    var oldCost = $("#CalculaCost_JS").val();
    var fixCost = ($("#CalculaCost_JS").val() - $("#Cost_NEW_JS").val())/10000;

    $(function()
    {/*
    	$("#mobile").mask("9999999999");
    	$("#mobile2").mask("9999999999");
    	$("#home").mask("999999999");
    	$("#home2").mask("999999999");
    	$("#fax").mask("999999999");
    	*/
    	var prettyDate = $("#start_date_renew").val();
    	$("#start_date_renew").datepicker({ 
    		format: "dd/mm/yyyy",
    		//startDate: "today",
    		language: "th",
    		autoclose: true,
    		minDate: prettyDate
    	});
    });
	
	$("#doc_type_select").change(function()
	{ 
		var ObjectDocType = $("#doc_type_select").val();
		if(ObjectDocType=='1')
		{
			$("#service").empty();
			$("#service").append("<option value=''>กรุณาเลือก</option>");
			$("#service").append("<option value='1'>ซ่อมห้าง</option>");
			$("#service").append("<option value='2'>ซ่อมอู่</option>");

            $("#tun").empty();
            for(ss=3;ss>0;ss--)
            {
                if(ss == 3)
                { 
                    $("#tun").append("<option value='"+parseInt(COSTFIX)+"'>"+addCommas(parseInt(COSTFIX))+"</option>");
                }
                else
                {
                    $("#tun").append("<option value='"+parseInt(COSTFIX-(10000*ss))+"'>"+addCommas(parseInt(COSTFIX-(10000*ss)))+"</option>");
                }
            }
		}
		else if(ObjectDocType=='2+')
		{
			$("#service").empty();
			$("#service").append("<option value=''>กรุณาเลือก</option>");
			$("#service").append("<option value='2'>ซ่อมอู่</option>");
            
            $("#tun").empty();
            $("#tun").append("<option value='100000'>100000</option>");
            $("#tun").append("<option value='200000'>200000</option>");
            $("#tun").append("<option value='300000'>300000</option>");
		}
        else if(ObjectDocType=='3+')
        {
            $("#service").empty();
            $("#service").append("<option value=''>กรุณาเลือก</option>");
            $("#service").append("<option value='2'>ซ่อมอู่</option>");

            $("#tun").empty();
            $("#tun").append("<option value='100000'>100000</option>");
            $("#tun").append("<option value='200000'>200000</option>");
        }
		else
		{
			$("#service").empty();
			$("#service").append("<option value=''>กรุณาเลือก</option>");
			$("#service").append("<option value='1'>ซ่อมห้าง</option>");
			$("#service").append("<option value='2'>ซ่อมอู่</option>");
		}    
	});
	
	$("#car_regis_select").change(function()
	{ 
		var Objectre = $("#car_regis_select").val();
		if(Objectre=='F')
		{
			$("#renew_car_regis_recheck").show('fast');
		}
		else
		{
			$("#renew_car_regis_recheck").hide('fast');
		}    
	});
	
	$("#bill_pay").change(function()
	{ 
		var ObjectC = $("#bill_pay").val();
		if(ObjectC=='')
		{
			$("#installment").hide('fast');
			$("#installment2").hide('fast');
			$("#text_pay").hide('fast');
            calcfunc(undefined);
			$('#dis_sv').val(addCommas(0.00.toFixed(2)));
		}
		else 	if(ObjectC==1)
		{
			$("#installment").hide('fast');
			$("#installment2").hide('fast');
			$("#text_pay").hide('fast');
            calcfunc(undefined);
			$('#dis_sv').val(addCommas(0.00.toFixed(2)));
		}
		else 	if(ObjectC==2)
		{
			$("#installment").show('fast');
			$("#installment2").show('fast');
			
			$("#1").show('fast');
			$("#3").show('fast');
			$("#6").show('fast');
			
			$("#A1").hide('fast');
			$("#A2").hide('fast');
			
			$("#text_pay").hide('fast');
            $('#pay_amount').val('');
            $('#pay_amount').change();
		}
		else 	if(ObjectC==3)
		{
			$("#installment").show('fast');
			$("#installment2").show('fast');
			
			$("#1").hide('fast');
			$("#3").hide('fast');
			$("#6").hide('fast');
			
			$("#A1").show('fast');
			$("#A2").show('fast');
            
			$("#text_pay").hide('fast');
            $('#pay_amount').val('');
            $('#pay_amount').change();
		}
        
	});
});

(function ($) {
    "use strict";
    if (!$.browser) {
        $.browser = {};
        $.browser.mozilla = /mozilla/.test(navigator.userAgent.toLowerCase()) && !/webkit/.test(navigator.userAgent.toLowerCase());
        $.browser.webkit = /webkit/.test(navigator.userAgent.toLowerCase());
        $.browser.opera = /opera/.test(navigator.userAgent.toLowerCase());
        $.browser.msie = /msie/.test(navigator.userAgent.toLowerCase());
    }

    var methods = {
        destroy : function () {
            $(this).unbind(".maskMoney");

            if ($.browser.msie) {
                this.onpaste = null;
            }
            return this;
        },

        mask : function (value) {
            return this.each(function () {
                var $this = $(this);
                if (typeof value === "number") {
                    $this.val(value);
                }
                return $this.trigger("mask");
            });
        },

        unmasked : function () {
            return this.map(function () {
                var value = ($(this).val() || "0"),
                    isNegative = value.indexOf("-") !== -1,
                    decimalPart;
                // get the last position of the array that is a number(coercion makes "" to be evaluated as false)
                $(value.split(/\D/).reverse()).each(function (index, element) {
                    if(element) {
                        decimalPart = element;
                        return false;
                   }
                });
                value = value.replace(/\D/g, "");
                value = value.replace(new RegExp(decimalPart + "$"), "." + decimalPart);
                if (isNegative) {
                    value = "-" + value;
                }
                return parseFloat(value);
            });
        },

        init : function (parameters) {
            parameters = $.extend({
                prefix: "",
                suffix: "",
                affixesStay: true,
                thousands: ",",
                decimal: ".",
                precision: 2,
                allowZero: false,
                allowNegative: false
            }, parameters);

            return this.each(function () {
                var $input = $(this), settings,
                    onFocusValue;

                // data-* api
                settings = $.extend({}, parameters);
                settings = $.extend(settings, $input.data());

                function getInputSelection() {
                    var el = $input.get(0),
                        start = 0,
                        end = 0,
                        normalizedValue,
                        range,
                        textInputRange,
                        len,
                        endRange;

                    if (typeof el.selectionStart === "number" && typeof el.selectionEnd === "number") {
                        start = el.selectionStart;
                        end = el.selectionEnd;
                    } else {
                        range = document.selection.createRange();

                        if (range && range.parentElement() === el) {
                            len = el.value.length;
                            normalizedValue = el.value.replace(/\r\n/g, "\n");

                            // Create a working TextRange that lives only in the input
                            textInputRange = el.createTextRange();
                            textInputRange.moveToBookmark(range.getBookmark());

                            // Check if the start and end of the selection are at the very end
                            // of the input, since moveStart/moveEnd doesn't return what we want
                            // in those cases
                            endRange = el.createTextRange();
                            endRange.collapse(false);

                            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1) {
                                start = end = len;
                            } else {
                                start = -textInputRange.moveStart("character", -len);
                                start += normalizedValue.slice(0, start).split("\n").length - 1;

                                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1) {
                                    end = len;
                                } else {
                                    end = -textInputRange.moveEnd("character", -len);
                                    end += normalizedValue.slice(0, end).split("\n").length - 1;
                                }
                            }
                        }
                    }

                    return {
                        start: start,
                        end: end
                    };
                } // getInputSelection

                function canInputMoreNumbers() {
                    var haventReachedMaxLength = !($input.val().length >= $input.attr("maxlength") && $input.attr("maxlength") >= 0),
                        selection = getInputSelection(),
                        start = selection.start,
                        end = selection.end,
                        haveNumberSelected = (selection.start !== selection.end && $input.val().substring(start, end).match(/\d/)) ? true : false,
                        startWithZero = ($input.val().substring(0, 1) === "0");
                    return haventReachedMaxLength || haveNumberSelected || startWithZero;
                }

                function setCursorPosition(pos) {
                    $input.each(function (index, elem) {
                        if (elem.setSelectionRange) {
                            elem.focus();
                            elem.setSelectionRange(pos, pos);
                        } else if (elem.createTextRange) {
                            var range = elem.createTextRange();
                            range.collapse(true);
                            range.moveEnd("character", pos);
                            range.moveStart("character", pos);
                            range.select();
                        }
                    });
                }

                function setSymbol(value) {
                    var operator = "";
                    if (value.indexOf("-") > -1) {
                        value = value.replace("-", "");
                        operator = "-";
                    }
                    return operator + settings.prefix + value + settings.suffix;
                }

                function maskValue(value) {
                    var negative = (value.indexOf("-") > -1 && settings.allowNegative) ? "-" : "",
                        onlyNumbers = value.replace(/[^0-9]/g, ""),
                        integerPart = onlyNumbers.slice(0, onlyNumbers.length - settings.precision),
                        newValue,
                        decimalPart,
                        leadingZeros;

                    // remove initial zeros
                    integerPart = integerPart.replace(/^0*/g, "");
                    // put settings.thousands every 3 chars
                    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, settings.thousands);
                    if (integerPart === "") {
                        integerPart = "0";
                    }
                    newValue = negative + integerPart;

                    if (settings.precision > 0) {
                        decimalPart = onlyNumbers.slice(onlyNumbers.length - settings.precision);
                        leadingZeros = new Array((settings.precision + 1) - decimalPart.length).join(0);
                        newValue += settings.decimal + leadingZeros + decimalPart;
                    }
                    return setSymbol(newValue);
                }


                function maskAndPosition(startPos) {
                    var originalLen = $input.val().length,
                        newLen;
                    $input.val(maskValue($input.val()));
                    newLen = $input.val().length;
                    startPos = startPos - (originalLen - newLen);
                    setCursorPosition(startPos);
                }

                function mask() {
                    var value = $input.val();
                    if (settings.precision > 0 && value.indexOf(settings.decimal) < 0) {
                        value += settings.decimal + new Array(settings.precision+1).join(0);
                    }
                    $input.val(maskValue(value));
                }

                function changeSign() {
                    var inputValue = $input.val();
                    if (settings.allowNegative) {
                        if (inputValue !== "" && inputValue.charAt(0) === "-") {
                            return inputValue.replace("-", "");
                        } else {
                            return "-" + inputValue;
                        }
                    } else {
                        return inputValue;
                    }
                }

                function preventDefault(e) {
                    if (e.preventDefault) { //standard browsers
                        e.preventDefault();
                    } else { // old internet explorer
                        e.returnValue = false;
                    }
                }

                function keypressEvent(e) {
                    e = e || window.event;
                    var key = e.which || e.charCode || e.keyCode,
                        keyPressedChar,
                        selection,
                        startPos,
                        endPos,
                        value;
                    //added to handle an IE "special" event
                    if (key === undefined) {
                        return false;
                    }

                    // any key except the numbers 0-9
                    if (key < 48 || key > 57) {
                        // -(minus) key
                        if (key === 45) {
                            $input.val(changeSign());
                            return false;
                        // +(plus) key
                        } else if (key === 43) {
                            $input.val($input.val().replace("-", ""));
                            return false;
                        // enter key or tab key
                        } else if (key === 13 || key === 9) {
                            return true;
                        } else if ($.browser.mozilla && (key === 37 || key === 39) && e.charCode === 0) {
                            // needed for left arrow key or right arrow key with firefox
                            // the charCode part is to avoid allowing "%"(e.charCode 0, e.keyCode 37)
                            return true;
                        } else { // any other key with keycode less than 48 and greater than 57
                            preventDefault(e);
                            return true;
                        }
                    } else if (!canInputMoreNumbers()) {
                        return false;
                    } else {
                        preventDefault(e);

                        keyPressedChar = String.fromCharCode(key);
                        selection = getInputSelection();
                        startPos = selection.start;
                        endPos = selection.end;
                        value = $input.val();
                        $input.val(value.substring(0, startPos) + keyPressedChar + value.substring(endPos, value.length));
                        maskAndPosition(startPos + 1);
                        return false;
                    }
                }

                function keydownEvent(e) {
                    e = e || window.event;
                    var key = e.which || e.charCode || e.keyCode,
                        selection,
                        startPos,
                        endPos,
                        value,
                        lastNumber;
                    //needed to handle an IE "special" event
                    if (key === undefined) {
                        return false;
                    }

                    selection = getInputSelection();
                    startPos = selection.start;
                    endPos = selection.end;

                    if (key === 8 || key === 46 || key === 63272) { // backspace or delete key (with special case for safari)
                        preventDefault(e);

                        value = $input.val();
                        // not a selection
                        if (startPos === endPos) {
                            // backspace
                            if (key === 8) {
                                if (settings.suffix === "") {
                                    startPos -= 1;
                                } else {
                                    // needed to find the position of the last number to be erased
                                    lastNumber = value.split("").reverse().join("").search(/\d/);
                                    startPos = value.length - lastNumber - 1;
                                    endPos = startPos + 1;
                                }
                            //delete
                            } else {
                                endPos += 1;
                            }
                        }

                        $input.val(value.substring(0, startPos) + value.substring(endPos, value.length));

                        maskAndPosition(startPos);
                        return false;
                    } else if (key === 9) { // tab key
                        return true;
                    } else { // any other key
                        return true;
                    }
                }

                function focusEvent() {
                    onFocusValue = $input.val();
                    mask();
                    var input = $input.get(0),
                        textRange;
                    if (input.createTextRange) {
                        textRange = input.createTextRange();
                        textRange.collapse(false); // set the cursor at the end of the input
                        textRange.select();
                    }
                }

                function cutPasteEvent() {
                    setTimeout(function() {
                        mask();
                    }, 0);
                }

                function getDefaultMask() {
                    var n = parseFloat("0") / Math.pow(10, settings.precision);
                    return (n.toFixed(settings.precision)).replace(new RegExp("\\.", "g"), settings.decimal);
                }

                function blurEvent(e) {
                    if ($.browser.msie) {
                        keypressEvent(e);
                    }

                    if ($input.val() === "" || $input.val() === setSymbol(getDefaultMask())) {
                        if (!settings.allowZero) {
                            $input.val("");
                        } else if (!settings.affixesStay) {
                            $input.val(getDefaultMask());
                        } else {
                            $input.val(setSymbol(getDefaultMask()));
                        }
                    } else {
                        if (!settings.affixesStay) {
                            var newValue = $input.val().replace(settings.prefix, "").replace(settings.suffix, "");
                            $input.val(newValue);
                        }
                    }
                    if ($input.val() !== onFocusValue) {
                        $input.change();
                    }
                }

                function clickEvent() {
                    var input = $input.get(0),
                        length;
                    if (input.setSelectionRange) {
                        length = $input.val().length;
                        input.setSelectionRange(length, length);
                    } else {
                        $input.val($input.val());
                    }
                }

                $input.unbind(".maskMoney");
                $input.bind("keypress.maskMoney", keypressEvent);
                $input.bind("keydown.maskMoney", keydownEvent);
                $input.bind("blur.maskMoney", blurEvent);
                $input.bind("focus.maskMoney", focusEvent);
                $input.bind("click.maskMoney", clickEvent);
                $input.bind("cut.maskMoney", cutPasteEvent);
                $input.bind("paste.maskMoney", cutPasteEvent);
                $input.bind("mask.maskMoney", mask);
            });
        }
    };

    $.fn.maskMoney = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === "object" || ! method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error("Method " +  method + " does not exist on jQuery.maskMoney");
        }
    };
})(window.jQuery || window.Zepto);

$( document ).ready(function() {
	
	calcfunc();
	updateAlertsOpen();
});

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1))
	{
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function calcfunc(obj) 
{
	var all = $('#pre-set').val();
	if($("#doc_type_select").val() == '1')
    {
        if($('#mo_car').val() == 'CARRY')
        {
            var group = 10;
            var good = 25;
        }
        else
        {
            var group = 10;
            var good = 25;
        }
    }
    else
    {
        var group = 0;
        var good = 0;
    }
	
	
	
	var act = parseFloat($('#act').val());
	
	if(act=='645.21')
	{
		var preact = 600;
		var com_act = 108;
	}
	else if(act=='967.28')
	{
		var preact = 900;
		var com_act = 162;
	}
	else
	{
		var preact = 0;
		var com_act = 0;
		act = parseFloat(0);
	}

	var showgroup = 0;
	var showgood = 0;
	var _showgroup = $('#showgroup').val()==""?'0':$('#showgroup').val();
	var _showgood = $('#showgood').val()==""?'0':$('#showgood').val();
	var dis_count_add = $('#dis_count_add').val()==""?'0':$('#dis_count_add').val()+'';
	var _dis_count_add = dis_count_add.replace(/,/g, "");
	//.replace(/,/g, "")
	if(isNaN(_dis_count_add)) 
	{
		_dis_count_add = 0;
	}
	 else
	  {
		_dis_count_add = parseFloat(_dis_count_add);
	}
	//$('#dis_count_add').val(addCommas(_dis_count_add.toFixed(2)));

	if(obj==true)
	{
		showgroup = parseFloat(_showgroup.replace(/,/g, ""));
		showgood = parseFloat(_showgood.replace(/,/g, ""));

	} 
	else 
	{
		if(obj=='gp') 
		{
			showgroup = Math.round(parseFloat(all*group/100));
			showgood = parseFloat(_showgood.replace(/,/g, ""));
		}
		 else if(obj=='gd') 
		 {
			showgood = Math.round(parseFloat((all-(all*group/100))*good/100));
			showgroup = parseFloat(_showgroup.replace(/,/g, ""));
		}
		 else 
		 {
			showgroup = Math.round(parseFloat(all*group/100));
			showgood = Math.round(parseFloat((all-(all*group/100))*good/100));
		}
	}
	if(isNaN(showgroup)) 
	{
		showgroup = 0;
	}
	if(isNaN(showgood)) 
	{
		showgood = 0;
	}
	
	if($('#SRate_ReCheck').val() == 'S_Rate')
	{
		showgroup = 0;
		showgood = 0;
	}
	
	$('#showgroup').val(addCommas(showgroup));
	$('#showgood').val(addCommas(showgood));

//	$('#pre').val( parseFloat( all-showgroup-showgood ).toFixed(2) );
	var pre = parseFloat( all-showgroup-showgood );
	
	

//	$('#stamp').val( Math.ceil(pre * 0.4 /100) );
	var stamp = parseFloat(pre+parseFloat(Math.ceil(pre * 0.4 /100)));

	//$('#vat').val(parseFloat(( stamp * 7 /100)).toFixed(2));
	var vat = parseFloat(( stamp * 7 /100)) ;

	$('#net').val(addCommas( parseFloat(stamp+vat).toFixed(2)));
	$('#nets').val(addCommas( parseFloat(stamp+vat).toFixed(2)));
	var net = parseFloat(stamp+vat);
    
    //pay amount
    var _netact = 0.00;
    var _addcom = 0.00;

	if(act=='N')
	{  
		$('#test_text').text(addCommas( parseFloat(net).toFixed(2)));
		$('#netact').val(addCommas(parseFloat(net- _dis_count_add).toFixed(2)));
		$('#netacts').val(addCommas( parseFloat(net).toFixed(2)));
		$('#com').val(addCommas((parseFloat(pre*18/100) - _dis_count_add).toFixed(2)));
		$('#snet').val(addCommas((parseFloat((net)-((pre*18/100)))  + _dis_count_add).toFixed(2)));
        _netact = parseFloat(net);
        _addcom = parseFloat(pre*18/100) - _dis_count_add;
	}
	else
	{
		$('#test_text').text(addCommas( parseFloat(parseFloat(net)+parseFloat(act)).toFixed(2)));
		$('#netact').val(addCommas( parseFloat(parseFloat(net)+parseFloat(act)- _dis_count_add).toFixed(2)));
		$('#netacts').val(addCommas( parseFloat(parseFloat(net)+parseFloat(act)).toFixed(2)));
		// $('#com').val(addCommas((parseFloat((pre*18/100)+(preact*20/100)) - _dis_count_add).toFixed(2)));
        $('#com').val(addCommas((parseFloat(pre*18/100) - _dis_count_add + com_act).toFixed(2)));
		// $('#snet').val(addCommas((parseFloat((net+act)-((pre*18/100)+(preact*20/100))) + _dis_count_add).toFixed(2)));
        $('#snet').val(addCommas((parseFloat((net+act)-((pre*18/100)))  + _dis_count_add - com_act).toFixed(2)));
	   _netact = parseFloat(net) + parseFloat(act) - _dis_count_add;
       _addcom = parseFloat(pre*18/100) - _dis_count_add + com_act;
    }
    // pay amount
	//if(window.event.target.name == 'dis_count_add'){
		//obj = $('#pay_amount')[0];	
	//}
	var _target = window.event?window.event.target:null;
	if(_target != null && _target.name == 'dis_count_add')
	{
		obj = $('#pay_amount')[0];
	}
	else if(_target != null && _target.name == 'act' && _target.name == 'bill_pay')
	{
		obj = $('#pay_amount')[0];
	}
    if(obj !== undefined)
	{
		
        if(obj.value=='')
		{
			$("#text_pay").hide('fast')
		}
		else if(obj.value=='A1')
		{
			$("#text_pay").hide('fast')
		}
		else if(obj.value=='A2')
		{
			$("#text_pay").hide('fast')
		}
		else
		{
			$("#text_pay").show('fast')
		};
		
        var _pay_amount = obj.value===''?1:obj.value;
        var _rate_amount = _pay_amount==3?2.5:_pay_amount==6?4.5:_pay_amount=='A2'?2:0;
		var _SV_amount = (_rate_amount / 100) * _netact;
        var _plan_amount = _netact / _pay_amount;
        _addcom -= (_rate_amount / 100) * _netact;
        $('#text_pay').html('ผ่อนชำระ ' + addCommas(_plan_amount.toFixed(2)) + ' บาท เป็นจำนวน ' + _pay_amount + ' งวด (ชาร์ท ' + _rate_amount + '%)');
		$('#text_payAA').val('ผ่อนชำระ ' + addCommas(_plan_amount.toFixed(2)) + ' บาท เป็นจำนวน ' + _pay_amount + ' งวด (ชาร์ท ' + _rate_amount + '%)');
        $('#com').val(addCommas(_addcom.toFixed(2)));
        //$('#netact').val(addCommas(_plan_amount.toFixed(2)));
		$('#dis_sv').val(addCommas(_SV_amount.toFixed(2)));
		$('#snet').val(addCommas((parseFloat((net+act)-((pre*18/100)))  + _dis_count_add + _SV_amount - com_act).toFixed(2)));
    }
}

function Stun() 
     { 
         var _selected = $("#tun").val();
		 var _selected2 = $("#type").val();
		 var _selected3 = $("#service").val();
		 var _selected4 = $("#mo_car").val();
		 var _selected5 = $("#type_SRate").val();
		 var _selected6 = $("#doc_type_select").val();
         console.log(_selected6);
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_CostRe.php",
			 data: {
				doc_type_select:_selected6, 
				type_SRate:_selected5,
				mo_car:_selected4,
  			 	service:_selected3,
			 	type:_selected2,
			 	cost:_selected
			 },
             success: function(msg) {
                 var returnedArray = msg;
                 perSet = $("#pre-set");
				 Rate_ReC = $("#SRate_ReCheck");
				 if(returnedArray!=null){
					 perSet.val( returnedArray.Cost);
                     Rate_ReC.val( returnedArray.type);
					calcfunc($('#pay_amount')[0]);
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 }
/*
$("#act").empty();

if($( "#mo_car" ).val()!='CARRY')
{
	$("#act").append("<option value='0' selected='selected'>กรุณาเลือก</option>");
	$("#act").append("<option value='645.21'>645.21</option>");
	$("#act").append("<option value='N'>ไม่เอา พ.ร.บ.</option>");
}
else
{
	$("#act").append("<option value='0' selected='selected'>กรุณาเลือก</option>");
	$("#act").append("<option value='967.28'>967.28</option>");
	$("#act").append("<option value='N'>ไม่เอา พ.ร.บ.</option>");
}
*/
function Amp() 
     { 
	 $("#tumbon").empty();
		 $("#tumbon").append("<option value='0'>กรุณาเลือก</option>");
		 $("#postal").val('');
         var _selected = $("#province").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             async:false,
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'AMPHUR',
			 province:_selected
			 },
             success: function(msg) {
                $('#amphur').empty(); 
                 var returnedArray = msg;
                 state = $("#amphur");
				 state.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
                 
             }
         };
         $.ajax(options);
	 }

function Tum() 
     { 
	 	 $("#postal").val('');
         var _selected = $("#amphur").val();
         var options = 
         {
             type: "POST",
             async:false,
			 dataType: "json",
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'TUMBON',
			 amphur:_selected
			 },
             success: function(msg) {
                $('#tumbon').empty(); 
                 var returnedArray = msg;
                 state = $("#tumbon");
				 state.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 }
         
 function AAmp() 
     { 
	 $("#Atumbon").empty();
		 $("#Atumbon").append("<option value='0'>กรุณาเลือก</option>");
		 $("#Apostal").val('');
         var _selected = $("#Aprovince").val();
         var options = 
         {
             type: "POST",
             async:false,
			 dataType: "json",
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'AMPHUR',
			 province:_selected
			 },
             success: function(msg) {
                $('#Aamphur').empty(); 
                 var returnedArray = msg;
                 state = $("#Aamphur");
				 state.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
                 
             }
         };
         $.ajax(options);
	 }

function ATum() 
     { 
	 	 $("#Apostal").val('');
         var _selected = $("#Aamphur").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             async:false,
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'TUMBON',
			 amphur:_selected
			 },
             success: function(msg) {
                $('#Atumbon').empty(); 
                 var returnedArray = msg;
                 state = $("#Atumbon");
				 state.append("<option value='0'>กรุณาเลือก</option>");
				 if(returnedArray!=null){
                 for (var i = 0; i < returnedArray.length; ++i) {
                     state.append("<option value='" + returnedArray[i].Id + "'>" + returnedArray[i].Name + "</option>");
                 }
			     }
			     else{
				 return false;
			     }
             }
         };
         $.ajax(options);
	 }

function Post() 
     { 
         var _selected = $("#tumbon").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             async:false,
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'POST',
			 tumbon:_selected
			 },
             success: function(msg) {
                $('#postal').empty(); 
                 var returnedArray = msg;
                 state = $("#postal");
					state.val(returnedArray[0].Name);
			     
             }
         };
         $.ajax(options);
	 }
 
function APost() 
     { 
         var _selected = $("#Atumbon").val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             async:false,
             url: "ajax/Ajax_Pro.php",
			 data: {
			 callajax:'POST',
			 tumbon:_selected
			 },
             success: function(msg) {
                $('#Apostal').empty(); 
                 var returnedArray = msg;
                 state = $("#Apostal");
					state.val(returnedArray[0].Name);
			     
             }
         };
         $.ajax(options);
	 }


function updateAlertsOpen(Obj2) {
	var IDDATA = $('#OQ').val();
         var options = 
         {
             type: "POST",
			 dataType: "json",
             url: "ajax/Ajax_CheckUser1.php",
			 data: {
				 idD : IDDATA
			 },
             success: function(msg) {
				 returnedArray=msg;
			     }
             
         };
         $.ajax(options);
   }

$(document).ready(function() {
$( "#dialog-form" ).dialog({
    autoOpen: false,
    height: 550,
    width: 650,
    modal: true,
    open: function(event, ui) { 
            $(".ui-dialog-titlebar-close").hide(); 
			updateAlertsOpen($("#OQ").val());
            $(window).on('beforeunload', function(){
    });
	},
});

	});