@extends('layout.app')
@section('content')


<!--- ********Add student modal********** -->


<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">*</button>
        </div>
        <div class="modal-body">



            <ul id="saveform_error"></ul>


          <div class="form-group mb-3">
            <label for="">Student Name</label>
            <input type="text" class="name form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" class="email form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" class="phone form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Course</label>
            <input type="text" class="course form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_student">Save</button>
        </div>
      </div>
    </div>
  </div>



  <!--- ********Edit student modal********** -->


<div class="modal fade" id="EditStidentModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">*</button>
        </div>
        <div class="modal-body">



            <ul id="updateform_error"></ul>

           <input type="hidden" id="edit_id">
          <div class="form-group mb-3">
            <label for="">Student Name</label>
            <input type="text" class="form-control" id="edit_name">
          </div>
          <div class="form-group mb-3">
            <label for="">Email</label>
            <input type="text" class="form-control" id="edit_email">
          </div>
          <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" class="form-control" id="edit_phone">
          </div>
          <div class="form-group mb-3">
            <label for="">Course</label>
            <input type="text" class="form-control" id="edit_course">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-info update_student">Upadte</button>
        </div>
      </div>
    </div>
  </div>










<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

            <div id="success_message"></div>

            <div class="card">
                <div class="card-header">
                    <h4>Student Data
                        <a href="" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn btn-primary  btn-sm float-right">Add Student</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody id="display">


                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>

$(document).ready(function () {


    Display();






    function Display(){

        $.ajax({
            type: "Get",
            url: "/display",
            dataType: "json",
            success: function (response) {
                $('#display').html('');
                $.each(response.students, function (students, student) {
                    $('#display').append(' <tr>\
                        <td>'+student.name+'</td>\
                        <td>'+student.email+'</td>\
                        <td>'+student.phone+'</td>\
                        <td>'+student.course+'</td>\
                        <td> <button type="button" value="'+student.id+'" class="edit_student btn btn-info btn-sm">Edit</button></td>\
                        <td> <button type="button" value="'+student.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                     </tr>' );
                });
            }
        });


    }

$(document).on('click', '.edit_student', function(e) {

    e.preventDefault();

    var id = $(this).val();

    $('#EditStidentModel').modal('show');

    $.ajax({
        type: "Get",
        url: "/edit_student/"+id,
        dataType: "json",
        success: function (response) {

            if(response.status == 404){

                $('#success_message').html("");
                $('#success_message').addClass("alert alert-danger");
                $('#success_message').text(response.message);
                $('#success_message').delay(5000).fadeOut('slow');

            }else{

                $('#edit_id').val(id);
                $('#edit_name').val(response.student.name);
                $('#edit_email').val(response.student.email);
                $('#edit_phone').val(response.student.phone);
                $('#edit_course').val(response.student.course);
            }

        }
    });


});




$(document).on('click', '.update_student', function(e) {

    e.preventDefault();

    $(this).text('Updating');



    var id = $('#edit_id').val();
    var data = {

        'name' : $('#edit_name').val(),
        'email' : $('#edit_email').val(),
        'phone' : $('#edit_phone').val(),
        'course' : $('#edit_course').val(),
    }



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });



    $.ajax({
        type: "Put",
        url: "update_student/"+id,
        data: data,
        dataType: "json",
        success: function (response) {

            if(response.status == 400){

                $('#updateform_error').html("");
                $('#updateform_error').addClass("alert alert-danger");
                $.each(response.errors, function (key, err_val) {
                    $('#saveform_error').append('<li>'+err_val+'</li>' );

                });

            }else if (response.status == 404) {

                $('#updateform_error').html("");
                $('#success_message').addClass("alert alert-success");
                $('#success_message').text(response.message);
                $('#success_message').delay(5000).fadeOut('slow');

            }else{
                $('#updateform_error').html("");
                $('#success_message').html("");
                $('#success_message').addClass("alert alert-success");
                $('#success_message').text(response.message);
                $('#EditStidentModel').modal('hide');
                $('#EditStidentModel').find('input').val('');


                Display();
                $('#success_message').delay(5000).fadeOut('slow');




            }

        }
    });


});



$(document).on('click', '.delete_student', function(e) {

    e.preventDefault();
    $(this).text('Deleting');
    var id = $(this).val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        $.ajax({
            type: "delete",
            url: "destroy_student/"+id,
            dataType: "json",
            success: function (response) {
                if(response.status == 404){

                    $('#success_message').html("");
                    $('#success_message').addClass("alert alert-danger");
                    $('#success_message').text(response.message);

                    Display();
                    $('#success_message').delay(5000).fadeOut('slow');

                }else{

                    $('#success_message').html("");
                    $('#success_message').addClass("alert alert-success");
                    $('#success_message').text(response.message);
                    $('#success_message').delay(5000).fadeOut('slow');
                    Display();

                }

            }
        });








});




    $(document).on('click', '.add_student', function(e) {
        e.preventDefault();

        $(this).text('Saving');

        var data = {

            'name' : $('.name').val(),
            'email' : $('.email').val(),
            'phone' : $('.phone').val(),
            'course' : $('.course').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: "/student",
            data: data,
            dataType: "json",
            success: function (response) {

                if (response.status == 400){


                $('#saveform_error').html('');
                $('#saveform_error').addClass('alert alert-danger');
                $.each(response.errors, function (key, err_val) {
                    $('#saveform_error').append('<li>'+err_val+'</li>' );

                });

            }else{

                     $('#saveform_error').html('');
                     $('#success_message').addClass('alert alert-success');
                     $('#success_message').text(response.message);
                     $('#AddStudentModal').modal('hide');
                     $('#AddStudentModal').find('input').val('');
                     $('#success_message').delay(5000).fadeOut('slow');
                     Display();


            }


            }
        });



    });

});
</script>


@endsection
