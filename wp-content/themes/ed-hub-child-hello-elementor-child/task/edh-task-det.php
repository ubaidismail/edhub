<?php
$user_id = get_current_user_id();
$if__is_member = pmpro_hasMembershipLevel( '1', $user_id);
global $wpdb;
$table_name = $wpdb->prefix . 'tasks';
$table_strip_colors = $wpdb->prefix . 'event_colors';
$select_task = $wpdb->get_results("SELECT * FROM $table_name  WHERE user_id = $user_id ORDER BY DATE(task_start_date) ASC");
$get_color_table = $wpdb->get_results("SELECT * FROM $table_strip_colors  WHERE user_id = $user_id");
$count_rows = count($select_task);
$count_rows_color = count($get_color_table);
?>

<!DOCTYPE html>
<html lang="en">

<body>
  <h1>Add Task</h1>
  <div class='calender-header-objects'>
  <?php 
  $membership_page = site_url('/membership-levels/'); 
  $profile_page = site_url('/profile//'); 
    if($if__is_member == false){
        echo '<div class="btn-parent"><a href='.$membership_page.' class="become_member_btn">Become A Member</a></div>';
    }else{
      echo '<div class="btn-parent"><a href='.$profile_page.' class="become_member_btn">You Are A Member</a></div>';
    }
  ?>
  <div class='colors-with-labels'>
    <?php if (!empty($get_color_table)) {
      foreach ($get_color_table as $col) {
        $color = $col->color;
        $color_calender[] = $col->color;
        $user_exists = $col->user_id;
        $user_subject = $col->subjects;
        $user_subject_for_down[] = $col->subjects;

    ?>

        <strong class='color-label' style='background-color:<?php echo $color; ?>'></strong>
        <strong><?php echo $user_subject; ?></strong>
    <?php
      }
    } ?>
  </div>
  </div>

  <div class="flex-tasks">
    <div id='calendar'></div>
    <div class="sidebar-task">
      <h3>Task List</h3>
      <div class="tabset">
        <!-- Tab 1 -->
        <input type="radio" name="tabset" id="tab3" aria-controls="todos_task" checked>
        <label for="tab3">Todos</label>

        <!-- Tab 2 -->
        <input type="radio" name="tabset" id="tab1" aria-controls="marzen">
        <label for="tab1">Scheduled Task</label>
        <!-- Tab 3 -->
        <input type="radio" name="tabset" id="tab2" aria-controls="rauchbier">
        <label for="tab2">Revision</label>

        <div class="tab-panels">
          <!-- todos tab start -->
          <section id="todos_task" class="tab-panel">
            <?php
            foreach ($select_task as $st) {
              $today_date = date("Y-m-d");

              if ($st->task_start_date == $today_date) {
                if ($st->status == 1) {
                  echo "<ul class='task-list-main color-task-completed'>";
                  echo '<li class="completed" title="Completed"><span class="dashicons dashicons-yes-alt"></span></li>';
                } else {
                  echo "<ul class='task-list-main' data-id='".$st->id."'>";
                }
            ?>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_title) ? '<b>Task Title</b>: ' . $st->task_title : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_desc) ? '<b>Task Description</b>: ' . $st->task_desc : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_type) ? '<b>Task Type</b>: ' . $st->task_type : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>' class='start-date' data-date='<?php echo $st->task_start_date ?>'> <?php echo (!empty($st->task_start_date) ? '<b>Start Date</b>: ' . $st->task_start_date : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_end_date) ? '<b>End Date</b>: ' . $st->task_end_date : ''); ?></li>

                <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' data-taskKey='<?php echo $st->task_key; ?>' data-taskType="<?php echo $st->task_type ?>" class='task-delete'>Delete </a>
                <?php
                if ($st->status == 0) {
                ?>
                  <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' class='task-update'>Update</a>
                  <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' class='task-complete'>Complete</a>
                <?php
                }
                ?>
                </ul>

                <hr>
            <?php
              }
            }

            ?>
          </section>
          <!-- todos tab end -->
          <section id="marzen" class="tab-panel">
            <?php
            foreach ($select_task as $st) {
              if ($st->task_type != 'revision') {
                if ($st->status == 1) {
                  echo "<ul class='task-list-main color-task-completed'>";
                  echo '<li class="completed" title="Completed"><span class="dashicons dashicons-yes-alt"></span></li>';
                } else {
                  echo "<ul class='task-list-main' data-id='".$st->id."'>";
                }
            ?>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_title) ? '<b>Task Title</b>: ' . $st->task_title : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_desc) ? '<b>Task Description</b>: ' . $st->task_desc : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_type) ? '<b>Task Type</b>: ' . $st->task_type : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>' class='start-date' data-date='<?php echo $st->task_start_date ?>'> <?php echo (!empty($st->task_start_date) ? '<b>Start Date</b>: ' . $st->task_start_date : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_end_date) ? '<b>End Date</b>: ' . $st->task_end_date : ''); ?></li>

                <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' data-taskKey='<?php echo $st->task_key; ?>' data-taskType="<?php echo $st->task_type ?>" class='task-delete'>Delete </a>
                <?php
                if ($st->status == 0) {
                ?>
                  <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' class='task-update'>Update</a>
                  <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' class='task-complete'>Complete</a>
                <?php
                }
                ?>
                </ul>

                <hr>
            <?php
              }
            }

            ?>
          </section>

          <section id="rauchbier" class="tab-panel">
            <?php
            foreach ($select_task as $st) {
              if ($st->task_type == 'revision') {
                if ($st->status == 1) {
                  echo "<ul class='task-list-main color-task-completed'>";
                  echo '<li class="completed" title="Completed"><span class="dashicons dashicons-yes-alt"></span></li>';
                } else {
                  echo "<ul class='task-list-main' data-id='".$st->id."'>";
                }
            ?>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_title) ? '<b>Task Title</b>: ' . $st->task_title : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_desc) ? '<b>Task Description</b>: ' . $st->task_desc : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_type) ? '<b>Task Type</b>: ' . $st->task_type : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>' class='start-date' data-date='<?php echo $st->task_start_date ?>'> <?php echo (!empty($st->task_start_date) ? '<b>Start Date</b>: ' . $st->task_start_date : ''); ?></li>
                <li data-id='<?php echo $st->id; ?>'> <?php echo (!empty($st->task_start_date) ? '<b>End Date</b>: ' . $st->task_end_date : ''); ?></li>

                <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' data-taskKey='<?php echo $st->task_key; ?>' data-taskType="<?php echo $st->task_type ?>" class='task-delete'>Delete</a>
                <?php
                if ($st->status == 0) {
                ?>
                  <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' class='task-update'>Update</a>
                  <a href="javascript:void(0)" data-id='<?php echo $st->id; ?>' class='task-complete'>Complete</a>
                <?php
                }
                ?>

                </ul>

                <hr>
            <?php
              }
            }

            ?>
          </section>
        </div>
      </div>
      <div class="lds-ring">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>

    </div>
  </div>

  <div class="task-form">
    <div class="close-task-form"><a href="javascript:void(0)">close</a></div>
    <h4>Add new task</h4>
    <form id="daily-task-form">
      <div class="flex-task-inp">
        <input type="text" name='task_title' placeholder="Task Title">
        <input type="text" name='task_subject' placeholder="Task Subject">
      </div>
      <div class="flex-task-inp">
        <label for="">Start Date <input type="text" name='start_date' placeholder="Start Date" readonly></label>
        <label for="">End Date<input type="text" name='end_date' placeholder="End Date" readonly></label>
      </div>
      <textarea name="task_details" placeholder="Task Description"></textarea>
      <select name="task_type">
        <option value="0">Task Type</option>
        <option value="revision">Revision</option>
        <option value="event">Event</option>
        <option value="exam">Exam</option>
        <option value="assignment">Assignments</option>
      </select>
      <select name="assignment_subjects" id="assignment_subjects">
        <option value="0">Select Subject</option>
        <?php
        foreach ($user_subject_for_down as $sub) {
        ?>
          <option value="<?php echo $sub ?>"><?php echo $sub; ?></option>
        <?php
        }
        ?>

      </select>
      <input type="hidden" name="user_id" value='<?php echo get_current_user_id(); ?>'>
      <input type="hidden" value='' name='date_selected'>
      <input type="submit" value="save">
      <div class="lds-ring-task-inert">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>
  </div>
  </form>
  <form id='color-picker-form'>
    <h3>Add Or Update Color For subjects</h3>
  <?php
