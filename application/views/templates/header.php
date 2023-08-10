<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta name="robots" content="noindex">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<title><?php echo isset($meta_title) ? $meta_title : $this->config->item('meta_title'); ?></title>
<meta name="description" content="<?php echo isset($meta_description) ? $meta_description : $this->config->item('meta_description'); ?>">
<meta name="keywords" content="<?php echo isset($meta_keyword) ? $meta_keyword : $this->config->item('meta_keyword'); ?>">
<meta name="theme-color" content="<?php echo $this->config->item('theme_color'); ?>">
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo base_url(); ?>">
<meta property="og:title" content="<?php echo isset($meta_title) ? $meta_title : $this->config->item('meta_title'); ?>">
<meta property="og:description" content="<?php echo isset($meta_description) ? $meta_description : $this->config->item('meta_description'); ?>">
<meta property="og:image" content="<?php echo isset($meta_image) ? $meta_image : base_url('assets/img/favicon.ico'); ?>">
<meta property="og:image:secure_url" content="<?php echo isset($meta_image) ? $meta_image : base_url('assets/img/favicon.ico'); ?>">
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="<?php echo base_url(); ?>">
<meta property="twitter:title" content="<?php echo isset($meta_title) ? $meta_title : $this->config->item('meta_title'); ?>">
<meta property="twitter:description" content="<?php echo isset($meta_description) ? $meta_description : $this->config->item('meta_description'); ?>">
<meta property="twitter:image" content="<?php echo isset($meta_image) ? $meta_image : base_url('assets/img/favicon.ico'); ?>">
<link rel="icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
<link rel="apple-touch-icon" href="<?php echo base_url('assets/favicon.ico'); ?>">
<link rel="manifest" href="/manifest.json">
<link rel="canonical" href="<?php echo current_url(); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/fonts/font-awesome/css/all.min.css'); ?>" as="style">
<link rel="preload" href="<?php echo base_url('assets/css/app.min.css'); ?>" as="style">
<link rel="preload" href="<?php echo base_url('assets/css/globals.min.css'); ?>" as="style">
<link rel="preload" href="<?php echo base_url('assets/css/main.min.css'); ?>" as="style">
<link rel="preload" href="<?php echo base_url('assets/js/jquery.min.js'); ?>" as="script">
<link rel="stylesheet" href="<?php echo base_url('assets/css/app.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/globals.min.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/css/main.min.css'); ?>">
<script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
<script>const BASE_URL = '<?php echo base_url(); ?>';</script>
</head>
<body>
<div id="loading"></div>
<noscript>
<style>
.noscript {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #fff;
    width: 100vw;
    height: 100vh;
    z-index: 9999;
}
.noscript span {
    margin-top: 24px;
    font-size: 24px;
    font-weight: 600;
    color: #343434;
}
body {
    overflow: hidden;
}
</style>
<div class="noscript">
    <span><?php echo $this->lang->line('message_javascript_required'); ?></span>
</div>
</noscript>
<div class="app">
