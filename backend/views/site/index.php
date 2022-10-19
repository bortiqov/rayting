<?php

/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $courseDataProvider \yii\data\ActiveDataProvider
 */
/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Home';
?>

>
<div class="sb2-2">
    <!--== breadcrumbs ==-->
    <div class="sb2-2-2">
        <ul>
            <li><a href="index-2.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
            </li>
            <li class="active-bre"><a href="#"> Dashboard</a>
            </li>
            <li class="page-back"><a href="index-2.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
            </li>
        </ul>
    </div>
    <!--== DASHBOARD INFO ==-->
    <div class="sb2-2-1">
        <h2>Boshqaruv paneli</h2>
        <p>Boshqaruv paneli yordamida siz tizimni to'liq boshqarishingiz mumkim</p>
        <div class="db-2">
            <ul>
                <li>
                    <div class="dash-book dash-b-1">
                        <h5>Barcha kurslar</h5>
                        <h4><?= $courseDataProvider->count ?></h4>
                        <a href="<?= \yii\helpers\Url::to(['course/index']) ?>">Ko'rish</a>
                    </div>
                </li>
                <li>
                    <div class="dash-book dash-b-2">
                        <h5>O'quvchilar</h5>
                        <h4><?= $dataProvider->count ?></h4>
                        <a href="<?= \yii\helpers\Url::to(['student/index']) ?>">Ko'rish</a>
                    </div>
                </li>

                <li>
                    <div class="dash-book dash-b-2">
                        <h5>Guruhlar</h5>
                        <h4><?= $dataProvider->count ?></h4>
                        <a href="<?= \yii\helpers\Url::to(['student/index']) ?>">Ko'rish</a>
                    </div>
                </li>

            </ul>
        </div>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Student ma'lumotlari</h4>
                        <p>All about students like name, student id, phone, email, country, city and more</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Avatar</th>
                                    <th>Full name</th>
                                    <th>Tel nomer</th>
                                    <th>Address</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <td>
                                            <span class="list-img"><img src="<?= $model->user->avatar ? $model->user->avatar->getSrc('small') : "/images/course/sm-1.jpg" ?>" alt=""></span>
                                        </td>
                                        <td><a href="<?= Url::to(['/student/view', 'id' => $model->id]) ?>">
                                                <span class="list-enq-name"><?= $model->first_name . " " . $model->last_name ?></span></a>
                                        </td>
                                        <td><?= $model->phone ?></td>
                                        <td><?= $model->address ?></td>
                                        <td><?= $model->user->username ?></td>
                                        <td><?= $model->user->email ?></td>
                                        <td>
                                            <span class="label label-success">Active</span>
                                        </td>
                                        <td><a href="<?= Url::to(['student/update', 'id' => $model->id]) ?>"
                                               class="ad-st-view">Edit</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--== User Details ==-->
    <div class="sb2-2-3">
        <div class="row">
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Course Details</h4>
                        <p>All about courses, program structure, fees, best course lists (ranking), syllabus, teaching
                            techniques and other details.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Rasm</th>
                                    <th>Kurs Nomi</th>
                                    <th>Turi</th>
                                    <th>Davomiyligi</th>
                                    <th>Boshlanish vaqti</th>
                                    <th>Narxi</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($courseDataProvider->getModels() as $index => $model): ?>
                                    <tr>
                                        <td><span class="list-img"><img src="/images/course/sm-1.jpg"
                                                                        alt=""></span>
                                        </td>
                                        <td><a href="<?= Url::to(['/course/view', 'id' => $model->id]) ?>">
                                                <span class="list-enq-name"><?= $model->name ?></span></a>
                                        </td>
                                        <td><?= $model->name ?></td>
                                        <td>davomiyligi</td>
                                        <td><?= $model->start_date?></td>
                                        <td><?= $model->price ?></td>
                                        <td>
                                            <span class="label label-success">Active</span>
                                        </td>
                                        <td><a href="<?= Url::to(['course/update', 'id' => $model->id]) ?>"
                                               class="ad-st-view">Edit</a></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="sb2-2-3">
        <div class="row">
            <!--== Listing Enquiry ==-->
            <div class="col-md-12">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Exam Time Tables</h4>
                        <p>Education is about teaching, learning skills and knowledge.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Degree</th>
                                    <th>Exam Name</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Timing</th>
                                    <th>View</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="filled-in" id="filled-in-box-1"
                                               checked="checked"/>
                                        <label for="filled-in-box-1"></label>
                                    </td>
                                    <td>MBA</td>
                                    <td><span class="list-enq-name">Civil engineering</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>10:00am</td>
                                    <td>01:00pm</td>
                                    <td>03:00Hrs</td>
                                    <td>
                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="filled-in" id="filled-in-box-2"/>
                                        <label for="filled-in-box-2"></label>
                                    </td>
                                    <td>MBA</td>
                                    <td><span class="list-enq-name">Google Business</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>10:00am</td>
                                    <td>01:00pm</td>
                                    <td>03:00Hrs</td>
                                    <td>
                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="filled-in" id="filled-in-box-3"/>
                                        <label for="filled-in-box-3"></label>
                                    </td>
                                    <td>MBA</td>
                                    <td><span class="list-enq-name">Statistics</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>10:00am</td>
                                    <td>01:00pm</td>
                                    <td>03:00Hrs</td>
                                    <td>
                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="filled-in" id="filled-in-box-4"/>
                                        <label for="filled-in-box-4"></label>
                                    </td>
                                    <td>MBA</td>
                                    <td><span class="list-enq-name">Business Management</span><span
                                                class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>10:00am</td>
                                    <td>01:00pm</td>
                                    <td>03:00Hrs</td>
                                    <td>
                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="filled-in" id="filled-in-box-5"/>
                                        <label for="filled-in-box-5"></label>
                                    </td>
                                    <td>MBA</td>
                                    <td><span class="list-enq-name">Art/Design</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>10:00am</td>
                                    <td>01:00pm</td>
                                    <td>03:00Hrs</td>
                                    <td>
                                        <a href="admin-exam.html" class="ad-st-view">View</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--== Latest Activity ==-->
    <div class="sb2-2-3">
        <div class="row">
            <!--== Latest Activity ==-->
            <div class="col-md-6">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Latest Activity</h4>
                        <p>Education is about teaching, learning skills and knowledge.</p>
                    </div>
                    <div class="tab-inn list-act-hom">
                        <ul>
                            <li class="list-act-hom-con">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <h4><span>12 may, 2017</span> Welcome to Academy</h4>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour.</p>
                            </li>
                            <li class="list-act-hom-con">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <h4><span>08 Jun, 2017</span> Academy Leadership</h4>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour.</p>
                            </li>
                            <li class="list-act-hom-con">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <h4><span>27 July, 2017</span> Awards and Achievement</h4>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour.</p>
                            </li>
                            <li class="list-act-hom-con">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <h4><span>14 Aug, 2017</span> Facilities and Management</h4>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour.</p>
                            </li>
                            <li class="list-act-hom-con">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                <h4><span>24 Sep, 2017</span> Nation award winning 2017</h4>
                                <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                                    suffered alteration in some form, by injected humour.</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!--== Social Media ==-->
            <div class="col-md-6">
                <div class="box-inn-sp">
                    <div class="inn-title">
                        <h4>Social Media</h4>
                        <p>Education is about teaching, learning skills and knowledge.</p>
                    </div>
                    <div class="tab-inn">
                        <div class="table-responsive table-desi">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Media</th>
                                    <th>Name</th>
                                    <th>Share</th>
                                    <th>Like</th>
                                    <th>Members</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/1.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">Linked In</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/2.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">Twitter</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/3.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">Facebook</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/4.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">Google Plus</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/5.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">YouTube</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/6.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">WhatsApp</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/7.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">VK</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><span class="list-img"><img src="images/sm/2.png" alt=""></span>
                                    </td>
                                    <td><span class="list-enq-name">Twitter</span><span class="list-enq-city">Illunois, United States</span>
                                    </td>
                                    <td>15K</td>
                                    <td>18K</td>
                                    <td>
                                        <span class="label label-success">263</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--== User Details ==-->
</div>

