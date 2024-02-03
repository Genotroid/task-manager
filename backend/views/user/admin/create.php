<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\bootstrap4\Nav;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View        $this
 * @var \Da\User\Model\User $user
 */

$this->title = Yii::t('usuario', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('usuario', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?= $this->render('@app/views/user/shared/_menu') ?>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-body">
                                <?= Nav::widget([
                                        'options' => [
                                            'class' => 'nav flex-column nav-pills',
                                        ],
                                        'items' => [
                                            [
                                                'label' => Yii::t('usuario', 'Account details'),
                                                'url' => ['/user/admin/create'],
                                            ],
                                            [
                                                'label' => Yii::t('usuario', 'Profile details'),
                                                'options' => [
                                                    'class' => 'disabled',
                                                    'onclick' => 'return false;',
                                                ],
                                            ],
                                            [
                                                'label' => Yii::t('usuario', 'Information'),
                                                'options' => [
                                                    'class' => 'disabled',
                                                    'onclick' => 'return false;',
                                                ],
                                            ],
                                        ],
                                    ]
                                ) ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <?= Yii::t('usuario', 'Credentials will be sent to the user by email') ?>.
                                    <?= Yii::t(
                                    'usuario',
                                    'A password will be generated automatically if not provided'
                                ) ?>.
                                </div>
                                <?php $form = ActiveForm::begin(
                                        [
                                        'layout' => 'horizontal',
                                        'enableAjaxValidation' => true,
                                        'enableClientValidation' => false,
                                        'fieldConfig' => [
                                            'horizontalCssClasses' => [
                                                'wrapper' => 'col-sm-9',
                                            ],
                                        ],
                                    ]
                                    ); ?>

                                <?= $this->render('_user', ['form' => $form, 'user' => $user]) ?>

                                <div class="form-group">
                                    <div class="offset-lg-2 col-lg-9">
                                        <?= Html::submitButton(
                                    Yii::t('usuario', 'Save'),
                                    ['class' => 'btn btn-block btn-success']
                                ) ?>
                                    </div>
                                </div>

                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

