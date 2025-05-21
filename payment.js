document.getElementById('paymentForm').addEventListener('submit', function(event) {
    event.preventDefault();
  
    const name = document.getElementById('name').value.trim();
    const cardNumber = document.getElementById('cardNumber').value.trim();
    const expiry = document.getElementById('expiry').value.trim();
    const cvv = document.getElementById('cvv').value.trim();
  
    if (!name || !cardNumber || !expiry || !cvv) {
      alert('Please fill in all fields.');
      return;
    }
  
    if (!/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/.test(cardNumber)) {
      alert('Invalid card number format. Use 1234 5678 9012 3456.');
      return;
    }
  
    if (!/^\d{2}\/\d{2}$/.test(expiry)) {
      alert('Invalid expiry date format. Use MM/YY.');
      return;
    }
  
    if (!/^\d{3}$/.test(cvv)) {
      alert('Invalid CVV format. Use 3 digits.');
      return;
    }
  
    alert('Payment successful!');
  });