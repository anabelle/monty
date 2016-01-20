<?php /* Display navigation to next/previous pages when applicable */ 
	// TRAE CONFIGURACIONES DE PLANTILLA
	global $options;
	foreach ($options as $value) {
    		if (get_settings( $value['id'] ) === FALSE) { 
			$$value['id'] = $value['std']; 
		} else { 
			$$value['id'] = get_settings( $value['id'] ); 
		}
	}
?>

<?
	if(is_front_page()){
		query_posts('showposts=-1');
	}
?>

<?php if ( $wp_query->max_num_pages > 1 ) : ?>
		<?php next_posts_link( __( '&larr; Older posts') ); ?>
		<?php previous_posts_link( __( 'Newer posts &rarr;') ); ?>
<?php endif; ?>

<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
		<h1><?php _e( 'Not Found'); ?></h1>
		<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.'); ?></p>
		<?php get_search_form(); ?>

<?php endif; ?>

<?php
	/* Start the Loop.

	 */ 
	$colores = explode("\r\n",$monty_colores);
	$cuantos_colores = count($colores);
	$contador = 0;
	//echo($cuantos_colores);
	//print_r($colores);
	// echo $monty_colores;
?>

<?php while ( have_posts() ) : the_post(); ?>

		<?
			if($contador == 0 && in_category(1)){
				$abrir = true;
			}else{
				$abrir = false;
			}
		?>

<div id="contenido<?php the_ID(); ?>" <?php post_class(); ?>>	
			<h2 id="obra-<?php the_ID(); ?>" class="entry-title" style="background-color:<?=$colores[$contador];?>"><a href="<?php the_permalink(); ?>" rel="bookmark" id="<?php the_ID(); ?>" class="<? if($abrir == false){ ?>inactivo<?php }else{ ?>activo<?php } ?>"><?php the_title(); ?></a></h2>

		<div class="post-inner" id="post-inner-<?php the_ID(); ?>" style="<? if($abrir == false){ ?>display:none;<?php } ?>">
			<?php 
				$ingles = get_post_custom_values('contenido_en_ingles');
				$izq = get_post_custom_values('columna_izquierda');
				if($abrir == true){ 
			?>

			<div class="lienzo clearfix <?php if($ingles){print_r('dos_columnas');}?>">
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
				

			
			<?	}
			?>
			<?php
				$contador++;

					if($contador == $cuantos_colores){
						unset($contador);
						$contador = 0;
					}
			?>
				<?php echo really_simple_share_publish($link='', $title=''); ?>
				
			</div>	

</div>
<?php endwhile; // End the loop. Whew. ?>

<?php /* Display navigation to next/previous pages when applicable */ ?>
<?php if (  $wp_query->max_num_pages > 1 ) : ?>
				<?php next_posts_link( __( '&larr; Older posts') ); ?>
				<?php previous_posts_link( __( 'Newer posts &rarr;') ); ?>
<?php endif; ?>
