function Api(url, call) {
    $.ajax({
        url: url,
        type: 'GET',
        success: function (result) {
            call(result);
        },
        error: function (result) {
            console.log('requireFile_HTML_Ajax: ', result);
        },
    });
}

function message(text, title = 'OPS', icon = 'question', timer = 3000) {
    Swal.fire({
        title,
        text,
        icon,
        timer,
        timerProgressBar: true,
        didOpen: () => {
            Swal.showLoading();
            timerInterval = setInterval(() => {}, 100);
        },
        willClose: () => {
            clearInterval(timerInterval);
        },
    });
}

function register() {
    var name = $('#name').val();
    var password = $('#password').val();
    var contact = $('#contact').val();
    var isValid = true;

    if (name === '') {
        message('Por favor, insira seu nome.', 'Campo invalido', 'error');
        isValid = false;
    }

    if (password === '') {
        message('Por favor, insira sua senha.', 'Campo invalido', 'error');
        isValid = false;
    }

    if (contact === '') {
        message('Por favor, insira seu contato (email ou telefone).', 'Campo invalido', 'error');
        isValid = false;
    }

    if (isValid) {
        $.ajax({
            url: '/user/register_user.php',
            type: 'POST',
            data: JSON.stringify({
                name: name,
                pass: password,
                contact: contact,
            }),
            success: function (response) {
                message('Cadastro bem-sucedido!', 'PARABENS', 'success');
                localStorage.setItem('user_email', response.result.email);
            },
            error: function (xhr, status, error) {
                console.log('Erro ao fazer cadastro: ' + error);
                message('Erro ao fazer cadastro', 'ALGO DEU ERRADO', 'error');
            },
        });
    }
}
