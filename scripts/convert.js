function convertCurrency() {
    const amount = document.getElementById('amount').value;
    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;

    const api_key = 'c694c5858ed15880e359d0ad';

    fetch(`https://v6.exchangerate-api.com/v6/${api_key}/latest/${from}`)
    .then(response => response.json())
    .then(data => {
            const convertRate = data.conversion_rates[to];
            const convertedAmount = amount * convertRate;
            document.getElementById('result').innerHTML = `${amount} ${from} = ${convertedAmount} ${to}`;
    })
    .catch(error => {
        console.error('Error fetching data:', error);
        document.getElementById('result').innerHTML = "An error ocurred while fetching data."; 
    })
}