<?php
/* Child theme generated with WPS Child Theme Generator */

use ParagonIE\Sodium\Core\Curve25519\Ge\P2;

if (!function_exists('b7ectg_theme_enqueue_styles')) {
	add_action('wp_enqueue_scripts', 'b7ectg_theme_enqueue_styles');

	function b7ectg_theme_enqueue_styles()
	{
		wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'));
	}
}
function edh_admin_scripts()
{
	wp_enqueue_style('calender-default-style', get_stylesheet_directory_uri() . '/task/css/task-default.css');
	wp_enqueue_style('calender-custom-style', get_stylesheet_directory_uri() . '/task/css/custom.css');
	wp_enqueue_script('calnder-js', get_stylesheet_directory_uri() . '/task/js/main.js');
	wp_enqueue_script('custom-ajax-script', get_stylesheet_directory_uri() . '/task/js/custom.js');
	wp_localize_script(
		'custom-ajax-script',
		'ed_hub',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
		)
	);
	wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'edh_admin_scripts');

add_action('wp_head', 'head_js');

function head_js()
{
	echo '

	<script>
		jQuery(document).ready(function(){
			jQuery(".nav-bar-clicker i").click(function(){
				jQuery(".nav-items").toggle();
			})
		})
	</script>

	';
}

function edh_login_logo()
{
	$site_url = site_url();
	$logo_url = $site_url . '/wp-content/uploads/2022/05/logo.png';
	$body_url = $site_url . '/wp-content/uploads/2022/05/rm373batch13-085-scaled.jpg';
?>
	<style type="text/css">
		#login h1 a,
		.login h1 a {
			background-image: url(<?php echo $logo_url ?>);
			height: 100px;
			width: 300px;
			background-size: 300px 100px;
			background-repeat: no-repeat;
			padding-bottom: 10px;
			background-size: contain;
		}

		body.login {
			background-image: url(<?php echo $body_url ?>);
			background-size: cover;
		}

		.login form {
			border: 1px solid #6789a4 !important;
			background-color: #6789a4 !important;
			color: white;
		}

		.login input#wp-submit {
			background-color: #1b354e;
			border-color: #1b354e;
		}

		.login p#nav a,
		.login p#backtoblog a {
			color: white !important;
		}
	</style>
<?php }
add_action('login_enqueue_scripts', 'edh_login_logo');

function edh_login_logo_url()
{
	return home_url();
}
add_filter('login_headerurl', 'edh_login_logo_url');

function edh_login_logo_url_title()
{
	return 'ED HUB';
}
add_filter('login_headertitle', 'edh_login_logo_url_title');

// add_filter( 'login_display_language_dropdown', '__return_false' );

/* start  */
add_filter('register_url', 'edh_custom_register_url');
function edh_custom_register_url($register_url)
{
	$register_url = get_permalink($register_page_id = 7);
	return $register_url;
}
/* end */


function theme_options_panel()
{
	add_menu_page('Add Tasks', 'Add Task', 'manage_options', 'ed-tasks', 'edh_add_task', '', 10);
	add_submenu_page( 'ed-tasks', 'Add Or Edit Subjects', 'Edit Subjects', 'manage_options', 'edit-subjects', 'edh_subjects_edit');
}
add_action('admin_menu', 'theme_options_panel');
function edh_add_task()
{
	include("task/edh-task-det.php");
}
function edh_subjects_edit(){
	include("task/edh-task-edit.php");
}


