<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Developer Log</title>
    <link href="{{ asset('public/template/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container-fluid">
            <a class="btn btn-sm btn-primary m-4" href="javascript:void(print())">Print</a>
            <br>
            <div class="row">
                <div class="col-md-8">
                        <table id="target" style="display:none" class="table table-stripped">
                                <?php $index=1; ?>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Activity</th>
                                        <th>User</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($log as $item => $val)
                                    <tr>
                                        <td>{{$index++}} </td>
                                        <td> {{$val->activity}} </td>
                                        <td> {{$val->user}} </td>
                                        <td> {{$val->created_at}} </td>
                                    </tr>                
                                    @endforeach
                                </tbody>
                            </table>
                </div>
            </div>
    </div>
</body>
<script>
        var pwd = prompt("Credential","insert your dev pass");
        if (pwd=="!@#$4321") {
            alert("Welcome dev :)")
            document.getElementById('target').style.display = 'block';
        }
        else{
            alert("You're not allowed, sorry :)")
            window.history.back();
        }
        </script>
</html>