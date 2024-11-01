function largestDifference(arr) {
    if (arr.length < 2) return 0; 

    let min = arr[0];
    let max = arr[0];

    for (let num of arr) {
        if (num < min) min = num;
        if (num > max) max = num;
    }

    return max - min;
}

const array = [2, 10, 3, 7, 1];
console.log(largestDifference(array)); 
