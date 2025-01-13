<section id="appointment" class="appointment section-bg">
    <div class="container" data-aos="fade-up">
        <div class="section-title">
            <h2>Make an <span style="color: #1b75bc; font-style: italic;">Appointment</span></h2>
            <p>Silakan isi data diri anda dan pelayanan yang diinginkan.</p>
        </div>

        <form id="appointmentForm" action="{{ route('appointment.store') }}" method="POST" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">
            @csrf
            <div class="row">
                <div class="col-md-4 form-group">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
                <div class="col-md-4 form-group mt-3 mt-md-0">
                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Your Phone" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 form-group mt-3">
                    <select name="doctor" id="doctor" class="form-select">
                        <option value="">Select Doctor</option>
                        <option value="Dr. Walter White">Dr. Walter White</option>
                        <option value="Dr. Sarah Jhonson">Dr. Sarah Jhonson</option>
                        <option value="Dr. William Anderson">Dr. William Anderson</option>
                        <option value="Dr. Amanda Jepson">Dr. Amanda Jepson</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mt-3">
                    <select name="services" id="services" class="form-select">
                        <option value="">Select services</option>
                        <option value="scaling"> Scaling</option>
                        <option value="bleaching"> Bleaching</option>
                        <option value="veener"> Veener</option>
                    </select>
                </div>
                <div class="col-md-4 form-group mt-3">
                    <input type="text" name="date" class="form-control" id="date" placeholder="Appointment Date" required>
                </div>
            </div>

            <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message (Optional)"></textarea>
            </div>
            <div class="my-3">
                <div class="sent-message" id="successMessage" style="display:none;">Appointment berhasil dibuat!</div>
                <div class="error-message" id="errorMessage" style="display:none;">Error: Gagal mengirim appointment. Mohon coba lagi.</div>
            </div>
            <div class="text-center"><button type="submit">Make an Appointment</button></div>
        </form>
    </div>
</section>

<!-- Modal for Available Times -->
<div class="modal fade" id="availabilityModal" tabindex="-1" role="dialog" aria-labelledby="availabilityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="availabilityModalLabel">Available Times</h5>
            </div>
            <div class="modal-body">
                <p>The selected time slot is already booked. Please choose another time from the available times below:</p>
                <ul id="availableTimesList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<script>
    $(document).ready(function() {
    var today = new Date();
    var endOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);

    var flatpickrOptions = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minuteIncrement: 60,
        defaultHour: 10,
        defaultMinute: 0,
        minDate: today,
        maxDate: endOfMonth,
        disableMobile: true,
        disable: [
            function(date) {
                return (date.getDay() === 0 || date.getDay() === 6);
            },
            function(date) {
                if (date.toDateString() === today.toDateString() && today.getHours() >= 18) {
                    return true;
                }
                return false;
            }
        ],
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length > 0) {
                var selectedDate = selectedDates[0];
                var minTime = "10:00";
                if (selectedDate.toDateString() === today.toDateString()) {
                    var currentHour = today.getHours();
                    if (currentHour < 10) {
                        minTime = "10:00";
                    } else if (currentHour >= 10 && currentHour < 18) {
                        minTime = currentHour + ":00";
                    } else {
                        minTime = "18:00";
                    }
                }
                instance.set("minTime", minTime);
                instance.set("maxTime", "18:00");
            }
        }
    };

    if (today.getHours() >= 18) {
        flatpickrOptions.disable.push(today);
    }

    var flatpickrInstance = flatpickr("#date", flatpickrOptions);

    $('#date, #doctor').on('change', function() {
        var date = $('#date').val().split(' ')[0];
        var doctor = $('#doctor').val();

        if (date && doctor) {
            $.ajax({
                type: 'POST',
                url: '{{ route("appointment.checkAvailability") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    date: date,
                    doctor: doctor
                },
                success: function(response) {
                    var bookedHours = response.booked;
                    var availableHours = response.available;

                    var selectedDate = flatpickrInstance.selectedDates[0];
                    var selectedHour = selectedDate.getHours();
                    var selectedTime = selectedHour + ":00";

                    if (bookedHours.includes(selectedTime)) {
                        var availableTimesHtml = availableHours.map(function(time) {
                            return '<li>' + time + '</li>';
                        }).join('');

                        $('#availableTimesList').html(availableTimesHtml);
                        $('#availabilityModal').modal('show');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    $('#appointmentForm').submit(function(event) {
        event.preventDefault();
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('p').hide();
                $('#appointmentForm').children().not('.my-3').hide();
                $('#appointmentForm').trigger('reset');
                $('#successMessage').show();
                $('#errorMessage').hide();
            },
            error: function(xhr, status, error) {
                if (xhr.status === 422) {
                    var errorMessage = JSON.parse(xhr.responseText).message;
                    $('#errorMessage').text(errorMessage).show();
                    $('#successMessage').hide();
                } else {
                    $('#errorMessage').text('Error: Failed to submit appointment. Please try again later.').show();
                    $('#successMessage').hide();
                }
            }
        });
    });
});
</script>
