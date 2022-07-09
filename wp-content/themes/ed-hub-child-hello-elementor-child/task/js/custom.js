
jQuery(document).ready(function ($) {
  $(function () {
    $('.color-field').wpColorPicker();
  });
  $('.lds-ring.edit-subj').hide();
  $('.task-form').hide();
  $('#assignment_subjects').hide();
  $('.color-picker1').hide();
  $('.color-picker2').hide();
  $('#up_assignment_subjects').hide();
  $('.update-task-form').hide();
  $('.view_task_window').hide();
  $('.lds-ring').hide();
  $('.lds-ring-task-inert').hide();
  $('input[name="apply"]').css('cursor', 'pointer');
  $('.fc-event-title.fc-sticky:contains(completed)').css('text-decoration', 'line-through');

  $('select[name="task_type"]').change(function () {
    var task_subject = jQuery(this).val();
    jQuery('input[name="task_subject"]').val(task_subject);
  })

  $('select[name="task_type"]').change(function () {
    var get_assighment = $('select[name="task_type"] option:selected').val();
    if (get_assighment == 'assignment' || get_assighment == 'revision') {
      $('#assignment_subjects').show();
      var subj = $('input[name="get_colors_for_event"]').attr('id');
      $('select[name="assignment_subjects"]').change(function () {
        var get_subject = $('select[name="assignment_subjects"] option:selected').val();


        if (get_subject == 'maths') {   //.maths

          $('.color-picker1').show();

          $('.color-picker2').hide();
          if ($('.color-picker1').length) {
            $('.color-picker-default').hide();
          } else {
            $('.color-picker-default').show();
          }

        } else if (get_subject == 'physics') { //physics

          // $('.color-picker-default').hide();
          $('.color-picker2').show();
          $('.color-picker1').hide();
          if ($('.color-picker2').length) {
            $('.color-picker-default').hide();
          } else {
            $('.color-picker-default').show();
          }
        } else {
          $('.color-picker1').hide();
          $('.color-picker2').hide();
        }


      });

    } else {
      $('#assignment_subjects').hide();
    }
  });
  $('select[name="up_task_type"]').change(function () {
    var get_assighment = $('select[name="up_task_type"] option:selected').val();
    if (get_assighment == 'assignment' || get_assighment == 'revision') {
      $('#up_assignment_subjects').show();
    } else {
      $('#assignment_subjects').hide();
    }
  });

  $('#daily-task-form').on('submit', function (e) {
    e.preventDefault();

    $('.lds-ring-task-inert').show();
    $('#daily-task-form input[type="submit"]').prop('disabled', true);
    var formdata = new FormData(this);
    formdata.append('action', 'save_tasks');
    jQuery.ajax({
      type: 'POST',
      cache: false,
      contentType: false,
      processData: false,
      url: ed_hub.ajaxurl,
      data: formdata,
      success: function (data) {
        $('.lds-ring-task-inert').hide();
        location.reload();
        // $(this).submit();
      }, error: function (errorThrown) {
        $('.lds-ring-task-inert').hide();
        console.log(errorThrown);
      }
    })

    jQuery('.fc-daygrid-day-frame.fc-scrollgrid-sync-inner').each(function () {

      jQuery('.fc-daygrid-day-frame.fc-scrollgrid-sync-inner a').on('click', function () {
        console.log('ok');
      })
    })

  })
  //close task form
  $('.close-task-form a').click(function () {
    $('.task-form').hide();
  })


  $('.task-delete').click(function () {
    var task_id = $(this).attr('data-id');
    var task_type = $(this).attr('data-taskType');
    var data_taskKey = $(this).attr('data-taskKey');
    var tsk_delete = confirm('Are your sure you want to delete this ' + task_type + ' task');
    if (tsk_delete) {
      $('.lds-ring').show();
      jQuery.ajax({
        type: 'POST',
        url: ed_hub.ajaxurl,
        data: {
          action: 'delete_tasks',
          taslID: task_id,
          taskKey: data_taskKey
        },
        success: function (data) {
          location.reload();
          $('.lds-ring').hide();
        }, error: function (errorThrown) {
          console.log(errorThrown);
          $('.lds-ring').hide();
        }
      })
    }



  })

  $('.task-update').click(function () {
    var task_id = $(this).attr('data-id');
    $('.lds-ring').show();
    // $('.update-task-form').show('slow');
    $.ajax({
      type: 'POST',
      url: ed_hub.ajaxurl,
      data: {
        action: 'update_task_detials',
        taslID: task_id
      },
      success: function (data) {
        $('.lds-ring').hide();
        $('.update-task-form').show();
        $('.update-task-form').html(data);
        $('.close-up_task-form a').click(function () {
          $('.update-task-form').hide();
        })
        $('#task-update-form').on('submit', function (e) {
          e.preventDefault();

          var formdata = new FormData(this);
          formdata.append('action', 'update_task');
          $.ajax({
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            url: ed_hub.ajaxurl,
            data: formdata,
            success: function (data) {
              alert('Task updated');
              location.reload();
            }, error: function (errorThrown) {
              console.log(errorThrown);
            }

          })

        })
      }, error: function (errorThrown) {
        console.log(errorThrown);
        $('.lds-ring').hide();
        alert('Failure');
      }
    })

  })

  $('.task-complete').click(function () {
    var task_id = $(this).attr('data-id');
    $('.lds-ring').show();

    jQuery.ajax({
      type: 'POST',
      url: ed_hub.ajaxurl,
      data: {
        action: 'complete_edhub_task',
        taslID: task_id
      },
      success: function (data) {
        location.reload();
        alert('Task Marked as completed');
        $('.lds-ring').hide();
      }, error: function (errorThrown) {
        console.log(errorThrown);
        $('.lds-ring').hide();
      }
    })

  })
  $('#color-picker-form').on('submit', function (e) {
    e.preventDefault();
    $('input[name="apply"]').prop('disabled', true);
    $('input[name="apply"]').css('cursor', 'not-allowed');

    var formdata = new FormData(this);
    formdata.append('action', 'change_strip_col_func');

    $.ajax({
      type: 'POST',
      cache: false,
      contentType: false,
      processData: false,
      url: ed_hub.ajaxurl,
      data: formdata,
      success: function (data) {
        alert(data);
        location.reload();
      }, error: function (errorThrown) {
        console.log(errorThrown);
        $('input[name="apply"]').prop('disabled', false);
      }

    })

  })
  //Click to view task.
  jQuery('ul.task-list-main li').click(function () {

    var clicked_task_id = jQuery(this).attr('data-id');
    $.ajax({
      type: 'POST',
      url: ed_hub.ajaxurl,
      data: {
        action: 'display_taskData_in_popup_function',
        taskID: clicked_task_id,
      },
      success: function (data) {
        $('.view_task_window').show();
        $('.view_task_window').html(data);
        jQuery('.close-up_task-view').click(function () {
          $('.view_task_window').hide();
        })
      }, error: function (errorThrown) {
        console.log(errorThrown);
      }

    })
  })
  jQuery('form.subjects-form').on('click', function () {
    // jQuery(this).each(function(){
    jQuery(this).find('input[name="submit_subj"]').prop('disabled', false);
    // })
  })

  jQuery('form.subjects-form').on( 'submit' , function (e) {
    e.preventDefault();
    // alert('ok');
    // return;
    $(this).find('.lds-ring.edit-subj').show();
      var user_ids = jQuery(this).find('input[name="user_id"]').val();    
      var subject_id = jQuery(this).find('input[name="subject_id"]').val();    
      var subjects = jQuery(this).find('input[name="edit-subjects"]').val();    
      jQuery.ajax({
        type: 'GET',
        url: ed_hub.ajaxurl,
        data: {
          action: 'edh_update_edit_subjects',
          userId: user_ids,
          subject: subjects,
          subject_id: subject_id,
        },
        success: function (data) {
          $('.lds-ring.edit-subj').hide();
          location.reload();
        }, error: function (errorThrown) {
          $('.lds-ring.edit-subj').hide();
          console.log(errorThrown);
        }
  
      })
  })

  jQuery('.del-subj a').click(function(){
    var subject_id = jQuery(this).attr('data-SubjectId');
    jQuery.ajax({
      type: 'GET',
      url: ed_hub.ajaxurl,
      data: {
        action: 'edh_delete_subjects',
        subject_id: subject_id,
      },
      success: function (data) {
        location.reload();
      }, error: function (errorThrown) {
        console.log(errorThrown);
      }

    })
  })

});


