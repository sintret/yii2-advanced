<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?> - <?php echo Yii::$app->name; ?></title>
        <?php $this->head() ?>
    </head>
    <?php $this->beginBody() ?>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo Url::to(['site/index']); ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <?php echo Yii::$app->name; ?>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <?php echo \sintret\gii\models\Notification::notification(); ?>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo Yii::$app->user->identity->username; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?php echo yii::$app->user->identity->thumbnailTrue; ?>" class="img-circle" alt="<?php echo Yii::$app->user->identity->username; ?>" />
                                    <p>
                                        <?php echo Yii::$app->user->identity->username . ' - ' . Yii::$app->user->identity->position; ?>
                                        <small>Member since <?php echo date('F Y', strtotime(Yii::$app->user->identity->createDate)); ?> </small>
                                    </p>
                                </li>                                
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo Url::to(['site/me']); ?>" class="btn btn-default btn-flat">Profile</a>
                                    </div>

                                    <div class="pull-right">
                                        <?php echo Html::a('Sign Out', Url::to(['site/logout']), ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']); ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo yii::$app->user->identity->thumbnailTrue; ?>" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo Yii::$app->user->identity->username; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <select class="form-control" id="selectBranch" name="selectBranch">
                                <option value="0">PT ABCD</option>
                                <option value="2">Bali</option>
                                <option value="3">Bandung</option>
                                <option value="1">Jakarta</option>
                            </select>
                            <span class="input-group-btn">
                                <button type='button' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-angle-down"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo Url::to(['site/index']); ?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="glyphicon glyphicon-th-list"></i> <span>Master Data</span>
                                <i class="fa pull-right fa-angle-down"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a style="margin-left: 20px;" href="<?php echo Yii::$app->urlManager->createUrl(['about/update', 'id' => 1]); ?>"><i class="fa fa-angle-double-right"></i> About</a></li>
                                <li><a style="margin-left: 20px;" href="<?php echo Yii::$app->urlManager->createUrl('store/index'); ?>"><i class="fa fa-angle-double-right"></i> Store Locator</a></li>
                                <li><a style="margin-left: 20px;" href="<?php echo Yii::$app->urlManager->createUrl('color/index'); ?>"><i class="fa fa-angle-double-right"></i> Color</a></li>
                                <li><a style="margin-left: 20px;" href="<?php echo Yii::$app->urlManager->createUrl('size/index'); ?>"><i class="fa fa-angle-double-right"></i> Size</a></li>
                                <li><a style="margin-left: 20px;" href="<?php echo Yii::$app->urlManager->createUrl('category/index'); ?>"><i class="fa fa-angle-double-right"></i> Category</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="<?php echo Url::to(['user/index']); ?>">
                                <i class="fa fa-user"></i> <span>Users</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Url::to(['setting/update','id'=>1]); ?>">
                                <i class="glyphicon glyphicon-cog"></i> <span>Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Url::to(['log-upload/index']); ?>">
                                <i class="glyphicon glyphicon-folder-open"></i> <span>Logs</span>
                            </a>
                        </li>

                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small><?php echo $this->title; ?></small>
                    </h1>
                    <?=
                    Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ])
                    ?>
                    <!--<ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>-->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="col-lg-12">
                        <?php
                        foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
                            echo '<div class="alert alert-' . $key . ' alert-dismissible"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>' . $message . '</div>';
                        }
                        ?>
                    </div>

                    <?php echo $content; ?>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- add new calendar event modal -->


        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
