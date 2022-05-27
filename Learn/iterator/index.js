const fibonachi = {
    [Symbol.iterator]() {
        let n1 = 0,
            n2 = 1,
            value;

        return {
            next() {
                value = n1;
                n1 = n2;
                n2 = value + n2;

                if (value > 100) {
                    return { done: true };
                } else {
                    return { value };
                }
            },
        };
    },
};

for (const value of fibonachi) {
    console.log(value);
}
