## Iterator Protocol

-   itorator란 배열이나 유사한 자료구조의 내부 요소를 순회(traversing)하는 객체이다.
-   iterable, iterator 2가지의 형태가 존재.

---

## Iterable

-   객체의 멤버를 반복할 수 있는 객체.
-   object property에 Symbol.iterator 메소드가 있어야 된다.
-   Iterable을 가지고있는 Object는 Array, Set, Map, Dom NodeList, String이다
-   Array, Set, Map,은 iterator를 반환한다. (return되는 객체는 iterable이면서 iterator 임.)

---

## Iterator

-   Iterator객체는 next() 메소드를 가지고 있고, next()로 순환 할 수 있는 객체.
-   next메소는 arguments가 없다.
-   next메소드는 done: boolean 과 value: any를 포함하는 object를 return한다.
-   next메소드의 반복이 끝나면 done은 true를 반환한다.
