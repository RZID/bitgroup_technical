const triangular = (num) => {
  for (let i = 1; i <= num; i++) {
    console.log(" ".repeat(num - i) + "* ".repeat(i));
  }
};

const invert_triangle = (num) => {
  for (let i = num; 1 <= i; i--) {
    console.log(" ".repeat(num - i) + "* ".repeat(i));
  }
};

const diamond = (num) => {
  let i = 1;
  while (i < num) {
    console.log(" ".repeat(num - i) + "* ".repeat(i));
    i++;
  }
  if (i == num) {
    while (i >= 1) {
      console.log(" ".repeat(num - i) + "* ".repeat(i));
      i--;
    }
  }
};

// Output!
console.log("-----| Triangular begin |-----");
triangular(5);
console.log("\n-----| End of triangular |-----\n");

console.log("-----| Invert triangle begin |-----");
invert_triangle(5);
console.log("\n-----| End of invert triangle |-----\n");

console.log("-----| Diamond begin |-----");
diamond(5);
console.log("\n-----| End of diamond |-----\n");
