@extends('layouts.app')
@stack('title')
<title>Home</title>
@section('content')
    <div class="container">
        <h1 class="text-center text-success">Welcome to WeLo</h1>
        <h5 class="text-center">Call: +92-1234567890</h5>
        <h6 class="text-center">We Have best Doctors</h6>
        <div class="px-5"
            style="margin: auto;  width: 50%; padding: 10px;  border-radius: 20pt;  background-image: linear-gradient(to right, rgba(200, 40, 30, 0), rgb(146, 74, 74))">
            <form id="check_availablity">
                <div class="row">
                    <div class="form-group col-sm">
                        <label for="findDate" class="sr-only">Date:</label>
                        <input type="date" required class="form-control" id="findDate" name="date"
                            min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="form-group col-sm">
                        <label for="findTime" class="sr-only">Time Slots:</label>
                        <select class="form-control" name="timeSlot" id="findTime" required>
                            <option class="text-center" value="" selected disabled>--:-- --</span></option>
                            <option value="3:00 - 4:00">3:00 - 4:00</option>
                            <option value="4:00 - 5:00">4:00 - 5:00</option>
                            <option value="5:00 - 6:00">5:00 - 6:00</option>
                            <option value="6:00 - 7:00">6:00 - 7:00</option>
                            <option value="7:00 - 8:00">7:00 - 8:00</option>
                            <option value="8:00 - 9:00">8:00 - 9:00</option>
                            <option value="9:00 - 10:00">9:00 - 10:00</option>
                        </select>
                    </div>

                    <div class="form-group col-sm mt-4">
                        <button id="find_btn" type="submit" class="btn btn-primary">Find</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#user_form_modal">Submit</button> --}}

        <div class="row w-50">
            <!-- Modal -->
            <div class="modal fade" id="user_form_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 text-success">This Slot is Available</h1>
                            <button type="button" id="close_modal_cross_btn" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="user_form">
                                <div class="form-group">
                                    <label for="fullName">Full Name</label>
                                    <input type="text" class="form-control" name="fullName" id="fullName"
                                        placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <label for="fullName">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Email Address">
                                    {{-- <span id="email_error" class="text-danger">Email format not correct!</span> --}}
                                </div>
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" required class="form-control text-center" readonly id="date"
                                        name="date">
                                </div>
                                <div class="form-group">
                                    <label for="date">Time Slot</label>
                                    <input type="text" class="form-control text-center" name="timeSlot" id="timeSlot"
                                        readonly required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="close_modal_btn" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" id="add_user_btn" class="btn btn-primary">Submit/Forward</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            // $("#email_error").hide();
            // Check slot availiblity
            $("#check_availablity").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const selectedDate = new Date(formData.get('date'));
                selectedDate.setDate(selectedDate.getDate() + 1);
                const currentDate = new Date();

                if (selectedDate <= currentDate) {
                    Swal.fire(
                        'Invalid Date',
                        'Please select a future date',
                        'error'
                    );
                    return;
                }
                $("#find_btn").text("Checking...");
                $.ajax({
                    url: '{{ route('availblity') }}',
                    method: 'post',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',

                    success: function(response) {
                        if (response.message == 200) {
                            $("#user_form_modal").modal('show');
                            const dateValue = formData.get('date');
                            const timeSlotValue = formData.get('timeSlot');

                            $('#user_form #date').val(dateValue);
                            $('#user_form #timeSlot').val(timeSlotValue);
                            $("#user_form_modal").modal('show');
                        } else if (response.message == 404) {
                            Swal.fire(
                                'Sorry',
                                'We apologize because on that day this Time slot is not available',
                                'error'
                            );
                        }
                        $("#close_modal_btn").show();
                        $("#close_modal_cross_btn").show();
                        $("#find_btn").text("Find");
                    }
                });
            });

            $("#user_form").submit(function(e) {
                e.preventDefault();
                const fd = new FormData(this);
                $("#close_modal_btn").hide()
                $("#close_modal_cross_btn").hide()
                $("#add_user_btn").text('Please Wait...').attr('disabled', 'disabled');
                $.ajax({
                    url: '{{ route('user.store') }}',
                    method: 'post',
                    data: fd,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 200) {
                            Swal.fire(
                                'Added!',
                                'Requested Successfully!',
                                'success'
                            )
                            $("#user_form_modal").modal('hide');
                            $("#add_user_btn").removeAttr('disabled').text('Submit/Forward');

                            $("#user_form")[0].reset();
                            $("#check_availablity")[0].reset();
                            // $("#email_error").hide();
                        } else if (response.status == 404) {
                            Swal.fire(
                                'Sorry',
                                'Email or Username format not correct',
                                'warning'
                            );
                            // $("#email_error").show();
                            $("#add_user_btn").removeAttr('disabled').text('Submit/Forward');
                            $("#add_user_btn").text('Submit/Forward');
                        }
                    }
                });
            });
        });
    </script>
@endsection
