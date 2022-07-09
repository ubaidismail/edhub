<?php
$user_id = get_current_user_id();
$if__is_member = pmpro_hasMembershipLevel('1', $user_id);
global $wpdb;
$table_name = $wpdb->prefix . 'tasks';
$table_strip_colors = $wpdb->prefix . 'event_colors';
$select_task = $wpdb->get_results("SELECT * FROM $table_name  WHERE user_id = $user_id ORDER BY DATE(task_start_date) ASC");
$get_color_table = $wpdb->get_results("SELECT * FROM $table_strip_colors  WHERE user_id = $user_id");
$count_rows = count($select_task);
$count_rows_color = count($get_color_table);
?>

<div class="subject-crud">
    <div class="edit-subjects">
        <h1>Click to Edit Subjects</h1>
        <?php
        foreach ($get_color_table as $subj) {
        ?>
            <form class="subjects-form">
                <input type="text" name="edit-subjects" value="<?php echo $subj->subjects; ?>">
                <input type="hidden" name="user_id" value='<?php echo $user_id; ?>' data-UserID="<?php echo $user_id; ?>">
                <input type="hidden" name="subject_id" value='<?php echo $subj->id; ?>'>
                <input type="submit" name="submit_subj" value="Update" disabled> <br> <br>
                <div class="lds-ring edit-subj">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </form>
        <?php

        }
        ?>

    </div>

    <div class="delete-subje">
        <h1>Delete Subjects</h1>
        <table border="1">
            <?php
            foreach ($get_color_table as $subj) {
            ?>
                <tr>
                    <th>Subject</th>
                    <td><?php echo $subj->subjects; ?></td>
                    <td class="del-subj"><a href="javascript:void(0)" data-SubjectId="<?php echo $subj->id; ?>">Delete</a></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>