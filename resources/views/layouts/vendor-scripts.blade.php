<script src="{{ assetUrl('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ assetUrl('js/popper.min.js') }}"></script>
<script src="{{ assetUrl('js/bootstrap.min.js') }}"></script>
<script src="{{ assetUrl('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ assetUrl('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ assetUrl('js/select2.min.js') }}"></script>
<script src="{{ assetUrl('js/jquery.slimscroll.js') }}"></script>
<script src="{{ assetUrl('js/moment.min.js') }}"></script>
<script src="{{ assetUrl('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ assetUrl('js/bootstrap-datepicker.ar.min.js') }}"></script>
<script src="{{ assetUrl('js/app.js') }}"></script>
<script src="{{ assetUrl('js/mahmoud.js') }}"></script>
<script src="{{ assetUrl('js/validationEngine/jquery.validationEngine.js') }}"></script>
<script src="{{ assetUrl('js/validationEngine/languages/jquery.validationEngine-ar.js') }}"></script>

<script>
    $(document).ready(function() {
        $('form').on('keypress', function(e) {
            if (e.key == 'Enter') {
                e.preventDefault();
            }
        });
        validation_engine_call();

        function validation_engine_call() {
            'use strict';
            jQuery('#formID,.validate_form').validationEngine('hideAll');
            jQuery("#formID,.validate_form").validationEngine('detach');
            jQuery("#formID,.validate_form").validationEngine('attach', {
                showOneMessage: false,
                promptPosition: "bottomLeft",
                autoHidePrompt: false,
                scroll: true,
                /*onValidationComplete: function (form, status) {
                if(status){
                  form.submit();
                  return false;
                }
                  }*/
                /*showPrompts:false*/
            });
        }
    });
</script>
<script>
    if (document.getElementById('toggle-password')) {
        document.getElementById('toggle-password').addEventListener('click', function() {
            // Get the password input field
            var passwordField = document.getElementById('password');

            // Check the current type of the input field and toggle it
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Show password
                this.setAttribute('aria-pressed', 'true'); // Update aria-pressed attribute to "true"
            } else {
                passwordField.type = 'password'; // Hide password
                this.setAttribute('aria-pressed', 'false'); // Update aria-pressed attribute to "false"
            }
        });
    }
    if (document.getElementById('toggle-confirm-password')) {
        document.getElementById('toggle-confirm-password').addEventListener('click', function() {
            // Get the password input field
            var passwordField = document.getElementById('password_confirmation');

            // Check the current type of the input field and toggle it
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Show password
                this.setAttribute('aria-pressed', 'true'); // Update aria-pressed attribute to "true"
            } else {
                passwordField.type = 'password'; // Hide password
                this.setAttribute('aria-pressed', 'false'); // Update aria-pressed attribute to "false"
            }
        });
    }
</script>
<script>
    function markAsRead(id) {
        $.ajax({
            url: '{{ route('notifications.mark-as-read') }}',
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);
            }
        });
    }

    $(document).ready(function() {
        // Use event delegation for dynamic content
        $('.datatable').on('click', 'a[notify-id]', function() {
            var notifyId = $(this).attr('notify-id');
            if (notifyId) {
                markAsRead(notifyId);
            }
        });
    });

    function markLastRead(id) {
        $.ajax({
            url: '{{ route('notifications.mark-as-read') }}',
            method: 'POST',
            data: {
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                console.log(data);
                $('.nav-bell').find('.badge').remove();
            }
        });
    }
</script>

@if (!route_is('notifications.index'))
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script>
        let fileName = $("#file-name").val() ?? 'export';
        let exportRoute = $("#export-route").val();
        if (!exportRoute) {
            exportRoute = "https://jsonplaceholder.typicode.com/posts";
        }
        async function exportToExcel() {
            try {
                // Fetch data from the backend
                console.log(exportRoute);
                const response = await fetch(exportRoute);
                if (!response.ok) throw new Error("Failed to fetch data");

                const data = await response.json();
                // Convert data to SheetJS format
                const worksheet = XLSX.utils.json_to_sheet(data);
                const workbook = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(workbook, worksheet, "Users");

                // Export as Excel file
                XLSX.writeFile(workbook, fileName + ".xlsx");
            } catch (error) {
                console.error("Error exporting data:", error);
            }
        }

        // Attach event to button
        if (document.getElementById("btnExportTable")) {
            document.getElementById("btnExportTable").addEventListener("click", exportToExcel);
        }
    </script>
@endif
