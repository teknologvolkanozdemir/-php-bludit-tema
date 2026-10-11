<?php
if (!defined('BLUDIT')) {
	exit;
}
?>
<!doctype html>
<html lang="<?php echo htmlspecialchars(Theme::lang(), ENT_QUOTES, 'UTF-8'); ?>">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#315c45">
	<?php echo Theme::metaTagTitle(); ?>
	<?php echo Theme::metaTagDescription(); ?>
	<?php echo Theme::css('css/style.css'); ?>
	<?php Theme::plugins('siteHead'); ?>
</head>
<body>
	<a class="skip-link" href="#main-content">Atla: ana içeriğe geç</a>
	<?php Theme::plugins('siteBodyBegin'); ?>

	<header class="site-header">
		<div class="site-header__inner">
			<a class="site-name" href="<?php echo htmlspecialchars(Theme::siteUrl(), ENT_QUOTES, 'UTF-8'); ?>">
				<?php echo htmlspecialchars($site->title(), ENT_QUOTES, 'UTF-8'); ?>
			</a>
			<nav class="site-nav" aria-label="Ana gezinme">
				<ul>
					<li><a href="<?php echo htmlspecialchars(Theme::siteUrl(), ENT_QUOTES, 'UTF-8'); ?>">Ana sayfa</a></li>
					<?php if (!empty($staticContent) && is_array($staticContent)) : ?>
						<?php foreach ($staticContent as $staticPage) : ?>
							<li>
								<a href="<?php echo htmlspecialchars($staticPage->permalink(), ENT_QUOTES, 'UTF-8'); ?>"<?php if (isset($page) && $page && $page->key() === $staticPage->key()) : ?> aria-current="page"<?php endif; ?>>
									<?php echo htmlspecialchars($staticPage->title(), ENT_QUOTES, 'UTF-8'); ?>
								</a>
							</li>
						<?php endforeach; ?>
					<?php endif; ?>
					<?php foreach (Theme::socialNetworks() as $socialKey => $socialLabel) : ?>
						<?php $socialUrl = $site->{$socialKey}(); ?>
						<?php if (!empty($socialUrl)) : ?>
							<li><a href="<?php echo htmlspecialchars($socialUrl, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($socialLabel, ENT_QUOTES, 'UTF-8'); ?></a></li>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if (Theme::rssUrl()) : ?>
						<li><a href="<?php echo htmlspecialchars(Theme::rssUrl(), ENT_QUOTES, 'UTF-8'); ?>">RSS</a></li>
					<?php endif; ?>
				</ul>
			</nav>
		</div>
	</header>

	<?php if ($WHERE_AM_I === 'home') : ?>
		<section class="intro" aria-labelledby="intro-title">
			<div class="layout">
				<h1 id="intro-title"><?php echo htmlspecialchars($site->slogan() ?: $site->title(), ENT_QUOTES, 'UTF-8'); ?></h1>
				<?php if ($site->description()) : ?>
					<p><?php echo htmlspecialchars($site->description(), ENT_QUOTES, 'UTF-8'); ?></p>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<main id="main-content" class="layout">
		<?php if ($WHERE_AM_I !== 'home' && $WHERE_AM_I !== 'page') : ?>
			<h1 class="page-heading">Yazılar</h1>
		<?php endif; ?>
		<?php if (empty($content)) : ?>
			<p class="empty-state">Henüz yayımlanmış bir içerik yok.</p>
		<?php else : ?>
			<?php foreach ($content as $item) : ?>
				<article class="content-card">
					<?php Theme::plugins('pageBegin'); ?>
					<header>
						<?php if ($WHERE_AM_I === 'page') : ?>
							<h1><?php echo htmlspecialchars($item->title(), ENT_QUOTES, 'UTF-8'); ?></h1>
						<?php else : ?>
							<h2>
								<a href="<?php echo htmlspecialchars($item->permalink(), ENT_QUOTES, 'UTF-8'); ?>">
									<?php echo htmlspecialchars($item->title(), ENT_QUOTES, 'UTF-8'); ?>
								</a>
							</h2>
						<?php endif; ?>
						<time datetime="<?php echo htmlspecialchars($item->date('c'), ENT_QUOTES, 'UTF-8'); ?>">
							<?php echo htmlspecialchars($item->date(), ENT_QUOTES, 'UTF-8'); ?>
						</time>
					</header>
					<div class="content-body">
						<?php echo $WHERE_AM_I === 'page' ? $item->content() : $item->contentBreak(); ?>
					</div>
					<?php if ($WHERE_AM_I !== 'page' && $item->readMore()) : ?>
						<p class="read-more">
							<a href="<?php echo htmlspecialchars($item->permalink(), ENT_QUOTES, 'UTF-8'); ?>">
								Devamını oku: <?php echo htmlspecialchars($item->title(), ENT_QUOTES, 'UTF-8'); ?>
							</a>
						</p>
					<?php endif; ?>
					<?php Theme::plugins('pageEnd'); ?>
				</article>
			<?php endforeach; ?>
		<?php endif; ?>

		<?php if (Paginator::numberOfPages() > 1) : ?>
			<nav class="pagination" aria-label="İçerik sayfaları">
				<?php if (Paginator::showPrev()) : ?>
					<a rel="prev" href="<?php echo htmlspecialchars(Paginator::previousPageUrl(), ENT_QUOTES, 'UTF-8'); ?>">Önceki</a>
				<?php endif; ?>
				<span aria-current="page">Sayfa <?php echo (int) Paginator::currentPage(); ?></span>
				<?php if (Paginator::showNext()) : ?>
					<a rel="next" href="<?php echo htmlspecialchars(Paginator::nextPageUrl(), ENT_QUOTES, 'UTF-8'); ?>">Sonraki</a>
				<?php endif; ?>
			</nav>
		<?php endif; ?>
	</main>

	<footer class="site-footer">
		<p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($site->title(), ENT_QUOTES, 'UTF-8'); ?></p>
		<p><a href="https://www.volkan-ozdemir.com.tr">Volkan Özdemir Yazılım tarafından oluşturulmuştur.</a></p>
	</footer>
	<?php Theme::plugins('siteBodyEnd'); ?>
</body>
</html>
