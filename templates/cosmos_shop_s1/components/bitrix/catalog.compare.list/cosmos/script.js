$(document).ready(function() {
    $('.compare-switcher .compare-switcher-trigger').click(function () {
        $('.compare-switcher').toggleClass('compare-switcher-active', 300);
    });
});

(function (window) {

if (!!window.JCCatalogCompareList)
{
	return;
}

window.JCCatalogCompareList = function (params)
{
	this.obCompare = null;
	this.obAdminPanel = null;
	this.visual = params.VISUAL;
	this.visual.LIST = this.visual.ID + '_tbl';
	this.visual.ROW = this.visual.ID + '_row_';
	this.visual.COUNT = this.visual.ID + '_count';
	this.ajax = params.AJAX;

	BX.ready(BX.proxy(this.init, this));
};

window.JCCatalogCompareList.prototype.init = function()
{
	this.obCompare = BX(this.visual.ID);
	if (!!this.obCompare)
	{
		BX.addCustomEvent(window, "OnCompareChange", BX.proxy(this.reload, this));
		BX.bindDelegate(this.obCompare, 'click', {tagName : 'a'}, BX.proxy(this.deleteCompare, this));
	}
};

window.JCCatalogCompareList.prototype.reload = function()
{
	SEMICOLON.widget.showFormProcess($(this.obCompare).parent());
	BX.ajax.post(
		this.ajax.url,
		this.ajax.params,
		BX.proxy(this.reloadResult, this)
	);
};

window.JCCatalogCompareList.prototype.reloadResult = function(result)
{
	SEMICOLON.widget.hideFormProcess($(this.obCompare).parent());
	this.obCompare.innerHTML = result;
	BX.style(this.obCompare, 'display', 'block');

	var curCount = $('#' + this.visual.LIST + ' a.compare-item').length;
	$('#' + this.visual.COUNT).html(curCount);

	if (curCount == 0) {
		$('#' + this.visual.COUNT).hide();
	} else {
		$('#' + this.visual.COUNT).show();
	}

};

window.JCCatalogCompareList.prototype.deleteCompare = function()
{
	var target = BX.proxy_context,
		itemID,
		url;

	if (!!target && target.hasAttribute('data-id'))
	{
		itemID = parseInt(target.getAttribute('data-id'), 10);
		if (!isNaN(itemID))
		{
			SEMICOLON.widget.showFormProcess($(this.obCompare).parent());
			url = this.ajax.url + this.ajax.templates.delete + itemID.toString();
			BX.ajax.loadJSON(
				url,
				this.ajax.params,
				BX.proxy(this.deleteCompareResult, this)
			);
		}
	}
};

window.JCCatalogCompareList.prototype.deleteCompareResult = function(result)
{
	var tbl,
		i,
		deleteID,
		cnt,
		newCount;

	SEMICOLON.widget.hideFormProcess($(this.obCompare).parent());
	if (typeof result === 'object')
	{
		if (!!result.STATUS && result.STATUS === 'OK' && !!result.ID)
		{
			tbl = BX(this.visual.LIST);
			if (tbl)
			{
				if (tbl.rows.length > 1)
				{
					deleteID = this.visual.ROW + result.ID;
					for (i = 0; i < tbl.rows.length; i++)
					{
						if (tbl.rows[i].id === deleteID)
						{
							tbl.deleteRow(i);
						}
					}
					tbl = null;
					if (!!result.COUNT)
					{
						newCount = parseInt(result.COUNT, 10);
						if (!isNaN(newCount))
						{
							cnt = BX(this.visual.COUNT);
							if (!!cnt)
							{
								cnt.innerHTML = newCount.toString();
								cnt = null;
							}
						}
					}
				}
				else
				{
					this.reload();
				}
			}
		}
	}
};


})(window);