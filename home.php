<?php
// session_start();
include_once("header.php");
// print_r($_SESSION);
?>

<style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }

      tr.info
      {
        font-weight: bold;
      }

      tr td{
        overflow: hidden;
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      .container {
        width: 0 auto;
        max-width: 960;
      }
      .container .credit {
        margin: 20px 0;
      }

      .page-header h4
      {
        font-weight: normal;
      }

      </style>

      <body>


        <!-- Part 1: Wrap all page content here -->
        <div id="wrap">

          <!-- Begin page content -->
          <div class="container">
            <div class="page-header">
              <h1>PTIIK Mail</h1>
              <h4>Mail Client App Example with SMTP dan IMAP</h4>
            </div>


            <table class="table table-stripped table-hover">
              <thead>
                <tr>
                  <th>Sender</th>
                  <th>Subject</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <?php

                rsort($email);
                
                $body_arr = array();
                foreach($email as $email_id)
                {
            
                  // Fetch the email's overview and show subject, from and date. 
                  
                  $overview = imap_fetch_overview($imap_handle, $email_id, 0);
                  $body = imap_fetchbody($imap_handle, $email_id, 2);    
                  
                  // echo "<pre>";
                  // var_dump($overview);
                  // var_dump($body);
                  
                  $seen = $overview[0]->seen;
                  $from = $overview[0]->from;
                  $subject = $overview[0]->subject;

                  if(strlen($subject)>=50)
                  {
                    $subject = substr($subject, 0, 45)."...";
                  }
                  $date = explode(" ", $overview[0]->date);
                  $date = $date[0]." ".$date[1]." ".$date[2]." ".$date[3];
                  // $date = explode("-", $overview[0]->date);
                  ?>

                  <tr class="<?php echo $seen? '':'info' ?>" id="<?php echo $email_id ?>">
                  <td><?php echo $from?></td>
                  <td><?php echo $subject ?></td>
                  <td><?php echo $date ?></td>
                  <!-- <td><?php echo $body ?></td> -->
                  </tr>

                  <?php

                  array_push($body_arr, $email_id."||".$body);

                  // var_dump($body_arr);

                  ?>
                  
                  <?
                } 
            ?>
                
              </tbody>
            </table>

            <!-- <div id="message-area" style="display: none"> -->
              <?php

              foreach ($body_arr as $key => $value) {

                  $body = explode("||", $value);
                  $id = $body[0];
                  $message = $body[1];
              ?>

              <div id="message<?php echo $id ?>" class="message">
                <a class="btn back" id="<?php echo $id ?>">Back</a>
                <?php echo $message ?>
              </div>

              <?php
              }

              ?>
            <!-- </div> -->
            <!-- <p class="lead">Pin a fixed-height footer to the bottom of the viewport in desktop browsers with this custom HTML and CSS.</p> -->
          </div>

          <div id="push"></div>
        </div>

        <div id="footer">
          <div class="container">
            <p class="muted credit">
              Pemrograman Jaringan | Aldim Irfani Vikri - Yuri Citra Pratama - Delis Sukmawati  </p>
          </div>
        </div>

        <?php

        include_once("footer.php");
        include_once("new.php");

        ?>

        <script type="text/javascript">

        $(".message").hide();

        $("table tr").click(function(){

          // alert("ini isi message");
          var id = $(this).attr("id");
          // alert(id);
          // $("#message-area").show(); // show message
          $("div#message"+id).show();// show message
          // $("div.message#")
          // $(".message#"+id).attr("style", "display: block"); // show message
          $("table").hide(); // hide table

        });

        $("a.back").live("click", function(){

          var id = $(this).attr("id");
          // $("#message-area").hide(); // show message
          $("div#message"+id).hide(); // show message
          $("table").show(); // hide table
        });


        </script>

        