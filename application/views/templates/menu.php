<style>
    .nav-menu {
        background-color: var(--color-white);
        width: 260px;
        height: 100%;
        visibility: hidden;
        transform: translateX(-100%);
        transition: transform .3s ease-in, visibility .3s ease-in;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        z-index: 1031;
    }

    .nav-menu .nav-content {
        display: flex;
        flex-direction: column;
        min-height: 100%;
    }

    .nav-menu.open {
        visibility: visible;
        transform: translateX(0);
    }

    .nav-menu .heading {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px 16px 12px;
        flex: 1 0 auto;
        position: relative;
        background-color: #002E5D;
    }

    .nav-menu .heading::before {
        content: ' ';
        display: block;
        width: 100%;
        height: 16px;
        background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1), rgba(255, 255, 255, .8), rgba(255, 255, 255, 0));
        position: absolute;
        left: 0;
        bottom: 2px;
        transform: translateY(100%);
        z-index: 2;
    }

    .nav-menu .heading span {
        color: var(--color-content-primary);
    }

    .nav-menu .main-menu {
        list-style-type: none;
        padding: 0;
        flex: 1 1 100%;
        padding: 16px;
        margin: 0;
        overflow: hidden auto;
        position: relative;
        -webkit-overflow-scrolling: touch;
    }

    .nav-menu .logo {
        display: flex;
    }

    .nav-menu .logo img {
        width: auto;
        height: 36px;
    }

    .nav-menu .menu {
        width: 100%;
    }

    .nav-menu .menu a {
        color: inherit;
        text-decoration: none;
        color: inherit;
        transition: color .2s ease;
    }

    .nav-menu .menu a:active {
        color: var(--color-primary);
    }

    .nav-menu .menu.active>.menu-item {
        background-color: rgba(var(--color-primary-rgb), 0.05);
        color: var(--color-primary);
    }

    .nav-menu .menu .menu-item {
        display: flex;
        padding: 6px 12px;
        width: 100%;
        border-radius: 8px;
        margin-bottom: 8px;
        color: var(--color-content-secondary);
    }

    .nav-menu .menu-item .waves-ripple {
        background-color: rgba(var(--color-primary-rgb), 0.05);
    }

    .nav-menu .has-sub>.menu-item::after {
        content: '\f105';
        display: block;
        font-family: 'Font Awesome 5 Pro';
        font-size: 12px;
        line-height: 24px;
        margin-left: 8px;
        transition: all .5s ease;
    }

    .nav-menu .has-sub.open>.menu-item {
        color: var(--color-primary);
    }

    .nav-menu .has-sub.open>.menu-item::after {
        transform: rotate(90deg);
    }

    .nav-menu .menu-item__label {
        line-height: 24px;
        flex: 1 1 100%;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .nav-menu .menu-item__icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 24px;
        height: 24px;
        font-size: 20px;
        margin-right: 12px;
    }

    .nav-menu .menu.active>.menu-item .menu-item__icon {
        font-weight: 900;
    }

    .nav-menu .sub-menu {
        display: none;
        list-style-type: none;
    }

    .nav-menu .menu.open .sub-menu {
        display: block;
        padding-left: 32px;
    }

    .nav-menu .menu.active.open>.menu-item {
        background-color: transparent;
        color: var(--color-primary);
    }

    .nav-menu .user {
        display: flex;
        align-items: center;
        max-width: 100%;
        padding: 16px;
        flex: 1 0 auto;
        position: relative;
    }

    .nav-menu .user::before {
        content: ' ';
        display: block;
        width: 100%;
        height: 32px;
        background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0), rgba(255, 255, 255, .8), rgba(255, 255, 255, 1));
        position: absolute;
        left: 0;
        top: 2px;
        transform: translateY(-100%);
        z-index: 1;
    }

    .nav-menu .user .profile-pic {
        flex: 1 0 auto;
    }

    .nav-menu .user .profile-pic .image {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: var(--color-primary);
        color: var(--color-white);
        font-weight: var(--font-weight-btn);
        font-size: 14px;
    }

    .nav-menu .user .detail {
        display: flex;
        flex-direction: column;
        flex: 1 1 100%;
        margin-left: 12px;
        margin-right: 12px;
        overflow: hidden;
    }

    .nav-menu .user .detail .name {
        font-size: 12px;
        line-height: 18px;
        font-weight: var(--font-weight-btn);
        color: var(--color-content-primary);
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .nav-menu .user .detail .email {
        font-size: 12px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }

    .nav-menu .user .action {
        flex: 1 0 auto;
    }

    .page-header {
        display: flex;
        flex-direction: column;
        margin-bottom: 24px;
    }

    .page-info {
        display: flex;
        flex-direction: column;
    }

    .page-title {
        font-size: 18px;
        line-height: 32px;
        padding-right: 16px;
    }

    .page-action {
        margin-top: 8px;
        align-self: flex-end;
    }

    @media (min-width: 768px) {
        .app-content {
            padding: 76px 24px 40px;
        }

        .page-header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 20px;
            line-height: 32px;
        }

        .page-action {
            margin-top: 0;
            align-self: unset;
        }
    }

    @media (min-width: 992px) {
        .nav-menu {
            visibility: visible;
            transform: translateX(0);
            border-right: 1px solid var(--color-gray-200);
        }

        .nav-menu .menu a:hover {
            color: var(--color-primary);
        }

        .app-content {
            margin-left: 260px;
            padding: 32px;
        }
    }

    @media (min-width: 1200px) {}
