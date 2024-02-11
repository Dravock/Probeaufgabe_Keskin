let call_url
let all_buttons = document.querySelectorAll('.btn');
let close_button = document.querySelector('.close');
let chronik_div = document.querySelector('.chronik');
let api_token = '1234567890';

all_buttons.forEach(button => {
    button.addEventListener('click', function () {
        chronik_div.classList.add('show-chronik');

        let get_id = button.dataset.btn
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("insertContent").innerHTML = this.responseText;
            }
        };
        get_id = get_id.split('ma-id-');
        
        call_url ='Inc/ajaxHandle.php?id='+get_id[1]+'&token='+api_token;
        
        xhttp.open("GET", call_url , true);
        xhttp.send();
    });
});

close_button.addEventListener('click', function () {
    chronik_div.classList.remove('show-chronik');
});