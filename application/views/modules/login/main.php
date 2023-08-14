<style>
.login {
    background-color: var(--color-gray-100);
    height: 100vh;
    overflow: hidden;
}
.login .content {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 16px 16px 60px;
}
.login .card {
    max-width: 400px;
}
.login .card-header {
    /* padding: 48px 40px 0; */
    padding: 25px 0px 0;
    border: none;
    background-color: unset;
}
.login .card-title {
    text-align: center;
}
.login .card-body {
    /* padding: 24px 32px 40px; */
    padding: 17px 32px 40px;
}
.login .logo {
    display: flex;
    justify-content: center;
    margin-bottom: 24px;
}
.login .logo img {
    height: 50px;
    width: auto;
}
.login .forgot-password {
    font-size: 12px;
    margin-top: 4px;
    display: flex;
    justify-content: flex-end;
}
</style>
<section class="section login">
    <div class="container">
        <div class="section-body">
            <div class="content">
                <div class="card">
                    <div class="card-header">
                        <div class="logo">
                            <img class="lazyimg" data-src="<?php echo base_url('assets/logo.gif'); ?>" width="164" height="40" alt="Logo" title="Logo">
                        </div>
                        <h1 class="card-title">Login Admin</h1>
                    </div>
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="email">Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Password">
                            </div>
                            <div>
                                <button class="btn btn--primary btn-block waves-effect" type="submit"><?php echo $this->lang->line('login'); ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
$('#loginForm').submit(function (e) {
    e.preventDefault();
    let elForm = $(this);
    let elBtn = $('#loginForm [type="submit"]');

    $.ajax({
        data: elForm.serialize(),
        url: BASE_URL + 'auth/login',
        method: 'post',
        dataType: 'json',
        beforeSend: function () {
            btnLoader(elBtn);
        },
        success: function (response) {
            if (response.status == 'error') {
                notification('error', response.message);
            } else if (response.status == 'success') {
                notification('info', response.message);
            }

            if (response.data.redirect_url) {
                window.location.href = response.data.redirect_url;
            }
        },
        complete: function () {
            setTimeout(function () {
                btnLoader(elBtn);
            }, 1000);
        }
    });
});
</script>
