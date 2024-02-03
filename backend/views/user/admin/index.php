<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/**
 * @var $this         yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $searchModel  Da\User\Search\UserSearch
 * @var $module       Da\User\Module
 */

$this->title = Yii::t('usuario', 'Manage users');
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('user');
?>

<?php $this->beginContent('@app/views/user/shared/admin_layout.php') ?>

<?php Pjax::begin() ?>
<div class="table-responsive">
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{pager}",
            'columns' => [
                'username',
                'email:email',
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        if (extension_loaded('intl')) {
                            return Yii::t('usuario', '{0, date, MMM dd, YYYY HH:mm}', [$model->created_at]);
                        }

                        return date('Y-m-d G:i:s', $model->created_at);
                    },
                ],
                [
                    'attribute' => 'last_login_at',
                    'value' => function ($model) {
                        if (!$model->last_login_at || $model->last_login_at == 0) {
                            return Yii::t('usuario', 'Never');
                        } elseif (extension_loaded('intl')) {
                            return Yii::t('usuario', '{0, date, MMM dd, YYYY HH:mm}', [$model->last_login_at]);
                        } else {
                            return date('Y-m-d G:i:s', $model->last_login_at);
                        }
                    },
                ],
                'password_age',
                [
                    'header' => Yii::t('usuario', 'Block status'),
                    'value' => function ($model) {
                        if ($model->isBlocked) {
                            return Html::a(
                                Yii::t('usuario', 'Unblock'),
                                ['block', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-sm btn-success btn-block',
                                    'data-method' => 'post',
                                    'data-confirm' => Yii::t('usuario', 'Are you sure you want to unblock this user?'),
                                ]
                            );
                        }

                        return Html::a(
                            Yii::t('usuario', 'Block'),
                            ['block', 'id' => $model->id],
                            [
                                'class' => 'btn btn-sm btn-outline-danger btn-block',
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('usuario', 'Are you sure you want to block this user?'),
                            ]
                        );
                    },
                    'format' => 'raw',
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{switch} {reset} {force-password-change} {update} {delete}',
                    'buttons' => [
                        'switch' => function ($url, $model) use ($module) {
                            if ($model->id != Yii::$app->user->id && $module->enableSwitchIdentities) {
                                return Html::a(
                                    '<span class="fas fa-user-alt"></span>',
                                    ['/user/admin/switch-identity', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-outline-primary btn-sm',
                                        'title' => Yii::t('usuario', 'Impersonate this user'),
                                        'data-confirm' => Yii::t(
                                            'usuario',
                                            'Are you sure you want to switch to this user for the rest of this Session?'
                                        ),
                                        'data-method' => 'POST',
                                    ]
                                );
                            }

                            return null;
                        },
                        'reset' => function ($url, $model) use ($module) {
                            if($module->allowAdminPasswordRecovery) {
                                return Html::a(
                                    '<span class="fas fa-mail-bulk"></span>',
                                    ['/user/admin/password-reset', 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-outline-primary btn-sm',
                                        'title' => Yii::t('usuario', 'Send password recovery email'),
                                        'data-confirm' => Yii::t(
                                            'usuario',
                                            'Are you sure you wish to send a password recovery email to this user?'
                                        ),
                                        'data-method' => 'POST',
                                    ]
                                );
                            }

                            return null;
                        },
                        'force-password-change' => function ($url, $model) use ($module) {
                            if (is_null($module->maxPasswordAge)) {
                                return null;
                            }
                            return Html::a(
                                '<span class="fas fa-times-circle"></span>',
                                ['/user/admin/force-password-change', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-outline-primary btn-sm',
                                    'title' => Yii::t('usuario', 'Force password change at next login'),
                                    'data-confirm' => Yii::t(
                                        'usuario',
                                        'Are you sure you wish the user to change their password at next login?'
                                    ),
                                    'data-method' => 'POST',
                                ]
                            );
                        },
                        'update' => function ($url, $model) use ($module) {
                            return Html::a(
                                '<span class="fas fa-user-edit"></span>',
                                ['/user/admin/update', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-outline-primary btn-sm',
                                    'title' => Yii::t('yii', 'Update'),
                                ]
                            );
                        },
                        'delete' => function ($url, $model) use ($module) {
                            if ($model->id === Yii::$app->user->id) {
                                return null;
                            }

                            return Html::a(
                                '<span class="fas fa-trash-alt"></span>',
                                ['/user/admin/delete', 'id' => $model->id],
                                [
                                    'class' => 'btn btn-outline-danger btn-sm',
                                    'title' => Yii::t('usuario', 'Delete'),
                                    'data-confirm' => Yii::t(
                                        'usuario',
                                        'Are you sure you want to delete this user?'
                                    ),
                                    'data-method' => 'POST',
                                ]
                            );
                        }
                    ]
                ],
            ],
        ]
    ); ?>
</div>
<?php Pjax::end() ?>

<?php $this->endContent() ?>