add_action('wp_ajax_save_tasks', 'save_tasks');
function save_tasks()
{
	global $wpdb;
	if ($_POST['action'] == 'save_tasks') {
		$title = $_POST['task_title'];
		$task_subject = $_POST['task_subject'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$desc = $_POST['task_details'];
		$task_type = $_POST['task_type'];
		$user_id = $_POST['user_id'];
		$get_colors_for_event = $_POST['get_colors_for_event'];
		$assignment_subjects = $_POST['assignment_subjects'];


		$table_name = $wpdb->prefix . 'tasks';
		// $table_color = $wpdb->prefix . 'event_colors';
		// $get_color = $wpdb->get_results("SELECT * FROM $table_color  WHERE color' = $get_colors_for_event ");
		// $task_key = 'ED_'.rand(0 , 100);
		// exit;
		$insert_task = $wpdb->insert($table_name, array(
			'user_id' => $user_id,
			'task_title' => $title,
			'task_subject' => $task_subject,
			'task_start_date' => $start_date,
			'task_end_date' => $end_date,
			'task_desc' => $desc,
			'task_type' => $task_type,
			'assignment_task_subject' => $assignment_subjects,
			// 'task_key' => $task_key,
		));
		
		// if($insert_color){
		// 	echo 'New color inserted';
		// }
		
	}


	if ($insert_task) {
		echo 'ok';
	} else {
		echo 'Something went wrong';
	}
	wp_die();
}

add_action('wp_ajax_delete_tasks', 'delete_tasks');
function delete_tasks()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'tasks';
	$id = $_POST['taslID'];
	$taskKey = $_POST['taskKey'];
	$del_query = $wpdb->delete($table_name, array('id' => $id));
	
	if ($del_query) {
		echo 'Task deleted';
		wp_die();
	} else {
		echo 'Soemthign went wrong';
		wp_die();
	}
}
add_action('wp_ajax_update_task_detials', 'update_task_detials');
function update_task_detials()
{
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tasks';
	$task_id = $_POST['taslID'];
	$data = $wpdb->get_row("SELECT * FROM $table_name WHERE `id` = $task_id  ");
	
?>

<div class="close-up_task-form"><a href="javascript:void(0)">close</a></div>
<h4>Update task</h4>
<form id="task-update-form">
	<div class="flex-task-inp">
		<input type="text" name='up_task_title' value="<?php echo $data->task_title ?>" placeholder="Task Title">
		<input type="text" name='up_task_subject' value="<?php echo $data->task_subject ?>" placeholder="Task Subject">
		</div>
		<div class="flex-task-inp">
			<label for="">Start Date <input type="date" value="<?php echo $data->task_start_date; ?>" name='up_start_date' placeholder="Start Date"></label>
			<label for="">End Date<input type="date" value="<?php echo $data->task_end_date; ?>" name='up_end_date' placeholder="End Date"></label>
		</div>
		
		<textarea name="up_task_details" placeholder="Task Description"><?php echo $data->task_desc ?></textarea>
		<select name="up_task_type">
			<option value="<?php echo $data->task_type; ?>"><?php echo $data->task_type; ?></option>
			<option value="revision">Revision</option>
			<option value="event">Event</option>
			<option value="exam">Exam</option>
			<option value="assignment">Assignments</option>
		</select>
		<select name="up_assignment_subjects" id="up_assignment_subjects">
			<option value="maths">Maths</option>
			<option value="physics">Physics</option>
		</select>
		<input type="hidden" name="user_id" value='<?php echo get_current_user_id(); ?>'>
		<input type="hidden" name="task_id" value='<?php echo $task_id;  ?>'>
		<input type="hidden" value='<?php echo $data->date; ?>' name='date_selected'>
		<input type="submit" value="Update" name="update">
	</form>

	<?php

	wp_die();
}


add_shortcode('login_btns', 'ED_login_btn_func');

function ED_login_btn_func()
{
	$home_url = get_home_url();
	
	if (is_user_logged_in()) {
		?>
		<div class="login-reg myacc-main">
			<a href="<?php echo $home_url ?>/profile" class="lgn_btn myac">My Acoount</a>
		</div>
		<?php
	} else {
		?>

<div class="login-reg only">
	<a href="<?php echo $home_url ?>/login" class="lgn_btn">Login</a>
	<a href="<?php echo $home_url ?>/register" class="reg_btn">Register</a>
</div>

<?php
	}
}
add_action('wp_ajax_update_task', 'update_task');
function update_task()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'tasks';
	
	$title = $_POST['up_task_title'];
	$up_start_date = $_POST['up_start_date'];
	$up_end_date = $_POST['up_end_date'];
	$up_task_subject = $_POST['up_task_subject'];
	$desc = $_POST['up_task_details'];
	$task_type = $_POST['up_task_type'];
	$user_id = $_POST['user_id'];
	$task_id = $_POST['task_id'];
	$up_assignment_subjects = $_POST['up_assignment_subjects'];
	
	$update_data = $wpdb->update(
		$table_name,
		array(
			'user_id' => $user_id,
			'task_title' => $title,
			'task_subject' => $up_task_subject,
			'task_start_date' => $up_start_date,
			'task_end_date' => $up_end_date,
			'task_desc' => $desc,
			'task_type' => $task_type,
			'assignment_task_subject' => $up_assignment_subjects,
			
		),
		array('id' => $task_id)
	);
	if ($update_data) {
		echo 'Data Updated';
	} else {
		echo 'Not Updated';
	}
	wp_die();
}

add_action('wp_ajax_complete_edhub_task', 'complete_edhub_task');

function complete_edhub_task()
{
	
	global $wpdb;
	$table_name = $wpdb->prefix . 'tasks';
	$task_id = $_POST['taslID'];
	
	$update_data = $wpdb->update(
		$table_name,
		array(
			'status' => 1,
			
		),
		array('id' => $task_id)
	);
	
	if ($update_data) {
		echo 'Task Marked as completed';
	} else {
		echo 'Something went wrong';
	}
	wp_die();
}
add_action('wp_ajax_change_strip_col_func', 'change_strip_col_func');

