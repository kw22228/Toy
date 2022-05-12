import { template } from './template';
export default class GetSet {
    #url;
    #element;
    #rowCnt;
    #renderTemp = template;
    #datas = [];
    #page = 1;

    constructor(url, elem, rowCnt) {
        this.#element = document.getElementById(elem);
        this.#url = url;
        this.#rowCnt = rowCnt;
    }

    //url
    set url(url) {
        this.#url = url;
    }
    get url() {
        return this.#url;
    }

    //element
    set element(elem) {
        this.#element = elem;
    }
    get element() {
        return this.#element;
    }

    //rowcnt
    set rowCnt(cnt) {
        this.#rowCnt = cnt;
    }
    get rowCnt() {
        return this.#rowCnt;
    }

    //data
    set datas(obj) {
        this.#datas = obj;
    }
    get datas() {
        return this.#datas;
    }

    //template
    set renderTemp(template) {
        this.#renderTemp = template;
    }
    get renderTemp() {
        return this.#renderTemp;
    }
}
