// console.log(), warn, info, error
// console.log('abc')
// console.clear()

// var firstName = 'John' // string
// let lastName // undefined
// console.log(typeof lastName)
// lastName = 'Doe'
// console.log(typeof lastName)
// lastName = 123;
// console.log(typeof lastName)
// const age = 50 // number


// document - DOM 
const element = document.getElementById('result')
let op;

function clickNumber(number) {
    element.value = number;
}

function clickOperator(operator) { // argument/parameters
    op = operator;
    if(operator === '+') {
        console.log('yes it is a plus')
    } else if(operator === '-') {
        console.log('yes it is a minus')
    } else {
        console.log('no')
    }
}