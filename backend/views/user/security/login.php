<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use deyraka\materialdashboard\widgets\Card;

/**
 * @var yii\web\View            $this
 * @var \Da\User\Form\LoginForm $model
 * @var \Da\User\Module         $module
 */

Yii::$app->controller->layout = '@app/views/layouts/login';

$this->title = Yii::t('usuario', 'Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-container">
    <?php 
        Card::begin([  
            'id' => 'login-card', 
            'color' => Card::COLOR_INFO, 
            'headerIcon' => 'fingerprint', 
            'collapsable' => false, 
            'title' => Yii::$app->name, 
            'titleTextType' => Card::TYPE_INFO, 
            'showFooter' => false,
        ]) ?>
            <?php $form = ActiveForm::begin(
                    [
                        'id' => $model->formName(),
                        'layout' => 'horizontal',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validateOnBlur' => false,
                        'validateOnType' => false,
                        'validateOnChange' => false,
                        'fieldConfig' => [
                            'template' => "<div class=\"d-flex flex-row w-100 align-items-center\">
                            {label}{input}
                            </div>\n<div>{error}</div>",
                            'labelOptions' => ['class' => 'control-label h-100 d-flex align-items-end col-2'],
                            'inputOptions' => ['class' => 'col-10'],
                        ],
                    ]
                ) ?>
                <?= $form->field(
                    $model,
                    'login',
                    ['inputOptions' => ['autofocus' => 'autofocus', 'class' => 'form-control', 'tabindex' => '1']]
                ) ?>

                <?= $form
                    ->field(
                        $model,
                        'password',
                        ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']]
                    )
                    ->passwordInput()
                    ->label(
                        Yii::t('usuario', 'Password')
                        . ($module->allowPasswordRecovery ?
                            ' (' . Html::a(
                                Yii::t('usuario', 'Forgot password?'),
                                ['/user/recovery/request'],
                                ['tabindex' => '5']
                            )
                            . ')' : '')
                    ) ?>

                <?= $form->field($model, 'rememberMe')->checkbox(['tabindex' => '4']) ?>

                <div class="form-group">
                    <div class="col-lg-offset-1">
                        <?= Html::submitButton(Yii::t('usuario', 'Sign in'), [
                            'class' => 'btn btn-primary', 
                            'name' => 'login-button', 
                            'tab-index' => 3
                        ]) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
    <?php Card::end(); ?>
</div>
