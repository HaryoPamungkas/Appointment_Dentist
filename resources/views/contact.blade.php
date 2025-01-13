<section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Jika Anda memiliki pertanyaan spesifik tentang kami maupun layanan kami, jangan ragu untuk menghubungi Kanna Dentist. Kami akan dengan senang hati menjawab pertanyaan Anda.</p>
        </div>

      </div>

      <div>
        <iframe style="border:0; width: 100%; height: 350px;" 
            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d9906.483780748108!2d106.73848907281682!3d-6.213635652870403!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTInNDguNiJTIDEwNsKwNDQnMTguNyJF!5e0!3m2!1sen!2sid!4v1539943755621" 
            frameborder="0" allowfullscreen></iframe>
      </div>

      <div class="container">

        <div class="row mt-5">

          <div class="col-lg-6">

            <div class="row">
              <div class="col-md-12">
                <div class="info-box">
                  <i class="bx bx-map"></i>
                  <h3>Our Address</h3>
                  <p>Jl. Merdeka No. 123, Kelurahan Setia Budi, Kecamatan Menteng, <br>
                  Jakarta Pusat, Jakarta</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box mt-4">
                  <i class="bx bx-envelope"></i>
                  <h3>Email Us</h3>
                  <p>kdentist@co.id<br>kannadentist@gmail.com</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box mt-4"> 
                  <i class="bx bx-phone-call"></i>
                  <h3>Call Us</h3>
                  <p>+62 123 123 123<br>+62 456 456 456</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
            <form id="messageForm" action="{{route('contact.store')}}" method="POST" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">
              @csrf
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="">
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="7" placeholder="Message" required=""></textarea>
              </div>
              <div class="my-3">
                <div class="sent-message" id="successMessage" style="display:none;"></div>
                <div class="error-message" id="errorMessage" style="display:none;"></div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div>

        </div>

      </div>
</section>
 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#messageForm').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: form.attr('action'),
                data: formData,
                dataType: 'json', 
                success: function(response) {
                  $('#successMessage').text('Pesan berhasil terkirim!').slideDown();
                  $('#errorMessage').hide(); 
                  form.trigger('reset'); 
                },
                error: function(xhr, status, error) {
                  $('#errorMessage').text('Error: Gagal mengirim appointment. Please try again.').slideDown();
                  $('#successMessage').hide(); 
                  form.trigger('reset'); 
                }
            });
        });
    });
</script>