function change_strip_col_func()
{
	global $wpdb;
	if ($_POST['action'] == 'change_strip_col_func') {
		
		$color = $_POST['get_colors_for_event'];
		$user_ids = $_POST['user_id'];
		$subject_name = $_POST['subject-name'];
		$table_name = $wpdb->prefix . 'event_colors';
		$get_color_table = $wpdb->get_results("SELECT * FROM $table_name  WHERE user_id = '$user_ids' AND subjects = '$subject_name' ");
		
		if ($get_color_table) {
			$update_data = $wpdb->update(
				$table_name,
				array(
					'color' => $color,
				),
				array(
					'user_id' => $user_ids,
					'subjects' => $subject_name
				)
			);
			if ($update_data) {
				echo "Color Updated";
			} else {
				echo "Something went wrong in updating the color";
			}
		} else {
			$insert_color = $wpdb->insert($table_name, array(
				'user_id' => $user_ids,
				'color' => $color,
				'subjects' => $subject_name,
			));
			if ($insert_color) {
				echo "Color Applied";
			} else {
				echo "Error in  applying color";
			}
		}
	}

	wp_die();
}
function friendship_req_func()
{
	?>
	<div class='profile-btn'>
		<a href='<?php echo do_shortcode('[bpps_profile_url]'); ?>'>View Profile</a>
	</div>
<?php
}
add_shortcode('friendship_requests', 'friendship_req_func');

function get_list_of_users()
{
	ob_start();
	$users = get_users();
	// Array of WP_User objects.
?>
<h1 class='profile-suge-frn'>Suggested members</h1>
	<div class="user-main">
		<?php
		foreach ($users as $user) {
			/* Here passing user email and avater size */
			$user_image = get_avatar($user->user_email, 96);
			$user_name = $user->display_name;
			$user_id = $user->ID;
			$user_login = $user->user_login;
			$user_url = site_url() . '/members/' . $user_login;
			if($user_id != get_current_user_id()){
		?>
			<div class="all_users">
				<a href="<?php echo $user_url; ?>">
				<div class="user-avator">
					<?php echo $user_image; ?>
				</div>
				<h4>
					<?php echo $user_name; ?>

				</h4>
				</a>
			</div>
		<?php
		}
		}
		?>
	</div>
<?php
	// var_dump($users);

	return ob_get_clean();
}
add_shortcode('WP_USERS_ALL', 'get_list_of_users');
function on_footer_func(){

	if(is_user_logged_in()){
		
		?>
			<script>
				jQuery(document).ready(function(){
					PUM.open(390);
				})
				setTimeout(() => {
					jQuery(document).ready(function(){
					PUM.close(390);
				})	
				}, 3000);
			</script>
		<?php
	}
	
}add_action('wp_head' , 'on_footer_func');


add_action('wp_ajax_display_taskData_in_popup_function', 'display_taskData_in_popup_function');
function display_taskData_in_popup_function(){
	global $wpdb;
	$table_name = $wpdb->prefix . 'tasks';
	$task_id = $_POST['taskID'];
	$data = $wpdb->get_row("SELECT * FROM $table_name WHERE `id` = $task_id  ");		
	?>

		<div class="task-view-window">
		<div class="close-up_task-view"><a href="javascript:void(0)">close</a></div>
			<table border="1">
				<tr>
					<th>Task Title</th>
					<td><?php echo $data->task_title;?></td>
				</tr>
				<tr>
					<th>Task Subject</th>
					<td><?php echo $data->task_subject;?></td>
				</tr>
				<tr>
					<th>Task Type</th>
					<td><?php echo $data->task_type;?></td>
				</tr>
				<tr>
					<th>Task Assignment Type</th>
					<td><?php echo $data->assignment_task_subject;?></td>
				</tr>
				<tr>
					<th>Task Start Date</th>
					<td><?php echo $data->task_start_date;?></td>
				</tr>
				<tr>
					<th>Task End Date</th>
					<td><?php echo $data->task_end_date;?></td>
				</tr>
				<tr>
					<th>Task Description</th>
					<td><?php echo $data->task_desc;?></td>
				</tr>
				<tr>
					<th>Status</th>
					<td></td>
				</tr>
			</table>
		</div>
	<?php
	wp_die();

}

add_action('wp_ajax_edh_update_edit_subjects', 'edh_update_edit_subjects');
function edh_update_edit_subjects(){
	$user_id = $_GET['userId'];
	$subj = $_GET['subject'];
	$subject_id = $_GET['subject_id'];

	global $wpdb;
	
	$table_name = $wpdb->prefix . 'event_colors';
	// $get_color_table = $wpdb->get_results("SELECT * FROM $table_name  WHERE user_id = '$user_id' AND id = '$subject_id' ");
	$update_data = $wpdb->update(
		$table_name,
		array(
			'subjects' => $subj,
		),
		array('id' => $subject_id)
	);
	if($update_data){
		echo 'Subject Updated';
	}
	wp_die();
}
add_action('wp_ajax_edh_delete_subjects', 'edh_delete_subjects');
function edh_delete_subjects(){
	$subject_id = $_GET['subject_id'];
	global $wpdb;
	$table_name = $wpdb->prefix . 'event_colors';
	$del_query = $wpdb->delete($table_name, array('id' => $subject_id));
	if($del_query){
		echo 'task Deleted';
	}else{
		
		echo 'task not deleted';
	}
}