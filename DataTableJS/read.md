# DataTable

- 일반적인 테이블에 입력되어있는 데이터로 데이터테이블 기능을 하는 라이브러리를 만들어봄.

### DataTable init
- 데이터테이블 이니셜라이징

```javascript
$(document).ready(function(){
		var dt = DataTable.init({
			tableWrapperName: "dataTable",
			rowSelectedId: "selectEl",
			paginateId: "paging",
			searchId: "searchEl",
			rowNumber: 10
		});
	});
```

### 기능
- 데이터 페이징
- 데이터 서칭
- 데이터 갯수설정
- 데이터 소팅