if($count_rows_color == 3 && $if__is_member == false){
  echo '<strong class="limit-sms">You Added maximum colors for your free plan</strong>';
}else{
  ?>
 
    <input type="text" name='subject-name' placeholder="Subject Name"> <br> <br>
    <div class='color-picker-default'>
      <input type="text" name="get_colors_for_event" value="" class="color-field">
      <input type="hidden" name="user_id" value='<?php echo get_current_user_id(); ?>'>

    </div>
    <input type="submit" name='Apply'>
  

  <?php
}
  ?>
  </form>
  <div class="update-task-form"></div>
  <div class="view_task_window"></div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');
      let new_date = new Date();
      var calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        initialDate: new_date,
        navLinks: true, // can click day/week names to navigate views
        selectable: true,
        selectMirror: true,
        showNonCurrentDates: true,
        select: function(arg) {
          jQuery('.task-form').show();

          // jQuery('.fc-daygrid-day-frame.fc-scrollgrid-sync-inner').on('click', function(){
          // var startDate =  jQuery(this).parent().attr('data-date');
          var Pdate = Date.parse(arg.start);
          const formatDate = (date) => {
            let d = new Date(Pdate);
            let month = (d.getMonth() + 1).toString();
            let day = d.getDate().toString();
            let year = d.getFullYear();
            if (month.length < 2) {
              month = '0' + month;
            }
            if (day.length < 2) {
              day = '0' + day;
            }
            return [year, month, day].join('-');
          }


          var date_ahead = new Date(Pdate);
          date_ahead.setDate(date_ahead.getDate() + 15);
          const formatDate_end = (date) => {
            let d = new Date(date_ahead);
            let month = (d.getMonth() + 1).toString();
            let day = d.getDate().toString();
            let year = d.getFullYear();
            if (month.length < 2) {
              month = '0' + month;
            }
            if (day.length < 2) {
              day = '0' + day;
            }
            return [year, month, day].join('-');
          }

          jQuery('input[name="start_date"]').val(formatDate);
          jQuery('input[name="end_date"]').val(formatDate_end);

          var title = jQuery('input[name="task_title"]').val();
          if (title) {
            calendar.addEvent({
              title: title,
              start: arg.start,
              end: arg.end,
              allDay: arg.allDay
            })
          }
          calendar.unselect()
        },

        editable: false,
        dayMaxEvents: true, // allow "more" link when too many events

        events: [
          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "revision") {
          ?> {
                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        $assignment_task_subject = $select_task[$i]->assignment_task_subject;
                        $twoDays_ahead = date('Y-m-d', strtotime($date_start . ' + 2 days'));

                        if ($select_task[$i]->status == 1) {
                          echo $select_task[$i]->task_title . ' ' . 'completed';
                        } else {
                          echo $select_task[$i]->task_title;
                        }

                        ?>',
                start: '<?php echo $select_task[$i]->task_start_date; ?>',
                end: '<?php echo $twoDays_ahead; ?>',
                <?php

                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>

              },
          <?php }
          }
          ?>

          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "revision") {
          ?> {
                title: '<?php
                
                        $date_start = $select_task[$i]->task_start_date;
                        $fourDays_ahead = date('Y-m-d', strtotime($date_start . ' + 3 days'));

                        if ($select_task[$i]->status == 1) {
                          echo $select_task[$i]->task_title . ' ' . 'completed';
                        } else {
                          echo $select_task[$i]->task_title;
                        }

                        ?>',
                start: '<?php echo $fourDays_ahead; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>

          //7day

          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "revision") {
          ?> {

                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        $sevenDays_ahead = date('Y-m-d', strtotime($date_start . ' + 6 days'));

                        if ($select_task[$i]->status == 1) {
                          echo $select_task[$i]->task_title . ' ' . 'completed';
                        } else {
                          echo $select_task[$i]->task_title;
                        }

                        ?>',
                start: '<?php echo $sevenDays_ahead; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>
          //foruteendays
          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "revision") {
          ?> {
                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        //  $twoDays_ahead = date('Y-m-d', strtotime($date_start. ' + 2 days')); 
                        $fourteenDays_ahead = date('Y-m-d', strtotime($date_start . ' + 15 days'));

                        if ($select_task[$i]->status == 1) {
                          echo $select_task[$i]->task_title . ' ' . 'completed';
                        } else {
                          echo $select_task[$i]->task_title;
                        }

                        ?>',
                start: '<?php echo $fourteenDays_ahead; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>
          //revision task end

          //assignment task start
          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "assignment") {
          ?> {
                title: '<?php
                        $date_start1 = $select_task[$i]->task_start_date;
                        if ($select_task[$i]->status == 1) {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject . ' ' . 'completed';
                        } else {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject;
                        }

                        ?>',
                start: '<?php echo $date_start1; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
          <?php }
          }
          ?>

          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "assignment") {
          ?> {
                title: '<?php
                        $date_start_ass = $select_task[$i]->task_start_date;
                        $fourDays_ahead2 = date('Y-m-d', strtotime($date_start_ass . ' + 8 days'));

                        if ($select_task[$i]->status == 1) {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject . ' ' . 'completed';
                        } else {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject;
                        }

                        ?>',
                start: '<?php echo $fourDays_ahead2; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>

          //7day

          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "assignment") {
          ?> {

                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        $sevenDays_ahead = date('Y-m-d', strtotime($date_start . ' + 11 days'));

                        if ($select_task[$i]->status == 1) {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject . ' ' . 'completed';
                        } else {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject;
                        }

                        ?>',
                start: '<?php echo $sevenDays_ahead; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>


          // 14th day
          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "assignment") {
          ?> {

                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        $sevenDays_ahead = date('Y-m-d', strtotime($date_start . ' + 13 days'));

                        if ($select_task[$i]->status == 1) {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject . ' ' . 'completed';
                        } else {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject;
                        }

                        ?>',
                start: '<?php echo $sevenDays_ahead; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>

          //foruteendays
          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "assignment") {
          ?> {
                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        //  $twoDays_ahead = date('Y-m-d', strtotime($date_start. ' + 2 days')); 
                        $fourteenDays_ahead = date('Y-m-d', strtotime($date_start . ' + 14 days'));

                        if ($select_task[$i]->status == 1) {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject . ' ' . 'completed';
                        } else {
                          echo 'Rev of ' . $select_task[$i]->assignment_task_subject;
                        }

                        ?>',
                start: '<?php echo $fourteenDays_ahead; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>

          //lastday

          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type == "assignment") {
          ?> {
                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;
                        $testDay = date('Y-m-d', strtotime($date_start . ' + 15 days'));

                        if ($select_task[$i]->status == 1) {
                          echo $select_task[$i]->assignment_task_subject . ' ' . 'Test completed';
                        } else {
                          echo $select_task[$i]->assignment_task_subject . ' Test';
                        }

                        ?>',
                start: '<?php echo $testDay; ?>',
                <?php
                for ($s = 0; $s < $count_rows_color; $s++) {

                  if ($select_task[$i]->assignment_task_subject == $get_color_table[$s]->subjects) {
                ?>
                    backgroundColor: '<?php echo $get_color_table[$s]->color; ?>',
                    borderColor: '<?php echo $get_color_table[$s]->color; ?>',
                <?php
                  }
                }
                ?>
              },
            <?php } ?>
          <?php } ?>

          //assignment task end
          //non revision & assignment tasks
          <?php for ($i = 0; $i < $count_rows; $i++) {
            if ($select_task[$i]->task_type != "assignment" && $select_task[$i]->task_type != "revision") { ?> {
                title: '<?php
                        $date_start = $select_task[$i]->task_start_date;

                        if ($select_task[$i]->status == 1) {
                          echo $select_task[$i]->task_title . ' ' . 'completed';
                        } else {
                          echo $select_task[$i]->task_title;
                        }

                        ?>',
                start: '<?php echo $date_start; ?>',
                end: '<?php echo $select_task[$i]->task_end_date; ?>',


              },
            <?php } ?>
          <?php } ?>
        ]

      });


      calendar.render();
    });
  </script>
</body>


</html>
