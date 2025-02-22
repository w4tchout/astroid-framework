<?php

/**
 * @package   Astroid Framework
 * @author    Astroid Framework https://astroidframe.work
 * @copyright Copyright (C) 2023 AstroidFrame.work.
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or Later
 */
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Astroid\Framework;

$app = Factory::getApplication();

$this->category->text = $this->category->description;
$app->triggerEvent('onContentPrepare', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$this->category->description = $this->category->text;

$results = $app->triggerEvent('onContentAfterTitle', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentBeforeDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app->triggerEvent('onContentAfterDisplay', [$this->category->extension . '.categories', &$this->category, &$this->params, 0]);
$afterDisplayContent = trim(implode("\n", $results));

$htag    = $this->params->get('show_page_heading') ? 'h2' : 'h1';

$use_masonry = $this->params->get('use_masonry', 0);

if ($use_masonry) {
    $document = Framework::getDocument();
    $document->loadMasonry();
}

?>
<div class="blog<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
        </div>
    <?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1)) : ?>
        <<?php echo $htag; ?>>
            <?php echo $this->category->title; ?>
        </<?php echo $htag; ?>>
    <?php endif; ?>
    <?php echo $afterDisplayTitle; ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
    <div class="category-desc clearfix">
        <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
            <?php echo LayoutHelper::render(
                'joomla.html.image',
                [
                    'src' => $this->category->getParams()->get('image'),
                    'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
                ]
            ); ?>
        <?php endif; ?>
        <?php echo $beforeDisplayContent; ?>
        <?php if ($this->params->get('show_description') && $this->category->description) : ?>
            <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
        <?php endif; ?>
        <?php echo $afterDisplayContent; ?>
    </div>
    <?php endif; ?>

<?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
    <div class="com-content-category-blog__children cat-children">
        <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
            <h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
        <?php endif; ?>
        <?php echo $this->loadTemplate('children'); ?>
    </div>
<?php endif; ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
    <?php if ($this->params->get('show_no_articles', 1)) : ?>
        <div class="alert alert-info">
            <span class="icon-info-circle" aria-hidden="true"></span><span class="visually-hidden"><?php echo Text::_('INFO'); ?></span>
            <?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?>
        </div>
    <?php endif; ?>
    <?php endif; ?>

    <?php if (!empty($this->lead_items)) : ?>
    <div class="com-content-category-blog__items blog-items items-leading <?php echo $this->params->get('blog_class_leading'); ?>">
        <?php foreach ($this->lead_items as $key => &$item) : ?>
            <div class="com-content-category-blog__item blog-item">
                <?php
                $item->is_leaditem = true;
                $item->key_idx = $key;
                $this->item = &$item;
                echo $this->loadTemplate('item');
                ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($this->intro_items)) : ?>
    <?php $blogClass = $this->params->get('blog_class', ''); ?>
    <?php if ((int) $this->params->get('num_columns') > 1) : ?>
        <?php
            $blogClass .= ' row-cols-lg-'.$this->params->get('num_columns');
            $blogClass .= $use_masonry ? ' as-masonry' : '';
        ?>
    <?php endif; ?>
    <div class="com-content-category-blog__items blog-items items-row">
        <div class="row gx-xl-5 gy-5 <?php echo $blogClass; ?>">
            <?php foreach ($this->intro_items as $key => &$item) : ?>
                <div class="com-content-category-blog__item blog-item">
                    <?php
                    $item->is_introitem = true;
                    $item->key_idx = $key;
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($this->link_items)) : ?>
        <div class="items-more">
            <?php echo $this->loadTemplate('links'); ?>
        </div>
    <?php endif; ?>

    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
        <div class="com-content-category-blog__navigation w-100">
            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                <p class="com-content-category-blog__counter counter pt-3 pe-2">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </p>
            <?php endif; ?>
            <div class="com-content-category-blog__pagination">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>