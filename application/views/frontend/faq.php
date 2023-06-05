<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <ol>
          <li><a href="index.html">Home</a></li>
          <li>FAQ</li>
        </ol>
        <h2>FAQ (Frequently Asked Question)</h2>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
      <div class="container" id="load-faq">

        

      </div>
    </section><!-- End Team Section -->

  </main><!-- End #main -->

  <script>
    $(document).ready(function(){
      $.ajax({
        url:'<?= base_url('loadFaq') ?>',
        dataType:'html',
        beforeSend:function(){
          $('#load-faq').html(`
            <div class="text-center">
              <i class="icofont-spinner-alt-2"></i> memuat data
            </div>
            `)
        },
        success:function(response){
          $('#load-faq').html(response)
        }
      })
    })
  </script>