
function CosmosSmallCart(){}

CosmosSmallCart.prototype = {

	init: function() {
		BX.addCustomEvent(window, 'OnBasketChange', this.closure('refreshBasket', {}));
	},

	closure: function (fname, data) {
		var obj = this;
		return data
			? function(){obj[fname](data)}
			: function(arg1){obj[fname](arg1)};
	},

	refreshBasket: function() {
		$.ajax({
		  type: "POST",
		  url: this.ajaxPath,
		  data: {
		  	siteId: this.siteId,
		  	sessid: BX.bitrix_sessid(),
		  	arParams: this.arParams,
		  },
		  success: function(result){
				$("#top-cart-content").empty().append($(result).find('#top-cart-content').html());
		  },
		});

	},
}

