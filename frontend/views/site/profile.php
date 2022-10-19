<?php
?>

<!--HEADER SECTION-->
<!--END HEADER SECTION-->


<!--SECTION START-->
<section>
    <div class="pro-cover">
    </div>
    <div class="pro-menu">
        <div class="container">
            <div class="col-md-9 col-md-offset-3">
                <ul>
                    <li><a href="db-profile.html" class="pro-act">Profile</a></li>
                    <li><a href="#!">Courses</a></li>
                    <li><a href="#!">Exams</a></li>
                    <li><a href="#!">Time Line</a></li>
                    <li><a href="<?=\yii\helpers\Url::to(['site/logout'])?>">Chiqish</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="stu-db">
        <div class="container pg-inn">
            <div class="col-md-3">
                <div class="pro-user">
                    <img src="<?= Yii::$app->user->identity->avatar->getSrc('medium') ?>" alt="user">
                </div>
                <div class="pro-user-bio">
                    <ul>
                        <li>
                            <h4><?= Yii::$app->user->identity->student->first_name . " " . Yii::$app->user->identity->student->last_name ?></h4>
                        </li>
                        <li>Student Id:ST<?= Yii::$app->user->identity->student->id ?></li>
                        <li><a href="#!"><i class="fa fa-facebook"></i> Facebook: ----</a></li>
                        <li><a href="#!"><i class="fa fa-google-plus"></i> Google: -----</a></li>
                        <li><a href="#!"><i class="fa fa-twitter"></i> Twitter: ------</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="udb">

                    <div class="udb-sec udb-prof">
                        <h4><img src="/images/icon/db1.png" alt=""/> My Profile</h4>
                        <p>Bu yerga oziz haqida malumot yozsangiz bo'ladi.</p>
                        <div class="sdb-tabl-com sdb-pro-table">
                            <table class="responsive-table bordered">
                                <tbody>
                                <tr>
                                    <td>Student Name</td>
                                    <td>:</td>
                                    <td><?= Yii::$app->user->identity->student->first_name ?></td>
                                </tr>
                                <tr>
                                    <td>Student Id</td>
                                    <td>:</td>
                                    <td>ST<?= Yii::$app->user->identity->student->id ?></td>
                                </tr>
                                <tr>
                                    <td>Eamil</td>
                                    <td>:</td>
                                    <td><?= Yii::$app->user->identity->email ?></td>
                                </tr>
                                <tr>
                                    <td>Phone</td>
                                    <td>:</td>
                                    <td><?= Yii::$app->user->identity->student->phone ?></td>
                                </tr>
                                <tr>
                                    <td>Date of birth</td>
                                    <td>:</td>
                                    <td><?= Yii::$app->user->identity->student->birthday ?></td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td>:</td>
                                    <td><?= Yii::$app->user->identity->student->address ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        <span class="db-done"><?= Yii::$app->user->identity->status == 10 ? "Active" : "In Active" ?></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="sdb-bot-edit">
                                <a href="#" class="waves-effect waves-light btn-large sdb-btn sdb-btn-edit"><i
                                            class="fa fa-pencil"></i> Edit my profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--SECTION END-->


<!--SECTION START-->
<section>
    <div class="full-bot-book">
        <div class="container">
            <div class="row">
                <div class="bot-book">
                    <div class="col-md-2 bb-img">
                        <img src="images/3.png" alt="">
                    </div>
                    <div class="col-md-7 bb-text">
                        <h4>therefore always free from repetition</h4>
                        <p>There are many variations of passages of Lorem Ipsum available, but the majority have
                            suffered alteration in some form, by injected humour</p>
                    </div>
                    <div class="col-md-3 bb-link">
                        <a href="course-details.html">Book This Course</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--SECTION END-->
