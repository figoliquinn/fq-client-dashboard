<div class="row">
	<div class="col-sm-12">
		<h3><?php print $channel->title;?></h3>
		<p><?php print $channel->description;?></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<ul class="rss-feed">
			<?php foreach ($channel->item as $key => $item): ?>
				<li>
					<h4><a href="<?php print $item->link;?>" target="_blank"><?php print $item->title;?></a></h4>
					<?php $date = new DateTime($item->pubDate);?>
					<p class="rss-date">Posted <?php print $date->format('m/d/Y g:ia');?></p>
					<p><?php print $item->description;?></p>
				</li>
				<?php if ($key >= $feedMax): ?>
					<?php break;?>
				<?php endif;?>
			<?php endforeach;?>
		</ul>
	</div>
</div>