</style>
<div class="nav-top">
    <div class="container">
        <div class="nav-content">
            <a class="nav-toggle waves-effect" role="button" aria-expanded="false"></a>
            <a href="<?php echo base_url('overview'); ?>">
                <div class="logo">
                    <img class="lazyimg" data-src="<?php echo base_url('assets/logo-v1.gif'); ?>" alt="logo" title="Logo" width="148" height="36">
                </div>
            </a>
        </div>
    </div>
</div>
<div class="nav-menu">
    <div class="nav-content">
        <div class="heading">
            <a href="<?php echo base_url('overview'); ?>">
                <div class="logo">
                    <img class="lazyimg" data-src="<?php echo base_url('assets/logo.gif'); ?>" alt="logo" title="Logo" width="123" height="30">
                </div>
            </a>
        </div>
        <ul class="main-menu slimscroll">
            <li class="<?php echo @$menu_active == 'overview' ? 'menu active' : 'menu'; ?>">
                <a href="<?php echo base_url('overview'); ?>" class="menu-item waves-effect">
                    <i class="menu-item__icon far fa-th-large"></i>
                    <div class="menu-item__label">Overview</div>
                </a>
            </li>
            <li class="<?php echo @$menu_active == 'report' ? 'menu active' : 'menu'; ?>">
                <a href="<?php echo base_url('report'); ?>" class="menu-item waves-effect">
                    <i class="menu-item__icon far fa-id-card"></i>
                    <div class="menu-item__label">Report</div>
                </a>
            </li>
            <li class="<?php echo in_array(@$menu_active, ['user', 'file']) ? 'menu has-sub open' : 'menu has-sub'; ?>">
                <a class="menu-item waves-effect">
                    <i class="menu-item__icon far fa-pencil-ruler"></i>
                    <div class="menu-item__label">Preferences</div>
                </a>
                <ul class="sub-menu">
                    <li class="<?php echo @$menu_active == 'user' ? 'menu active' : 'menu'; ?>">
                        <a href="<?php echo base_url('user'); ?>" class="menu-item">
                            <div class="menu-item__label">User</div>
                        </a>
                    </li>
                    <li class="<?php echo @$menu_active == 'file' ? 'menu active' : 'menu'; ?>">
                        <a href="<?php echo base_url('file'); ?>" class="menu-item">
                            <div class="menu-item__label">Upload File Limit</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="user">
            <div class="profile-pic">
                <div class="image">
                    <div class="initial"><?php echo substr($userdata['first_name'], 0, 1); ?></div>
                </div>
            </div>
            <div class="detail">
                <div class="name"><?php echo $userdata['first_name'] . ' (' . @$userdata['role'][0]->name . ')'; ?></div>
                <div class="email"><?php echo $userdata['email']; ?></div>
            </div>
            <div class="action">
                <a href="<?php echo base_url('auth/logout'); ?>" data-toggle="tooltip" title="Logout" aria-labelledby="Logout">
                    <i class="fas fa-sign-out"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
    $('.nav-menu .main-menu > .has-sub > a').click(function(e) {
        e.preventDefault();

        let el = $(this);

        toggleMenu(el);
    });

    function toggleMenu(el) {
        if (el.parents('.has-sub').hasClass('open')) {
            el.siblings('.sub-menu').slideUp();
            setTimeout(function() {
                $('.nav-menu .main-menu > .has-sub').removeClass('open');
            }, 300);
        } else {
            $('.nav-menu .main-menu > .has-sub .sub-menu').slideUp();
            setTimeout(function() {
                $('.nav-menu .main-menu > .has-sub').removeClass('open');
                el.siblings('.sub-menu').slideDown('fast');
                el.parents('.has-sub').addClass('open');
            }, 200);
        }

        return true;
    }
</script>