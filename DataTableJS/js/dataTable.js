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
		paginateId: "default-paginateId",
		rowNumber: 10,
		datas: [],
	},
	pagenation: null,
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
	paginateId: function (newValue) {
		
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.paginateId = newValue;
		}
		return this.privateVal.paginateId;
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
const Pagenation = {
	privateVal: {
		// 내부변수 초기화
		paginateId: "",
		itemCount: 0,
		currentPage: 1,
		rowNumber: 10,
	},

	init: function (paginateId, rowNumber) {
		this.paginateId(paginateId);
		this.rowNumber(rowNumber);
		
		return this;
	},

	paginateId: function(newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.paginateId = newValue;
		}
		return this.privateVal.paginateId;
	},

	itemCount: function(newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.itemCount = newValue;
		}
		return this.privateVal.itemCount;
	},

	currentPage: function(newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.currentPage = newValue;
		}
		return this.privateVal.currentPage;
	},

	rowNumber: function(newValue) {
		if (!isUndefined(newValue)) { // new numRowCount validation 추가
			this.privateVal.rowNumber = newValue;
		}
		return this.privateVal.rowNumber;
	},

	endPage: function() {
		return Math.ceil(this.privateVal.itemCount / this.privateVal.rowNumber);
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
		this.eventRowNumber();

		return this;
	},

	eventRowNumber: function() {
		$('#'+this.configuaration.rowSelectedId()).change(e => this.changeRowNumber(e.target.value));
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
	makePaging: function () {
		let pagnation = this.doc.getElementById(this.configuaration.pagenation.paginateId());
		pagnation.innerHTML = '';
		
		let leftContent_text  = "Showing " + (((this.configuaration.pagenation.currentPage() - 1) * this.configuaration.pagenation.rowNumber()) + 1) + " to ";
			leftContent_text += (this.configuaration.pagenation.currentPage() === this.configuaration.pagenation.endPage()) ? (this.configuaration.datas().length) : (this.configuaration.pagenation.rowNumber() * this.configuaration.pagenation.currentPage());
			leftContent_text += " of " + this.configuaration.datas().length + " entries";
		let leftContent = this.doc.createElement('span');
		leftContent.className = "leftContent";
		leftContent.appendChild(this.doc.createTextNode(leftContent_text));
		
		let rightContent = this.doc.createElement('span');
		rightContent.className = "rightContent";
		for(var i = 0; i < this.configuaration.pagenation.endPage(); i++){
			var a = this.doc.createElement('a');
			a.href = "javascript:DataTable.changeCurrentPage(" + (i+1) + ")";
			a.className = (this.configuaration.pagenation.currentPage() == (i+1)) ? 'action' : '';
			a.appendChild(this.doc.createTextNode( (i+1) ));
			rightContent.appendChild(a);
		}
		
		pagnation.appendChild(leftContent);
		pagnation.appendChild(rightContent);
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