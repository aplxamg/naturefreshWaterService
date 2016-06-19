<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use app\assets\CommonAsset;
use app\components\helpers\User;

CommonAsset::register($this);
$identity = User::initUser();
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
    <div class="common-wrapper">
        <header>
            <nav class="navbar">
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="#">
                    <img alt="DashCodes" src='/resources/common/logo2.PNG'>
                  </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <?php if (!Yii::$app->user->isGuest) {
                        $name = $identity->username;
                        $nav = [
                            'options' => ['class' => 'nav navbar-nav navbar-right'],
                            'activateParents' => 'true',
                            'route' => empty(Yii::$app->controller->route_nav) ? Yii::$app->request->pathInfo : Yii::$app->controller->route_nav,
                            'items' => [
                                 [
                                    'label'    => Yii::t('app', 'Dashboard'),
                                    'url'      => [Yii::$app->request->baseUrl.'/dashboard']
							     ],
                                [
                                    'label'        => $name,
                                    'options'      => ['class'=>'dropdown'],
                                    'linkOptions'  => [
                                        'class'    => 'dropdown-toggle',
                                        'data-toggle' => 'dropdown'
                                    ],
                                    'items'		   => [
                                        [
                                            'label' => Yii::t('app', 'Logout'),
                                            'url'   => [Yii::$app->request->baseUrl.'/logout']
                                        ],
                                    ]
                                ]
                            ]
                        ];
                        echo Nav::widget($nav);
                     } else {
                        echo Nav::widget([
                            'options' => ['class' => 'nav navbar-nav navbar-right'],
                            'items' => [
                                [
                                    'label'    => Yii::t('app', 'Login'),
                                    'url'      => [Yii::$app->request->baseUrl.'/login'],
                                    'options'=> ['class'=>'active']
                                ]
                            ]
                        ]);
                    } ?>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav>
        </header>
        <div class="container-fluid common-container">
            <?= $content ?>
        </div>
    </div>

    <footer class="common-footer">
      <div id="footer" class="center-block text-center">
        Copyright &copy; <?= date('Y'); ?> DashCodes. All rights reserved
      </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
