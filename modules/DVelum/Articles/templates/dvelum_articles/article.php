<?php
$data = $this->get('data');
$relatedArticles = $this->get('related_articles');
$page = $this->get('page');
$lang = $this->get('lang');
$categoryInfo = $this->get('category_info');

$categoryLink = '';
if(!empty($categoryInfo) && $categoryInfo['published']){
    $categoryLink = '<span class="categoryLink"><a href="'.$categoryInfo['url'].'">'.$categoryInfo['title'].'</a></span>';
}


?>
<div class="dv_article">
        <div>
            <span class="date"><?php echo date($this->get('date_format'), strtotime($data['date_published']))?></span>
            <?php echo $categoryLink;?>
        </div>

        <div class="sep"></div>
        <?php
            if(!empty($data['image']))
            echo '<div class="pic article"><img itemprop="image" src="'.$data['image'].'"/></a></div>';
        ?>
        <div class="articleBody" itemprop="articleBody">
            <?php echo $data['text']; ?>
        </div>
        <div class="clear empty"></div><br>
    <div class="sep"></div>
    <div class="clear empty"></div>
<?php
if(!empty($relatedArticles)){
?>
    <strong><?php $lang->get('more_articles');?></strong>
    <div class="clear empty"></div>
    <ul class="relatedArticles">
        <?php
        foreach($relatedArticles as $article)
        {
            echo '<li class="item">';

            if(!empty($article['image'])){
                echo '<div class="pic"><a href="'.$article['url'].'"><img src="'.$article['image'].'"/></a></div>';
            }

            echo '<div class="content">'
                    . '<a href="'.$article['url'].'"><div class="title">'.$article['title'].'</div></a>'
                    . '<div class="brief">'.$article['brief'].'</div>'
                 .'</div>';


            echo '</a></li>';
        }
        ?>
    </ul>
    <div class="clear empty"></div>
<?php
}?>
</div>
