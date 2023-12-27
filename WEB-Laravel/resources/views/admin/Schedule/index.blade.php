@extends('layouts.admin.template')

@section('content')
    <script>
        // Setup module
        // ------------------------------

        var DateTimePickers = function() {
            const _componentDaterange = function() {
                if (!$().daterangepicker) {
                    console.warn('Warning - daterangepicker.js is not loaded.');
                    return;
                }

                // Basic initialization
                $('.daterange-basic').daterangepicker({
                    parentEl: '.content-inner'
                });

            };

            // Date picker
            const _componentDatepicker = function() {
                if (typeof Datepicker == 'undefined') {
                    console.warn('Warning - datepicker.min.js is not loaded.');
                    return;
                }

                const dpAutoHideElement3 = document.querySelector('.datepicker-autohide3');
                if (dpAutoHideElement3) {
                    const dpAutoHide = new Datepicker(dpAutoHideElement3, {
                        container: '.content-inner',
                        buttonClass: 'btn',
                        prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
                        nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;',
                        autohide: true
                    });
                }

            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDaterange();
                    _componentDatepicker();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DateTimePickers.init();
        });
    </script>
    <style>
        .datepicker {
            z-index: 1060;
        }
    </style>
    <script>
        function addSchedule() {
            const notyWarning = new Noty({
                text: "Kedua field harus diisi sebelum mengirimkan form.",
                type: "warning",
                progressBar: false,
                layout: 'topCenter',
            });
            const notyError = new Noty({
                text: "Terjadi kesalahan saat mengirimkan data.",
                type: "error",
                progressBar: false,
                layout: 'topCenter',
            });
            $("#addScheduleForm").on("submit", function(e) {
                e.preventDefault();
                let scheduleDateValue = $("input[name='bloodTypeName']").val();
                let descriptionValue = $("textarea[name='description']").val();
                if (scheduleDateValue.trim() !== "" && descriptionValue.trim() !== "") {
                    let formData = $(this).serialize();
                    $.ajax({
                        type: "POST",
                        url: 'jadwal/tambah',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            $("#modal_default_tabCreate").modal("hide");
                            $("#addScheduleForm")[0].reset();
                            location.reload();
                        },
                        error: function(data) {
                            notyError.setText(data.responseText ||
                                "Terjadi kesalahan saat mengirimkan data.");
                            notyError.show();
                        },
                    });
                } else {
                    notyWarning.show();
                }
            });
        }
    </script>

    <script>
        const FullCalendarStyling = function() {


            //
            // Setup module components
            //

            // External events
            const _componentFullCalendarStyling = function() {
                if (typeof FullCalendar == 'undefined') {
                    console.warn('Warning - Fullcalendar files are not loaded.');
                    return;
                }


                // Add events
                // ------------------------------

                // Event colors
                const eventColors = [{
                        
                    }
                   
                ];

                // Event background colors
                const eventBackgroundColors = [{
                        title: 'Business Lunch',
                        start: '2020-09-03T13:00:00',
                        constraint: 'businessHours'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-09-13T11:00:00',
                        constraint: 'availableForMeeting', // defined below
                        color: '#257e4a'
                    },
                    {
                        title: 'Conference',
                        start: '2020-09-18',
                        end: '2020-09-20'
                    },
                    {
                        title: 'Party',
                        start: '2020-09-29T20:00:00'
                    },

                    // areas where "Meeting" must be dropped
                    {
                        groupId: 'availableForMeeting',
                        start: '2020-09-11T10:00:00',
                        end: '2020-09-11T16:00:00',
                        display: 'background'
                    },
                    {
                        groupId: 'availableForMeeting',
                        start: '2020-09-13T10:00:00',
                        end: '2020-09-13T16:00:00',
                        display: 'background'
                    },

                    // red areas where no events can be dropped
                    {
                        start: '2020-09-24',
                        end: '2020-09-28',
                        overlap: false,
                        display: 'background',
                        color: '#ff9f89'
                    },
                    {
                        start: '2020-09-06',
                        end: '2020-09-08',
                        overlap: false,
                        display: 'background',
                        color: '#ff9f89'
                    }
                ];


                // Initialization
                // ------------------------------

                //
                // Event colors
                //

                // Define element
                const calendarEventColorsElement = document.querySelector('.fullcalendar-event-colors');

                // Initialize
                if (calendarEventColorsElement) {
                    const calendarEventColorsInit = new FullCalendar.Calendar(calendarEventColorsElement, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,dayGridWeek,dayGridDay'
                        },
                        initialDate: '2023-09-12',
                        navLinks: true, // can click day/week names to navigate views
                        businessHours: true, // display business hours
                        editable: true,
                        selectable: true,
                        editable: true,
                        direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                        events: eventColors
                    });

                    // Init
                    calendarEventColorsInit.render();

                    // Resize calendar when sidebar toggler is clicked
                    document.querySelectorAll('.sidebar-control').forEach(function(sidebarToggle) {
                        sidebarToggle.addEventListener('click', function() {
                            calendarEventColorsInit.updateSize();
                        })
                    });
                }


                //
                // Event background colors
                //

                // Define element
                const calendarEventBgColorsElement = document.querySelector('.fullcalendar-background-colors');

                // Initialize
                if (calendarEventBgColorsElement) {
                    const calendarEventBgColorsInit = new FullCalendar.Calendar(calendarEventBgColorsElement, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        initialDate: '2020-09-12',
                        navLinks: true, // can click day/week names to navigate views
                        businessHours: true, // display business hours
                        editable: true,
                        selectable: true,
                        direction: document.dir == 'rtl' ? 'rtl' : 'ltr',
                        events: eventBackgroundColors
                    });

                    // Init
                    calendarEventBgColorsInit.render();

                    // Resize calendar when sidebar toggler is clicked
                    document.querySelectorAll('.sidebar-control').forEach(function(sidebarToggle) {
                        sidebarToggle.addEventListener('click', function() {
                            calendarEventBgColorsInit.updateSize();
                        })
                    });
                }
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentFullCalendarStyling();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            FullCalendarStyling.init();
        });
    </script>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Jadwal Bank Sampah</h5>
            <div class="justify-content text-end">
                <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Jadwal Keliling</span></button>
                <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                    data-bs-target="#modal_default_tabCreate2"><i class="ph-plus-circle"></i><span
                        class="d-none d-lg-inline-block ms-2">Tambah Jadwal Rutin</span></button>
            </div>
        </div>

        <div class="card-body">
            <div class="fullcalendar-event-colors"></div>
        </div>
    </div>

    <div id="modal_default_tabCreate" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Keliling</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="addScheduleForm">
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-3">
                                <label for="supplier" class="col-sm-4 col-form-label">Tanggal :</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <input id="tanggal-pembelian" type="text" readonly value="{{ $data->PickupDate ?? request()->PickupDate }}"
                                            class="form-control datepicker-autohide3" placeholder="Masukkan Tanggal">
                                        <span class="input-group-text">
                                            <i class="ph-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-lg-4 col-form-label">Jam:</label>
                                <div class="col-sm-3">
                                    <input name="description" class="form-control" placeholder="08:30:00" readonly></input>
                                </div>
                                <div class="col-sm-3">
                                    <input name="description" class="form-control" placeholder="09:30:00" readonly></input>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_kirim" class="col-lg-4 col-form-label">Petugas:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <select data-placeholder="Pilih Petugas" class="form-control select">
                                            <option></option>
                                            <option value="1">Petugas 1</option>
                                            <option value="2">Petugas 2</option>
                                            <option value="3">Petugas 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-lg-4">Bank Sampah Unit: </label>
                                <div class="col-lg-7">
                                    <select multiple="multiple" class="form-control select"
                                        data-placeholder="Pilih Bank Sampah Unit">
                                        <optgroup label="Pilih Bank Sampah Unit">
                                            <option value="AZ">Unit 1</option>
                                            <option value="CO">Unit 2</option>
                                            <option value="ID">Unit 3</option>
                                            <option value="WY">Unit 4</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-lg-4">Keterangan: </label>
                                <div class="col-lg-7">
                                    <textarea class="form-control" name="description" placeholder="Masukkan Keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="modal_default_tabCreate2" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jadwal Rutin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="addScheduleForm">
                    <div class="modal-body">
                        <div class="container">
                            <div class="mb-3 row">
                                <label for="tanggal_kirim" class="col-lg-4 col-form-label">Hari:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <select data-placeholder="Pilih Hari" class="form-control select">
                                            <option></option>
                                            <option value="1">Senin</option>
                                            <option value="2">Selasa</option>
                                            <option value="3">Rabu</option>
                                            <option value="3">Kamis</option>
                                            <option value="3">Jumat</option>
                                            <option value="3">Sabtu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="tanggal_kirim" class="col-lg-4 col-form-label">Petugas:</label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <select data-placeholder="Pilih Petugas" class="form-control select">
                                            <option></option>
                                            <option value="1">Petugas 1</option>
                                            <option value="2">Petugas 2</option>
                                            <option value="3">Petugas 3</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-lg-4">Bank Sampah Unit: </label>
                                <div class="col-lg-7">
                                    <select multiple="multiple" class="form-control select"
                                        data-placeholder="Pilih Bank Sampah Unit">
                                        <optgroup label="Pilih Bank Sampah Unit">
                                            <option value="AZ">Unit 1</option>
                                            <option value="CO">Unit 2</option>
                                            <option value="ID">Unit 3</option>
                                            <option value="WY">Unit 4</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-form-label col-lg-4">Keterangan: </label>
                                <div class="col-lg-7">
                                    <textarea class="form-control" name="description" placeholder="Masukkan Keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
