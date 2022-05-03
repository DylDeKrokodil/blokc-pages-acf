<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	global $wpdb;
	$group_key = $_POST['group_key'];

	if(get_option('group_key') || get_option('group_key') == ''){
		$wpdb->update('wp_options', array(
			'option_name'=>'group_key', 
			'option_value'=>$group_key, 
			'autoload'=>'no'), 
		array('option_name'=>'group_key'));

		header("refresh: 0");
	} else{
		$wpdb->insert('wp_options', array(
		    'option_name' => 'group_key',
		    'option_value' => $group_key,
		    'autoload' => 'no', 
		));
	}
}

$group_key = get_option('group_key');
$check_empty = acf_get_fields($group_key);

?>

<form class="form-group-key" method="post">
	<div class="input-group-key">
		<label for="group_key">Group key</label><input name="group_key" id="group_key" type="text" value="<?php if(get_option('group_key')) { echo $group_key; } ?>" >
		<button class="btn" type="submit">Save Key</button>
	</div>
</form>

<?php 

if(get_option('group_key') && !empty($check_empty)){
	$hoofd_array = [];
	$block_slugs = [];
	$pages_blocks = [];
	$custom_post_tyes = [];

	$query = "SELECT ID FROM wp_posts WHERE post_type = 'page' OR post_type = 'post' ";

	$args = array(
	   'public'   => true,
	   '_builtin' => false
	);

	$output = 'names'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'

	$post_types = get_post_types( $args, $output, $operator ); 

	// loop throught post types and complete query
	foreach ( $post_types  as $post_type ) {
		$custom_post_tyes[] = $post_type;
		$query .= "OR post_type = '".$post_type."' ";
	}


	// get all blocks by block id
	$layouts = acf_get_fields($group_key);
	$layouts = $layouts[0]['layouts'];

	// get all page ids
	$page_ids = $wpdb->get_col($query); 

	foreach ($page_ids as $page_id) {
		${'pages_blocks_'.$page_id} = array();
	}

	// vult array met alle blocks
	foreach ($layouts as $key => $value) {
		// array_push($block_slugs, $value['name']);

		${$value['name']} = array(
			'naam' => $value['name'],
		);

		foreach ($page_ids as $page_id) {
			if(have_rows('blocks', $page_id)) {
			    while(have_rows('blocks', $page_id)){ 
			    	$row = the_row();
			    	$pagina_naam = get_the_title($page_id);
			        if( get_row_layout() == $value['name'] ){
						
			      		${$value['name']}[] = $pagina_naam;
			            
			        }
			    }
			}
			${$value['name']} = array_unique(${$value['name']});
		}

		$hoofd_array[] = ${$value['name']};


	}
	?>

	<div class="btn close-all">
		Close all
	</div>
	<div class="slugs">

	<?php sort($hoofd_array);
	foreach($hoofd_array as $block){ ?>
			<div class="slug">
				<div class="slug-name">
					<h2>
						<?php echo $block['naam']; ?>
						<i class="fas fa-angle-down"></i>					
					</h2>
				</div>
				<div class="pages">
					<?php 
					$count = count($block);
					$x = -1;

					while($x < $count) { $x++; ?>
						<div class="page">
							<h3>
								<?php echo $block[$x]; ?>
							</h3>	
						</div>
					<?php } ?>
					
				</div>
			</div>
	<?php } ?>
	</div>
<?php } elseif(empty($check_empty)) {
	echo "Group key komt niet overeen";
} else {
	echo "Geen group key gevonden";
}
