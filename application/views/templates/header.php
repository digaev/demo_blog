<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= APPNAME . (htmlspecialchars(isset($title) ? ' · ' . implode(' · ', is_array($title) ? $title : [$title]) : '')) ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-theme.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= base_url() ?>"><?= APPNAME ?></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="<?= $this->router->fetch_class() == 'blogposts' && $this->router->fetch_method() == 'index' ? 'active' : '' ?>">
                        <a href="<?= base_url() ?>"><i class="glyphicon glyphicon-home"></i>&nbsp;Home</a>
                    </li>
                    <?php if ($this->session->is_logged): ?>
                    <li class="<?= $this->router->fetch_class() == 'blogposts' && $this->router->fetch_method() == 'create' ? 'active' : '' ?>">
                        <a href="<?= base_url('blogposts/create') ?>"><i class="glyphicon glyphicon-pencil"></i>&nbsp;New article</a>
                    </li>
                    <?php endif ?>
                </ul>

                <?php if ($this->session->is_logged === true): ?>
                <form class="navbar-form navbar-right">
                    <a class="btn btn-success" href="<?= base_url('users/signout') ?>">
                        <i class="glyphicon glyphicon-log-out"></i>
                        <span>Sign out (<?= htmlspecialchars($this->session->user_username) ?>)</span>
                    </a>
                </form>
                <?php else: ?>
                <?= form_open('users/signin', ['class' => 'navbar-form navbar-right']) ?>
                    <div class="form-group">
                        <input id="" class="form-control" type="text" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input id="" class="form-control" type="password" name="password" placeholder="Password">
                    </div>
                    <button class="btn btn-success" type="submit">
                        <i class="glyphicon glyphicon-log-in"></i>
                        <span>Sign in</span>
                    </button>
                    <a class="btn btn-primary" href="<?= base_url('users/signup') ?>">
                        <span>Sign up</span>
                    </a>
                <?= form_close() ?>
                <?php endif ?>
            </div>
        </div>
    </div>

    <div class="container">

