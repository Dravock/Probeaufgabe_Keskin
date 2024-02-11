let all_buttons = document.querySelectorAll('.btn');
let close_button = document.querySelector('.close');
let chronik_div = document.querySelector('.chronik');
console.log(chronik_div);

all_buttons.forEach(button => {
    button.addEventListener('click', function() {
        chronik_div.classList.add('show-chronik');
        console.log(button);
    });
});

close_button.addEventListener('click', function() {
    chronik_div.classList.remove('show-chronik');
});