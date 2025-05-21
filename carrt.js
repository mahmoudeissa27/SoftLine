
const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];


const cartItemsElement = document.getElementById('cart-items');
const cartTotalElement = document.getElementById('cart-total');
const paymentForm = document.getElementById('payment-form');
const creditCardDetails = document.getElementById('credit-card-details');
const cardNumberInput = document.getElementById('card-number');
const expirationDateInput = document.getElementById('expiration-date');
const cvvInput = document.getElementById('cvv');


function displayCartItems() {
    if (cartItems.length === 0) {
        cartItemsElement.innerHTML = '<p>Your cart is empty.</p>';
        cartTotalElement.textContent = '$0.00';
        return;
    }




    cartItemsElement.innerHTML = cartItems
        .map(
            item => `
            <div class="cart-item">
                <img src="${item.image}" alt="${item.title}">
                <div class="cart-item-details">
                    <h3>${item.title}</h3>
                    <p>$${item.price.toFixed(2)}</p>
                </div>
            </div>
        `
        )
        .join('');

    
    const total = cartItems.reduce((sum, item) => sum + item.price, 0);
    cartTotalElement.textContent = `$${total.toFixed(2)}`;
}

function toggleCreditCardForm() {
    const creditCardOption = document.getElementById('credit-card');
    if (creditCardOption.checked) {
        creditCardDetails.style.display = 'block';  
    } else {
        creditCardDetails.style.display = 'none';  
    }
}


paymentForm.addEventListener('submit', (e) => {
    e.preventDefault(); 
    const paymentMethod = document.querySelector('input[name="payment-method"]:checked').value;
    
    if (paymentMethod === 'credit-card') {
        
        const paymentData = {
            cardNumber: cardNumberInput.value,
            expirationDate: expirationDateInput.value,
            cvv: cvvInput.value
        };
        localStorage.setItem('paymentData', JSON.stringify(paymentData));
        alert('Card details saved successfully');
    }


    alert(`Proceeding with ${paymentMethod} payment.`);

    
    setTimeout(() => {
        window.location.href = 'index.html'; 
    }, 2000); 
});


document.querySelectorAll('input[name="payment-method"]').forEach(input => {
    input.addEventListener('change', toggleCreditCardForm);
});


displayCartItems();
