// JavaScript Document
$(function()
	{
		$('#inp1').iMask({
			type : 'number'
		});
		$('#cost_renew').iMask({
			type : 'number'
		});
		$('#inp2').iMask({
			type : 'number'
		});
		$('#pro_dis').iMask({
		type : 'number'
		});
		$('#goodb').iMask({
		type : 'number'
		});
		$('#pro_dis2').iMask({
		type : 'number'
		});
		$('#inp3').iMask({
			type : 'number'
		});
		$('#inp4').iMask({
			type : 'number'
		});
		$('#inp5').iMask({
			       type : 'number'
			,      mask : '99/99/99'
			, decDigits : 0
			, decSymbol : ''
			,    sanity : function( val ){
				return Math.min( 10000000, Math.max(0, parseFloat( val.replace(/[^\.\d]/g, ''))));
			}
		});
		$('#inp6').iMask({
			       type : 'number'
			,      mask : '99/99/99'
			, decDigits : 0
			, decSymbol : ''
			,    sanity : function( val ){
				return Math.min( 10000000, Math.max(0, parseFloat( val.replace(/[^\.\d]/g, ''))));
			}
		});
		$('#inp7').iMask({
			       type : 'number'
			,      mask : '99/99/99'
			, decDigits : 0
			, decSymbol : ''
			,    sanity : function( val ){
				return Math.min( 10000000, Math.max(0, parseFloat( val.replace(/[^\.\d]/g, ''))));
			}
		});
		$('#inp8').iMask({
			type : 'number'
		});
		$('#inp9').iMask({
			type : 'number'
		});
		$('#inp10').iMask({
			type : 'number'
		});
		$('#inp11').iMask({
			type : 'number'
		});
		$('#inp12').iMask({
			  type : 'fixed'
			, mask : '99/99/99'
		});
	$('#inp13').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#inp16').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#tel_fax').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#tel_mobile2').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
				$('#contact_number').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#tel_home').iMask({
			  type : 'fixed'
			, mask : '999-999-9999'
		});
		$('#inp14').iMask({
			type : 'number'
		});
		$('#inp15').iMask({
			type : 'number'
		});
		$('#driver').iMask({
			type : 'number'
		});
		$('#one').iMask({
			type : 'number'
		});
		$('#acccost1').iMask({
			type : 'number'
		});
				$('#acccost2').iMask({
			type : 'number'
		});
				$('#acccost3').iMask({
			type : 'number'
		});
				$('#acccost4').iMask({
			type : 'number'
		});
		$('#disone').iMask({
		      type : 'number'
		})
	});
	$('#pre').iMask({
			type : 'number'
		});
