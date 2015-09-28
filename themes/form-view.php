<html>
<head> 
  <title> Ajax Exmaples! </title>
  <!--Load JQUERY from Google's network -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  <script> 
    $(document).ready(function () {
      $("#button").click(function () {
        $.get("/ajax/", function (time) {
          $("#text").html("Time on the server is:" + time);
        });
      });
    });
  </script>
</head>
<body>
  <h1> Get Data from Server over Ajax </h1>
  <textarea id="text" readonly>
  </textarea>
  <br/>
  <button id="button">
    Get Time from Server
  </button>
</body>
</html>