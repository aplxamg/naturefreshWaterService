<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
//use yii\bootstrap\NavBar;
use yii\helpers\BaseUrl;
use yii\helpers\Url;
use app\assets\CommonAsset;
use app\components\helpers\User;
use app\models\Modules;
use app\models\ModuleCategory;

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
        <header id="commonLayout">
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
                    <img alt="DashCodes" src='/resources/common/logo.png' style='width: 250px;'>
                  </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <?php if (!Yii::$app->user->isGuest) {
                        $name = ucfirst($identity->username);
                        $nav = [
                            'options' => ['class' => 'nav navbar-nav navbar-right'],
                            'activateParents' => 'true',
                            'activateItems' => true,
                            'route' => empty(Yii::$app->controller->route_nav) ? Yii::$app->request->pathInfo : Yii::$app->controller->route_nav,
                            'items' => [
                                    [
                                        'label'    => Yii::t('app', 'Dashboard'),
                                        'url'      => [Yii::$app->request->baseUrl.'/dashboard']
                                    ],
                                    [
                                        'label'        => Yii::t('app', 'Features'),
                                        'options'      => ['class'=>'dropdown'],
                                        'linkOptions'  => [
                                        'class'    => 'dropdown-toggle',
                                        'data-toggle' => 'dropdown'
                                        ],
                                        'items'		   => [

                                        ]
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
                        $params = ['status' => 'active'];
                        $categories = ModuleCategory::getCategories($params);
                        $modules = Modules::getModules($params);
                        $newNavItems = array();
                        $newNavItems = $nav['items'];
                        $featuresNav = $newNavItems[1]['items'];
                        $categoryCounter=0;

                        foreach ($categories as $category) {
                            $temp = '<li class="dropdown-header">' .  Yii::t('app',$category->name." Features"). '</li>'; //show category
                            array_push($featuresNav, $temp);

                            foreach ($modules as $module) {
                                if($category->id == $module->cat_id) {
                                    $menuItemUrl = Yii::$app->request->baseUrl . $module->url;
                                    $menuItemUrl = (empty($menuItemUrl)) ? '/dashboard' : $menuItemUrl;
                                    $temp = [ //add menu item if in that category
                                        'label' => Yii::t('app',$module->name),
                                        'url'	=> [$menuItemUrl]
                                    ];
                                    array_push($featuresNav, $temp);
                                }
                            }

                            if ($categoryCounter != count($categories)-1) { //if not last , add divider
                                $temp = '<li class="divider"></li>';
                                array_push($featuresNav, $temp);
                            }

                            $categoryCounter++;
                        }
                        $newNavItems[1]['items'] =  $featuresNav;
                        $nav['items'] = $newNavItems;

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
