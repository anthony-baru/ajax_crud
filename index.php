<!doctype html>
<html lang="en">

<head>
    <title>Ajax weblesson</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f1f1f1;
        }

        .box {
            width: 1270px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            margin-top: 25px;
        }
    </style>
</head>


<body>
    <div class="container box">
        <h1 align="center">Ajax User Management</h1>
        <br>
        <div align="right">
            <button type="submit" id="add_button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#exampleModal" aria-hidden="true">Add</button>
        </div>
        <br>
        <div class="table-responsive">
            <table id="user_data" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="10%">Image</th>
                        <th width="35%">First Name</th>
                        <th width="35%">Last Name</th>
                        <th width="10%">Edit</th>
                        <th width="10%">Delete</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="user_form" class="user-form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label for="">Enter First Name</label>
                        <input type="text" name="first_name" id="first_name" class="form-control">
                        <br />
                        <label for="">Enter Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control">
                        <br />
                        <label for="">Select User Image</label>
                        <input type="file" name="user_image" id="user_image" class="form-control">
                        <br />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="operation" id="operation">
                        <input type="submit" value="Add" id="action" class="btn btn-success">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add_button').click(function() {
                $('#user_form')[0].reset();
                $('.modal-title').text('Add User');
                $('#action').val('Add');
                $('#operation').val('Add');
                $('#user_uploaded_image').html('');
            });

            var dataTable = $('#user_data').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    url: "fetch.php",
                    type: "POST"
                },
                "columnDefs": [{
                    "targets": [0, 3, 4],
                    "orderable": false,
                }, ],
            });

            $(document).on('submit', '#user_form', function(event) {
                event.preventDefault();
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var extension = $('#user_image').val().split('.').pop().toLowerCase();
                //checking image format
                if (extension != '') {
                    if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                        alert('Invalid Image File');
                        $('#user_image').val('');
                        return false;
                    }
                }
                if (first_name != '' && last_name != '' && extension != '') {
                    $.ajax({
                        method: "POST",
                        url: "insert.php",
                        //dataType: "dataType",
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            alert(response);
                            $('#user_form')[0].reset();
                            $('#exampleModal').modal('hide');
                            dataTable.ajax.reload();
                        }
                    });
                } else {
                    alert('All fields are required');
                }
            });
        });
    </script>

</body>

</html>