<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>
  <body>

  <!--    
  <form method="post" action="{{url('/upload')}}" enctype="multipart/form-data">
    {{ csrf_field() }}
    ...
    <div class="form-group">
        <label for="author">Cover:</label>
        <input type="file" class="form-control" name="photo"/>
        <button type="submit">Upload</button>
    </div>
    ...
    

  </form>
  -->

  <div class="container">
    <a href="#" id="browseButton" class="btn btn-primary btn-block">Select files</a>
    <div id="exifData">
    </div>
  </div>

  

  

  

  <script src="{{ mix('/js/app.js') }}"></script>
  </body>
</html>




