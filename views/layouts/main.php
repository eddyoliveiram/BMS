<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
$this->registerLinkTag(['rel' => 'stylesheet', 'href' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css']);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
	<?php
	NavBar::begin([
		'brandLabel' => Yii::$app->name,
		'brandUrl' => Yii::$app->homeUrl,
		'options' => ['class' => 'navbar-expand-md navbar-dark bg-primary fixed-top']
	]);

	$menuItems = [];
	if (!Yii::$app->user->isGuest) {
		$menuItems[] = ['label' => '<i class="fas fa-book"></i> Books',
            'url' => ['/book/index'],
            'encode' => false];
		$menuItems[] = ['label' => '<i class="fas fa-cloud-sun-rain"></i> Weather (API)',
            'url' => ['/api/index'],
            'encode' => false];
		$menuItems[] = ['label' => '<i class="fas fa-sign-out-alt"></i> Logout',
            'url' => ['/index/logout'],
            'linkOptions' => ['data-method' => 'post'],
			'encode' => false];
	}

	echo Nav::widget([
		'options' => ['class' => 'navbar-nav ms-auto flex-nowrap'],
		'items' => $menuItems,
	]);

	NavBar::end();
	?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
		<?php if (!empty($this->params['breadcrumbs'])): ?>
			<?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
		<?php endif ?>
		<?= Alert::widget() ?>
		<?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
