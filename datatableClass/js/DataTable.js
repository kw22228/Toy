import GetSet from './getSet';

export default class DataTable extends GetSet {
    init() {
        this.setDatas(this.render.bind(this));
    }

    setDatas(callback) {
        fetch(this.url)
            .then(res => {
                return res.json();
            })
            .then(datas => {
                this.datas = datas.people;
            })
            .then(callback);
    }

    setTable() {
        const htmlArr = [];
        for (let i = 0; i < this.rowCnt; i++) {
            const { Name, Age, Office, Postion, Salary, Start_Date } = this.datas[i];

            htmlArr.push(`
                <tr>
                    <td>${Name}</td>
                    <td>${Age}</td>
                    <td>${Office}</td>
                    <td>${Postion}</td>
                    <td>${Salary}</td>
                    <td>${Start_Date}</td>
                </tr>
            `);
        }

        return htmlArr.join('');
    }

    setPage() {
        const htmlArr = [];
        const maxPage = Math.ceil(this.datas.length / this.rowCnt);

        for (let i = 1; i < maxPage + 1; i++) {
            htmlArr.push(`
                <a href="#/${i}">${i}</a>
            `);
        }

        return htmlArr.join('');
    }

    render() {
        this.renderTemp = this.renderTemp.replace('{{tbody}}', this.setTable());
        this.renderTemp = this.renderTemp.replace('{{pagenation}}', this.setPage());
        this.element.innerHTML = this.renderTemp;
    }
}
