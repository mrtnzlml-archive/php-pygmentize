#!/usr/bin/env node

function factorial(n) {
	if (n === 0 || n === 1) {
		return 1;  // 0! = 1! = 1
	}
	return n * factorial(n - 1);
}

factorial(...[3]); // returns 6

document.getElementById('hellobutton').onclick = () => {
	alert("Hello world!".match(/[a-zA-Z]{1,2}/)); // Show a dialog
	let λ = document.createTextNode('Some new words.');
	document.body.appendChild(λ); // Append "Some new words" to the page
};

let literal = 0xFF;
let {destruct} = {destruct: `Template ${literal}`};
destruct++;
