 <script>
      $(document).ready(function() {
        'use strict'

        $('[data-toggle="tooltip"]').tooltip()


      });
    </script>
    <script>
        //disable right mouse click
        $(function() {
            $(this).bind("contextmenu", function(e) {
                e.preventDefault();
            });
        });
      </script>