<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Datepicker - Date Range Functionality</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
    <script>
        $(function() {
            var dateFormat = "yy-mm-dd",
                departureDate = $("#departure").datepicker({
                    dateFormat: dateFormat,
                    changeMonth: true,
                    numberOfMonths: 1,
                    minDate: 0,
                    onClose: function(selectedDate) {
                        var minDate = new Date(selectedDate);
                        var maxDate = new Date(minDate);
                        maxDate.setDate(minDate.getDate() + 15);
                        $("#return").datepicker("option", "minDate", minDate);
                        $("#return").datepicker("option", "maxDate", maxDate);
                    }
                }),
                returnDate = $("#return").datepicker({
                    dateFormat: dateFormat,
                    changeMonth: true,
                    numberOfMonths: 1,
                    onClose: function(selectedDate) {
                        $("#departure").datepicker("option", "maxDate", selectedDate);
                    }
                });
        });
    </script>
</head>
<body>

<div class="container">
    <h2>Example Page</h2>
    <div class="form__group">
        <span><i class="ri-calendar-line"></i></span>
        <div class="input__content">
            <div class="input__group">
                <input type="text" id="departure" name="departure" class="date-input" placeholder="Departure" required />
                <label for="departure">Departure</label>
            </div>
            <p>Add date</p>
        </div>
    </div>
    <div class="form__group">
        <span><i class="ri-calendar-line"></i></span>
        <div class="input__content">
            <div class="input__group">
                <input type="text" id="return" name="return" class="date-input" placeholder="Return" required />
                <label for="return">Return</label>
            </div>
            <p>Add date</p>
        </div>
    </div>
</div>

</body>
</html>
