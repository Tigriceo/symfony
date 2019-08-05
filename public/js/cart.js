'use strict';

let addToCardButtons;

addToCartButtons = document.querySelectorAll('.js-add-to-cart');

addToCardButtons.forEach((button)) => {
    button.addEventListener('click', (event) => {
        event.preventDefault();

        fetch(button.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then((response)) => {
            return response.text();
        })
        .then((body) => {
           document.getElementById('header-cart').innerHTML = body;
        })
    });
});


//addToCartButtons.forEach(function (button) {
//
// });