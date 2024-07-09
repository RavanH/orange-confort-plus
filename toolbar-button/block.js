(function (blocks, element) {
	var el = element.createElement;

	blocks.registerBlockType("orange-confort-plus/toolbar-button", {
	  edit: function () {
		return el("div", { "class": "wp-block wp-block-buttons" } , el("div", { "class": "wp-block wp-block-button" } , el("div", { "class": "wp-block wp-block-button" } , el("div", { "class": "wp-block-button__link" } , "Confort +"))));
	  },
	  save: function () {
		return el("p", {} , "Hello World - Frontend 2");
	  },
	});
  })(window.wp.blocks, window.wp.element);
