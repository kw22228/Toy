const configuration = {
    keyList: [
		'tableWrapperName',
		'rowSelectedId',
		'paginateId',
		'rowNumber',
		'datas'
		// etc ....
	],
    privateVal: {
		// 내부변수 초기화
		tableWrapperName: "default-tables",
		rowSelectedId: "default-rowSelectedId",
		rowNumber: 10,
		datas: [],
	},

    init: function (options) {
		mapper(this.keyList, options);

		this.pagenation = Pagenation.init(this.paginateId(),this.rowNumber());
		
		return this;
	},
    tableWrapperName: function (newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.tableWrapperName = newValue;
		}
		return this.privateVal.tableWrapperName;
	},

	rowSelectedId: function (newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.rowSelectedId = newValue;
		}
		return this.privateVal.rowSelectedId;
	},
    rowNumber: function (newValue) {
		
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.rowNumber = newValue;
		}
		return this.privateVal.rowNumber;
	},
    datas: function(newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.datas = newValue;
		}
		
		if (this.pagenation != null && !isUndefined(this.pagenation)) {
			this.pagenation.itemCount(this.privateVal.datas.length);
		}
		
		return this.privateVal.datas;
	},
}

const DataTable = {
    doc: null,
	configuaration: null,

    init: function (options) {
		this.doc = document;
		this.configuaration = configuration.init(options);
		
		//this.configuaration.datas = typeof datas === 'undefined' ? [] : datas;
			
		let tBodyChildrens = this.doc.getElementById(this.configuaration.tableWrapperName()).getElementsByTagName("tbody")[0].children;
		this.configuaration.datas([].slice.call(tBodyChildrens));
		//this.configuaration.datas(tBodyChildrens);
		
		this.updateTable();

		return this;
	},
    updateTable: function () {
		this.makeTable();
		if(typeof this.configuaration.pagenation.paginateId() !== 'undefined') this.makePaging();
		this.setData();
	},
    makeTable: function () {
		let wrapper = this.doc.getElementById(this.configuaration.tableWrapperName());
		let tbodys = wrapper.getElementsByTagName("tbody")[0];
		let originColumnCount = wrapper.getElementsByTagName("thead")[0].getElementsByTagName('tr')[0].children.length;
		let page = this.configuaration.pagenation;
		let listLen = page.rowNumber();
		
		if(typeof page.endPage() !== 'undefined' && (page.currentPage() == page.endPage())){
			listLen = page.itemCount() % page.rowNumber();
		}
		
		tbodys.innerHTML = "";
		
		for(var i = 0; i < listLen; i++) {
			var row = this.doc.createElement('tr');
			for(var j = 0; j < originColumnCount; j++) {
				var td = this.doc.createElement("td");
				row.appendChild(td);
			}
			tbodys.appendChild(row);
		}
		
	},
    setData: function () {
		let wrapper = this.doc.getElementById(this.configuaration.tableWrapperName());
		let tbodys = wrapper.getElementsByTagName("tbody")[0];
		let rows = tbodys.getElementsByTagName('tr');
		let s = (this.configuaration.pagenation.currentPage() - 1)	* rows.length;
		
		setChildNodes(rows, (i, e) => {
			if(s == this.configuaration.datas().length) return;
			
			let row = e.getElementsByTagName('td');
			
			setChildNodes(row, (j, item) => {
				item.innerHTML = this.configuaration.datas()[s].children[j].innerHTML;
				// todo datas 에서 데이터 매칭
			});
			
			s++;
		});
	}
}

function setChildNodes(list, setFunc) {
	var count = list.length;
		
	for (var i = 0; i < count; i++) {
		setFunc(i, list[i]);
	}
}

function mapper (k, o) {
	k.map(function(e) {
		if (!isUndefined(o[e])) {
			configuration[e](o[e]);
		} else {
			configuration[e](configuration.privateVal[e]);
		}
	});
}
		
function isUndefined(v) {
	return typeof v === 'undefined';
}