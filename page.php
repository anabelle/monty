<?php
/*
Template Name: BIO
*/
get_header();


?>

<div id="main">
	<div class="post"><div class="post-inner">
		 <?php
		if (have_posts()) : while (have_posts()) : the_post();
		$ingles = get_post_custom_values('contenido_en_ingles', get_the_ID() );
		$izq = get_post_custom_values('columna_izquierda', get_the_ID() );
		?>
    <div class="pagetexto <?php if($ingles){print_r('dos_columnas');}?>">


            <?php the_content(); ?>
						<?php
							if($ingles){
							$contenido_ingles = $ingles[0];
							$contenido_ingles = nl2br($contenido_ingles);
							$contenido_izq = $izq[0];
							$contenido_izq = nl2br($contenido_izq);
						?>

							<div class="columna izq">
								<?php echo($contenido_izq); ?>
							</div>

							<div class="columna der">
								<?php echo($contenido_ingles); ?>
							</div>
						<?php
							}
						?>
    </div>
    <?php endwhile; endif; ?>
		</div></div>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
