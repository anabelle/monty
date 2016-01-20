<?php 
// Strip slashes
function theme_stripslashes_array($array) {
	if ( get_magic_quotes_gpc() == 0 ) return is_array($array) ? array_map('theme_stripslashes_array', $array) : stripslashes($array);
}

// Desactivar el reporte de version de WordPress para evitar ataques automáticos
function sin_generators()
{
return '';
}
add_filter('the_generator','sin_generators');

//Agregar soporte para cosas de WP
add_theme_support('menus');
add_theme_support('post-thumbnails');

//REGISTRA AREAS CON WIDGETS
if ( function_exists('register_sidebar') ){
	register_sidebar(array(
		'name' => 'sidebar-pruebas',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => 'sidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));

	register_sidebar(array(
		'name' => 'footer',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	));
}

//HACE MAGIA THE AJAX
function traer_contenido_obra() {
if(isset($_POST['cual']))
	{
		$args = array( 'numberposts' => 1,  'include' => $_POST['cual'] );
		$obra = get_posts( $args );

		foreach($obra as $post) : setup_postdata($post); 
		$ingles = get_post_custom_values('contenido_en_ingles');
		$izq = get_post_custom_values('columna_izquierda');

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

		<?php endforeach;
	}
die();
}

add_action('wp_ajax_contenido_obra', 'traer_contenido_obra');
add_action('wp_ajax_nopriv_contenido_obra', 'traer_contenido_obra');

// INICIA CONFIGURACION GENERALES DE PLANTILLA
 
$themename = "Monty";
$shortname = "monty";
$options = array (
 
array( "name" => "Configuraciones de plantilla",
	"type" => "title"),
 
array( "type" => "open"),
 
array( "name" => "Contacto",
	"desc" => "Agrega informacion de contacto (html minimal)",
	"id" => $shortname."_contacto",
	"type" => "textarea",
	"std" => ""),	

array( "name" => "Colores",
	"desc" => "Agrega un color en formato hexagecimal en cada linea",
	"id" => $shortname."_colores",
	"type" => "textarea",
	"std" => ""),
 
array( "type" => "close")
);

function mytheme_add_admin() {
 
global $themename, $shortname, $options;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
if ( 'save' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
$value = theme_stripslashes_array($value);
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
header("Location: themes.php?page=functions.php&saved=true");
die;
 
} else if( 'reset' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
delete_option( $value['id'] ); }
 
header("Location: themes.php?page=functions.php&reset=true");
die;
 
}
}
 
add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
 
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
<div class="wrap">
<h2><?php echo $themename; ?> Settings</h2>
 
<form method="post">
 
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">
 
<?php break;
 
case "close":
?>
 
</table><br />
 
<?php break;
 
case "title":
?>
<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
</tr>
 
<?php break;
 
case 'text':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case 'textarea':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo stripslashes(get_settings($value['id'])); } else { echo $value['std']; } ?></textarea></td>
 
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case 'select':
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case "checkbox":
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
</td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php break;
 
}
}
?>
 
<p class="submit">
<input name="save" type="submit" value="Guardar" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 
<?php
}

add_action('admin_menu', 'mytheme_add_admin');


// POSTS POR PAGINA
function limit_posts_per_archive_page() {
	if ( is_category() && !is_category(1) ){
		$limit = -1;
	}else{
		$limit = get_option('posts_per_page');
	}

	set_query_var('posts_per_archive_page', $limit);
}
add_filter('pre_get_posts', 'limit_posts_per_archive_page');
?>
