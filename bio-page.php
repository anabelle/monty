<?php
/*
Template Name: BIO
*/
get_header(); ?>

<div id="main">
	 <?php if (have_posts()) : while (have_posts()) : the_post();?>
    <div class="biotexto">


            <?php the_content(); ?>

    </div>
    <?php endwhile; endif; ?>

</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
