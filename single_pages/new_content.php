<?php foreach ($model as $section):?>
<h2><?php echo $section['title']?></h2>
<p><?php echo $section['description']?></p>
<ul>
<?php /* @var $page Page */
foreach ($section['pages'] as $page):?>
<li><?php echo $page->getCollectionDescription()?></li>
<?php endforeach?>
</ul>
<?php endforeach?>
