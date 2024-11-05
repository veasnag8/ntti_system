<base href="/public">
@extends('app_layout.app_layout')
@section('content')
<div class="col-md-6 col-sm-6  col-6">
      <div class="page-title page-title-custom">
        <div class="title-page">
          ការគ្រប់គ្រងរបស់គ្រូ <br>
          <p style="color:red">{{$records->name_2}}</p>
        </div>
      </div>
    </div>
    <div class="row mt-4">
    <div class="column">
        <div class="effect-9">
            <div class="effect-img">
            <a href="{{ url('/manage-academic-work') }}">
                <img src="https://img.freepik.com/free-vector/online-certification_23-2148576444.jpg?w=740&t=st=1699537366~exp=1699537966~hmac=2900c823bc05a965b57d348773d8c7d7b4c22ceb8fab35ae33afa7302cd12b90" alt="Team Image">
            </a>
            </div>
            <div class="title-department">{{$records->name}}</div>
        </div>
    </div>
    <div class="column">
        <div class="effect-9">
            <div class="effect-img">
                <a href="{{ url('/class-schedule') }}">
                    <img src="https://img.freepik.com/free-vector/organic-flat-people-business-training-illustration_23-2148901755.jpg?w=996&t=st=1699538720~exp=1699539320~hmac=e469da26591c37b7556bdd7e17fce39370c0b43b3e9cd9a5b61afd38d58a7246" alt="Team Image">
                </a>
            </div>
            <div class="title-department">{{$records->name_2}}</div>
        </div>
    </div>
            <div class="column">
            <div class="effect-9">
                <div class="effect-img">
                    <a href="{{ url('/teachers_detail') }}">
                        <img src="https://i.pinimg.com/564x/d9/f5/bc/d9f5bc4b25df7c7088d96e14523cdcc3.jpg" alt="Team Image">
                    </a>
                </div>
                <div class="title-department">{{$records->address}}</div>
            </div>
        </div>
        <div class="column">
            <div class="effect-9">
                <div class="effect-img">
                    <a href="{{ url('/teachers_detail') }}">
                        <img src="https://i.pinimg.com/564x/e8/7a/b0/e87ab0a15b2b65662020e614f7e05ef1.jpg" alt="Team Image">
                    </a>
                </div>
                <div class="title-department">User Profile</div>
            </div>
        </div>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Schedule</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Weekly Schedule</h2>
    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Time</th>
                <th>អាទិត្យ</th>
                <th>ច័ន្ទ</th>
                <th>អង្គារ</th>
                <th>ពុធ</th>
                <th>ព្រ.ហ</th>
                <th>សុក្រ</th>
                <th>សៅរ៍</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>8:00 AM - 9:00 AM</td>
                <td style="background-color: red;"></td>
                <td></td>
            </tr>
            <tr>
                <td>9:00 AM - 10:00 AM</td>
                <td></td>
                <td>{{$records->qualification}}({{$records->gender}})</td>
            </tr>
            <tr>
                <td>10:00 AM - 11:00 AM</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>11:00 AM - 12:00 PM</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>12:00 PM - 1:00 PM</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>1:00 PM - 2:00 PM</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>2:00 PM - 3:00 PM</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>3:00 PM - 4:00 PM</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>4:00 PM - 5:00 PM</td>
                <td></td>
                <td>{{$records->qualification}}</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<script>
  $(document).ready(function() {
    $('#BtnSave').on('click', function() {
        var formData = $('#frmDataCard').serialize();
        var type = $('#type').val();
        var checkbox = $('#status');
        var status = checkbox.prop('checked') ? 'yes' : 'no';
        var url;
        if (!type) {
            if(FieldRequired()) return;
            url = '/teachers/store?status=' + status;
        } else {
            url = '/teachers/update?status=' + status;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 'success') {
                  notyf.success(response.msg);
                }else if(response.store == 'yes'){
                  $('#frmDataCard')[0].reset();
                  notyf.success(response.msg);
                }else {
                    notyf.error(response.msg);
                }
            }
        });
    });

    $(document).on('click', '#BtnCreateUser', function() {
      $("#btnYes").attr('data-code', $(this).attr('data-code'));
      $("#divCreateUser").modal('show');
    });

    $(document).on('click', '#btnYes', function() {
      var code = $(this).attr('data-code');
      var password = $("#password").val();
      var email = $("#email").val();
      $.ajax({
        type: "get",
        url: `/teachers/create-user-account`,
        data: {
          code: code, password:password , email: email
        },
        success: function(response) {
          if (response.status == 'success') {
            $("#divConfirmation").modal('hide');
            notyf.success(response.msg);
          }else{
            notyf.error(response.msg);
          }
        }
      });
    });

    $(document).on('click', '#btnClose', function() {
      $("#divCreateUser").modal('hide');
    });
  });
  function DownlaodExcel() {
    var url = '/student/downlaodexcel/';
    if ($('#search_data').val() == '') {
      data = $("#advance_search").serialize();
    } else {
      data = 'value=' + $('#search_data').val();
    }
    data = $("#advance_search").serialize();
    $.ajax({
      type: "post",
      url: url,
      data: data,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: function() {
        // $.LoadingOverlay("show", {
        //   custom: loadingOverlayCustomElement
        // });
        // loadingOverlayCustomElement.text('Request Processing...');
      },
      success: function(response) {
        $.LoadingOverlay("hide", true);
        if (response.status == 'success') {
          $('#divPassword').modal('hide');
          location.href = response.path;
          // myfn.showNotify(response['status'], 'lime', 'top', 'right', response['message']);
        } else {
          $('.secure_msg').html(response.message);
          $('.secure_msg').show();
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {}
    });
  }

function FieldRequired() {
    var inValid = false ;
    $('#frmDataCard').each(function (event) {
      var code = $('#code').val();
      if(!code){
          $('#code').addClass('FieldRequired');
          inValid = true; 
      } else{
          $('#code').removeClass('FieldRequired');
          inValid = false; 
      }
      var name = $('#name').val();
      if(!name){
          $('#name').addClass('FieldRequired');
          inValid = true; 
      } else{
          $('#name').removeClass('FieldRequired');
          inValid = false; 
      }
      var name_2 = $('#name_2').val();
      if(!name_2){
          $('#name_2').addClass('FieldRequired');
          inValid = true; 
      } else{
          $('#name_2').removeClass('FieldRequired');
          inValid = false; 
      }
      var date_of_birth = $('#date_of_birth').val();
      if(!date_of_birth){
          $('#date_of_birth').addClass('FieldRequired');
          inValid = true; 
      } else{
          $('#date_of_birth').removeClass('FieldRequired');
          inValid = false; 
      }
    });
    if(inValid){
        notyf.error('field is required');
    } 
    return inValid;
}
</script>
@endsection

