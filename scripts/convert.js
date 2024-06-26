function convertCurrency() {
    const amount = document.getElementById('amount').value;
    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;  

    const api_key = 'c694c5858ed15880e359d0ad';

    fetch(`https://v6.exchangerate-api.com/v6/${api_key}/latest/${from}`)
    .then(response => response.json())
    .then(data => {
            const convertRate = data.conversion_rates[to];
            let convertedAmount = amount * convertRate;
            convertedAmount = parseFloat(convertedAmount).toFixed(2);
            document.getElementById('converted').value = convertedAmount;
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        console.log(error);
        document.getElementById('resultInput').innerHTML = "An error ocurred while fetching data."; 
    })
}