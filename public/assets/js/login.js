var App = new Vue({
    el: '#BoxApp',
    data: {
        disabled: false,
        login: {
            error: false,
            value: 'a',
        },
        password: {
            error: false,
            value: 's',
        },
    },
    methods: {
        execLogin: function () {
            App.disabled = false;

            App.login.error = false;
            App.login.value = App.login.value.trim();

            App.password.error = false;
            App.password.value = App.password.value.trim();

            var error = false;

            if (App.login.value == '') {
                error = true;
                App.login.error = 'Campo obrigatório';
            }

            if (App.password.value == '') {
                error = true;
                App.password.error = 'Campo obrigatório';
            }

            if (!error) {
                App.disabled = true;

                $.ajax({
                    url: _PATH_ + 'admin/login-post',
                    method: 'post',
                    data: {
                        login: App.login.value,
                        password: App.password.value,
                    },
                    success: function (data) {
                        data = JSON.parse(data);

                        if (data.error) {
                            for (var i in data.messages) {
                                var message = data.messages[i];

                                if (message.type == 'field_login') {
                                    App.login.error = message.message;
                                }

                                if (message.type == 'field_password') {
                                    App.password.error = message.message;
                                }
                            }

                            App.disabled = false;
                        } else {
                            window.location.replace(_PATH_ + 'admin');
                        }
                    },
                    error: function () {
                        alert('Um erro inesperado aconteceu. Recarregue a tela e tente novamente.');
                        App.disabled = false;
                    },
                    complete: function () {
                        // App.disabled = false;
                    },
                });

                // setTimeout(function () {
                //     App.disabled = false;
                // }, 1000);
            }
        },
    },
});
