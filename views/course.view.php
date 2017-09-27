<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
      .form-check .fa {
        display: none;
      }
      .form-check.loading .fa-pulse,
      .form-check.loaded .fa-check-square {
        display: inline-block;
      }
      /*.form-check.loaded .fa-pulse {
        display: none;
      }*/
    </style>
    <title>Download Lynda.com videos</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-7 p-5">
          <h1>Course episodes</h1>
          <a href="/"><i class="fa fa-long-arrow-left"></i> Home</a>
          <input type="hidden" id="course-id" value="<?=$_GET['id']?>">
          <form action="" id="course-form">
            <?php foreach ($episodes as $key => $episode) : ?>
              <div class="form-check" id="ep_<?=$key?>">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="ep_<?=$key?>" value="<?=$key?>">
                  <?=$episode->name?> (<?=$key+1?>)
                </label>
                <i class="fa fa-spinner fa-pulse fa-fw"></i>
                <i class="fa fa-check-square"></i>
              </div>
            <?php endforeach; ?>
          </form>
        </div>
        <div class="col-md-5 p-5">
          <div style="position: sticky; top: 5px;">
            <button class="btn btn-block btn-primary download download-all">Download all</button>
            <button class="btn btn-block btn-dark download">Download selected</button>
            <button id="toggle-select" class="btn btn-block btn-light">Toggle selected</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
      var $form = $('#course-form'), selected = false;
      $('.download').on('click', function(e) {
        e.preventDefault();
        
        if($(this).hasClass('download-all'))
          $form.find('input.form-check-input').prop('checked', true);

        var data = $form.serialize();
        var episodes = data.split('&').map(function(i) {
          return i.split('=')[1];
        });
        var courseId = $('#course-id').val();

        var downloadDone = 0;
        function downloadNext(epId) {
          $.ajax({
            url: 'download.php?course_id=' + courseId + '&ep_id=' + epId,
            beforeSend: function() {
              $('#ep_' + epId).removeClass('loaded').addClass('loading');
            }
          }).done(function(r) {
            if(r === 'done') {
              $('#ep_' + epId).toggleClass('loading loaded');
              downloadDone++;
              if(episodes.length > downloadDone) {
                downloadNext(episodes[downloadDone], courseId);
              }
            }
          });
        }
        downloadNext(episodes[downloadDone]);
      });

      var $checkboxes = $form.find('input.form-check-input');

      $('#toggle-select').on('click', function(e) {
        e.preventDefault();
        selected = !selected;
        $checkboxes.prop('checked', selected);
      });

      var lastSelect = null;
      $checkboxes.on('click', function(e) {
        console.log(lastSelect);
        if(!lastSelect) {
          lastSelect = this;
          return;
        }
        if(e.shiftKey) {
          var start = $checkboxes.index(this), end = $checkboxes.index(lastSelect);
          $checkboxes.slice(Math.min(start, end), Math.max(start, end) + 1).prop('checked', lastSelect.checked);
        }

        lastSelect = this;
      });

      // $('.form-check-label').on('click', function(e) {
      //   if(e.shiftKey) {
      //     e.preventDefault();
      //     $(this).children('input.form-check-input').trigger('click');
      //   }
      // })


    </script>

  </body>
</html>
















