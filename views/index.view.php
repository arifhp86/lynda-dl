<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Download Lynda.com videos</title>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-12 p-5">
          <h1>Courses</h1>
          <ul>
            <?php foreach ($courses as $key => $course) : ?>
              <li>
                <a href="/course.php?id=<?=$course->id?>"><?=$course->name?></a>
                <a href="/?delete=<?=$course->id?>"><i class="fa fa-times-circle"></i></a>
              </li>
            <?php endforeach; ?>
          </ul>

          <form action="/" method="post">
            <div class="form-group">
              <label for="link">New Course link</label>
              <input type="text" name="link" class="form-control" id="link" required>
            </div>
            <button type="submit" class="btn btn-primary">Add course</button>
          </form>
        </div>
      </div>
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  </body>
</html>