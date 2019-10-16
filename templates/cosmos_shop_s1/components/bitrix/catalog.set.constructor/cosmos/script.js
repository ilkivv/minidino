BX.namespace("BX.Catalog.SetConstructor");

BX.Catalog.SetConstructor = (function()
{
	var SetConstructor = function(params)
	{
		this.numSliderItems = params.numSliderItems || 0;
		this.jsId = params.jsId || "";
		this.ajaxPath = params.ajaxPath || "";
		this.currency = params.currency || "";
		this.lid = params.lid || "";
		this.iblockId = params.iblockId || "";
		this.basketUrl = params.basketUrl || "";
		this.setIds = params.setIds || null;
		this.offersCartProps = params.offersCartProps || null;
		this.itemsRatio = params.itemsRatio || null;
		this.noFotoSrc = params.noFotoSrc || "";

		this.mainElementPrice = Number(params.mainElementPrice) || 0;
		this.mainElementOldPrice = Number(params.mainElementOldPrice) || 0;
		this.mainElementDiffPrice = Number(params.mainElementDiffPrice) || 0;

		this.parentCont = BX(params.parentContId) || null;
		this.sliderItemsCont = this.parentCont.querySelector("[data-role='set-other-items']");
		this.setItemsCont = this.parentCont.querySelector("[data-role='set-items']");

		this.setPriceCont = this.parentCont.querySelector("[data-role='set-price']");
		this.setOldPriceCont = this.parentCont.querySelector("[data-role='set-old-price']");
		this.setDiffPriceCont = this.parentCont.querySelector("[data-role='set-diff-price']");

		var self = this,
			i,
			l;

		var delButtons = this.setItemsCont.querySelectorAll("[data-role='set-delete-btn']");
		if (delButtons)
		{
			for (i = 0, l = delButtons.length; i < l; i++) {
				BX.bind(delButtons[i], "click", function () {
					self.deleteFromSet(this.parentNode.parentNode);
				});
			}
		}

		var addButtons = this.sliderItemsCont.querySelectorAll("[data-role='set-add-btn']");
		if (addButtons)
		{
			for (i = 0, l = addButtons.length; i < l; i++) {
				BX.bind(addButtons[i], "click", function () {
					self.addToSet(this.parentNode.parentNode.parentNode);
				});
			}
		}

		var buyButton = this.parentCont.querySelector("[data-role='set-buy-btn']");
		BX.bind(buyButton, "click", function(){
			self.addToBasket(this);
		});

		this.generateSliderStyles();
	};

	SetConstructor.prototype.generateSliderStyles = function()
	{
		var styleNode = BX.create("style", {
			html:	".bx-catalog-set-topsale-slids-"+this.jsId+"{width: " + this.numSliderItems*25 + "%;}"+
					".bx-catalog-set-item-container-"+this.jsId+"{width: " + (100/this.numSliderItems) + "%;}"+
					"@media (max-width:767px){"+
					".bx-catalog-set-topsale-slids-"+this.jsId+"{width: " + this.numSliderItems*20*2 + "%;}}",
			attrs: {
				id: "bx-set-const-style-" + this.jsId
			}});

		if (BX("bx-set-const-style-" + this.jsId))
		{
			BX.remove(BX("bx-set-const-style-" + this.jsId));
		}

		this.parentCont.appendChild(styleNode);
	};

	SetConstructor.prototype.deleteFromSet = function(item)
	{
		var itemId = item.getAttribute("data-id"),
			itemName = item.getAttribute("data-name"),
			itemUrl = item.getAttribute("data-url"),
			itemImg = item.getAttribute("data-img"),
			itemPrintPrice = item.getAttribute("data-print-price"),
			itemPrice = item.getAttribute("data-price"),
			itemPrintOldPrice = item.getAttribute("data-print-old-price"),
			itemOldPrice = item.getAttribute("data-old-price"),
			itemDiffPrice = item.getAttribute("data-diff-price"),
			i,
			l,
			self,
			newSliderNode;

		self = this;

		newSliderNode = BX.create("div", {
			attrs: {
				className: "bx-catalog-set-item-container bx-catalog-set-item-container-"+this.jsId,
				"data-id": itemId,
				"data-img": itemImg ? itemImg : "",
				"data-url": itemUrl,
				"data-name": itemName,
				"data-print-price": itemPrintPrice,
				"data-print-old-price":itemPrintOldPrice,
				"data-price": itemPrice,
				"data-old-price": itemOldPrice,
				"data-diff-price": itemDiffPrice
			},
			children: [
				BX.create("div", {
						attrs: {
							className: "bx-catalog-set-item"
						},
						children: [
							BX.create("div", {
								attrs: {
									className: "bx-catalog-set-item-img"
								},
								children: [
									BX.create("div", {
										attrs: {
											className: "bx-catalog-set-item-img-container"
										},
										children: [
											BX.create("img", {attrs: {
												src : itemImg ? itemImg : this.noFotoSrc,
												className: "img-responsive"
											}})
										]
									})
								]
							}),
							BX.create("div", {
								attrs: {
									className: "bx-catalog-set-item-title"
								},
								children: [
									BX.create("a", {
										attrs: {
											href: itemUrl
										},
										html: itemName
									})
								]
							}),
							BX.create("div", {
								attrs: {
									className: "bx-catalog-set-item-price"
								},
								children: [
									BX.create("div", {
										attrs: {
											className : "bx-catalog-set-item-price-new"
										},
										html: itemPrintPrice
									}),
									BX.create("div", {
										attrs: {
											className : "bx-catalog-set-item-price-old"
										},
										html: itemPrice != itemOldPrice ? itemPrintOldPrice : ""
									})
								]
							}),
							BX.create("div", {
								attrs: {
									className: "bx-catalog-set-item-add-btn"
								},
								children: [
									BX.create("a", {
										attrs: {
											className: "button button-small"
										},
										html: BX.message("ADD_BUTTON"),
										events: {
											"click" : function(){
												self.addToSet(this.parentNode.parentNode.parentNode);
											}
										}
									})
								]
							})
						]
					}
				)]
		});
		this.sliderItemsCont.appendChild(newSliderNode);

		this.numSliderItems++;
		this.generateSliderStyles();
		BX.remove(item);

		for(i = 0, l = this.setIds.length; i < l; i++)
		{
			if (this.setIds[i] == itemId)
			{
				this.setIds.splice(i,1);
			}
		}

		this.recountPrice();
	};

	SetConstructor.prototype.addToSet = function(item)
	{
		var itemId = item.getAttribute("data-id"),
			itemName = item.getAttribute("data-name"),
			itemUrl = item.getAttribute("data-url"),
			itemImg = item.getAttribute("data-img"),
			itemPrintPrice = item.getAttribute("data-print-price"),
			itemPrice = item.getAttribute("data-price"),
			itemPrintOldPrice = item.getAttribute("data-print-old-price"),
			itemOldPrice = item.getAttribute("data-old-price"),
			itemDiffPrice = item.getAttribute("data-diff-price");

		var self = this;

		var newSetNode = BX.create("tr", {
				attrs: {
					"data-id": itemId,
					"data-img": itemImg ? itemImg : "",
					"data-url": itemUrl,
					"data-name": itemName,
					"data-print-price": itemPrintPrice,
					"data-print-old-price":itemPrintOldPrice,
					"data-price": itemPrice,
					"data-old-price": itemOldPrice,
					"data-diff-price": itemDiffPrice
				},
				children: [
					BX.create("td", {
						attrs: {
							className: "bx-added-item-table-cell-img"
						},
						children: [
							BX.create("img", {attrs: {
								src : itemImg ? itemImg : this.noFotoSrc,
								className: "img-responsive"
							}})
						]
					}),
					BX.create("td", {
						attrs: {
							className: "bx-added-item-table-cell-itemname"
						},
						children: [
							BX.create("a", {
								attrs: {
									href: itemUrl,
									className: "tdn"
								},
								html: itemName
							})
						]
					}),
					BX.create("td", {
						attrs: {
							className: "bx-added-item-table-cell-price"
						},
						children: [
							BX.create("span", {
								attrs: {
									className : "bx-added-item-new-price"
								},
								html: itemPrintPrice
							}),
							BX.create("br"),
							BX.create("span", {
								attrs: {
									className : "bx-added-item-old-price"
								},
								html: itemPrice != itemOldPrice ? itemPrintOldPrice : ""
							})
						]
					}),
					BX.create("td", {
						attrs: {
							className: "bx-added-item-table-cell-del"
						},
						children: [
							BX.create("div", {
								attrs: {
									className: "bx-added-item-delete"
								},
								events: {
									"click" : function(){
										self.deleteFromSet(this.parentNode.parentNode);
									}
								}
							})
						]
					})
				]
			}
		);
		this.setItemsCont.appendChild(newSetNode);

		this.numSliderItems--;
		this.generateSliderStyles();
		BX.remove(item);
		this.setIds.push(itemId);
		this.recountPrice();
	};

	SetConstructor.prototype.recountPrice = function()
	{
		var sumPrice = this.mainElementPrice,
			sumOldPrice = this.mainElementOldPrice,
			sumDiffDiscountPrice = this.mainElementDiffPrice;

		var setItems = BX.findChildren(this.setItemsCont, {tagName: "tr"}, true);
		if (setItems)
		{
			for(var i=0,l=setItems.length; i<l; i++)
			{
				sumPrice += Number(setItems[i].getAttribute("data-price"));
				sumOldPrice += Number(setItems[i].getAttribute("data-old-price"));
				sumDiffDiscountPrice += Number(setItems[i].getAttribute("data-diff-price"));
			}
		}
		BX.ajax({
			method : "POST",
			dataType: 'json',
			url: this.ajaxPath,
			data:
			{
				sessid: BX.bitrix_sessid(),
				action: "ajax_recount_prices",
				sumPrice: sumPrice,
				sumOldPrice: sumOldPrice,
				sumDiffDiscountPrice: sumDiffDiscountPrice,
				currency: this.currency
			},
			onsuccess: BX.proxy(function(res)
			{
				this.setPriceCont.innerHTML = res.formatSum ? res.formatSum : "";
				this.setOldPriceCont.innerHTML = res.formatOldSum ? res.formatOldSum : "";
				this.setDiffPriceCont.innerHTML = res.formatDiscDiffSum ? res.formatDiscDiffSum : "";
			}, this)
		});
	};

	SetConstructor.prototype.addToBasket = function(button)
	{
		SEMICOLON.widget.showFormProcess($("#bx-set-const-" + this.jsId).parent());
		BX.ajax.post(
			this.ajaxPath,
			{
				sessid: BX.bitrix_sessid(),
				action: 'catalogSetAdd2Basket',
				set_ids: this.setIds,
				lid: this.lid,
				iblockId: this.iblockId,
				setOffersCartProps: this.offersCartProps,
				itemsRatio: this.itemsRatio
			},
			BX.proxy(function(result)
			{
				SEMICOLON.widget.hideFormProcess($("#bx-set-const-" + this.jsId).parent());
				document.location.href = this.basketUrl;
			}, this)
		);
	};

	return SetConstructor;
})();