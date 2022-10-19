<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100 bg-secondary">
    <?php $this->beginBody() ?>
    <div class="container-fluid sb1">
        <div class="row">
            <!--== LOGO ==-->
            <div class="col-md-2 col-sm-3 col-xs-6 sb1-1">
                <a href="#" class="btn-close-menu"><i class="fa fa-times" aria-hidden="true"></i></a>
                <a href="#" class="atab-menu"><i class="fa fa-bars tab-menu" aria-hidden="true"></i></a>
                <a href="/" class="logo"><h3>Bahodir BMI.uz</h3>
                </a>
            </div>
            <!--== SEARCH ==-->
            <div class="col-md-6 col-sm-6 mob-hide">
                <form class="app-search">
                    <input type="text" placeholder="Search..." class="form-control">
                    <a href="#"><i class="fa fa-search"></i></a>
                </form>
            </div>
            <!--== NOTIFICATION ==-->
            <div class="col-md-2 tab-hide">
                <div class="top-not-cen">
                    <a class='waves-effect btn-noti' href="admin-all-enquiry.html" title="all enquiry messages"><i
                                class="fa fa-commenting-o" aria-hidden="true"></i><span>5</span></a>
                    <a class='waves-effect btn-noti' href="admin-course-enquiry.html" title="course booking messages"><i
                                class="fa fa-envelope-o" aria-hidden="true"></i><span>5</span></a>
                    <a class='waves-effect btn-noti' href="admin-admission-enquiry.html" title="admission enquiry"><i
                                class="fa fa-tag" aria-hidden="true"></i><span>5</span></a>
                </div>
            </div>
            <!--== MY ACCCOUNT ==-->
            <div class="col-md-2 col-sm-3 col-xs-6">
                <!-- Dropdown Trigger -->
                <a class='waves-effect dropdown-button top-user-pro' href='#' data-activates='top-menu'><img
                            src="images/user/6.png" alt=""/>My Account <i class="fa fa-angle-down"
                                                                          aria-hidden="true"></i>
                </a>

                <!-- Dropdown Structure -->
                <ul id='top-menu' class='dropdown-content top-menu-sty'>
                    <li><a href="admin-panel-setting.html" class="waves-effect"><i class="fa fa-cogs"
                                                                                   aria-hidden="true"></i>Admin Setting</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?=\yii\helpers\Url::to(['site/logout'])?>" class="ho-dr-con-last waves-effect"><i class="fa fa-sign-in" aria-hidden="true"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container-fluid sb2">
        <div class="row">
            <div class="sb2-1">
                <!--== USER INFO ==-->
                <div class="sb2-12 mt-5">
                    <ul>
                        <li><img src="images/placeholder.jpg" alt="">
                        </li>
                        <li>
                            <h5><?= Yii::$app->user->identity->email ?><span></span></h5>
                        </li>
                    </ul>
                </div>
                <!--== LEFT MENU ==-->
                <div class="sb2-13">
                    <ul class="collapsible" data-collapsible="accordion">
                        <li><a href="<?= \yii\helpers\Url::to(['/']) ?>" class="menu-active"><i class="fa fa-bar-chart"
                                                                                                aria-hidden="true"></i>
                                Dashboard</a>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-book"
                                                                                       aria-hidden="true"></i> All
                                Courses</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="<?= \yii\helpers\Url::to(['course/index']) ?>">All Course</a>
                                    </li>
                                    <li><a href="<?= \yii\helpers\Url::to(['course/create']) ?>">Add New Course</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-users"
                                                                                       aria-hidden="true"></i>Users</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="<?= \yii\helpers\Url::to(['employee/index']) ?>">All User</a>
                                    </li>
                                    <li><a href="<?= \yii\helpers\Url::to(['employee/create']) ?>">Add New user</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-user"
                                                                                       aria-hidden="true"></i>Students</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="<?= \yii\helpers\Url::to(['/student/index']) ?>">All Students</a>
                                    </li>
                                    <li><a href="<?= \yii\helpers\Url::to(['/student/create']) ?>">Add New Student</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-user"
                                                                                       aria-hidden="true"></i>Group</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="<?= \yii\helpers\Url::to(['/group/index']) ?>">All Group</a>
                                    </li>
                                    <li><a href="<?= \yii\helpers\Url::to(['/group/create']) ?>">Create new group</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li><a href="javascript:void(0)" class="collapsible-header">
                                <i class="fa fa-calendar" aria-hidden="true"></i>Events</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="admin-event-all.html">All Events</a>
                                    </li>
                                    <li><a href="admin-event-add.html">Create New Events</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header">
                                <i class="fa fa-bullhorn" aria-hidden="true"></i>Seminar</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="admin-seminar-all.html">All Seminar</a>
                                    </li>
                                    <li><a href="admin-seminar-add.html">Create New Seminar</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-graduation-cap"
                                                                                       aria-hidden="true"></i> Job
                                Vacants</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="admin-job-all.html">All Jobs</a>
                                    </li>
                                    <li><a href="admin-job-add.html">Create New Job</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="javascript:void(0)" class="collapsible-header">
                                <i class="fa fa-pencil" aria-hidden="true"></i> Exam time
                                table</a>
                            <div class="collapsible-body left-sub-menu">
                                <ul>
                                    <li><a href="admin-exam-all.html">All Exams</a></li>
                                    <li><a href="admin-exam-add.html">Add New Exam</a></li>
                                    <li><a href="admin-exam-group-all.html">All Groups</a></li>
                                    <li><a href="admin-exam-group-add.html">Create New Groups</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <?= $content ?>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
