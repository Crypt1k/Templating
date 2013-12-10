<h1><?=$article['head']?></h1>
<div class="content">
 <?=$article['content']?>
</div>
<?php foreach ($this->comments as $key=>$value): ?>
  <p class="user"><?=$value['username']?>: (<?=$key?>)</p>
  <p class="comment"><?=$value['text']?></p>
<?php endforeach; ?>