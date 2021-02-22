<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
    .container {
        margin-top: 80pt;
    }

    .mb20 {
        margin-bottom: 20px;
    }

    .ml20 {
        margin-left: 20px;
    }

    .mr20 {
        margin-right: 20px;
    }

    option {
        margin-bottom: 10px;
    }
    </style>
</head>

<body class="antialiased">
    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
            <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
            @else
            <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
            @endif
            @endauth
        </div>
        @endif
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="#">LOGO</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>

                </ul>
            </div>
        </nav>


        <div class="container" id="MainContainer">
            <h1>Item Management Page</h1>
            <div id="error">

            </div>
            <div class="form-row mb20">
                <div class="col-sm-3">
                    <input type="text" id="ItemName" class="form-control" placeholder="Enter Item Name and Click Add">
                </div>
                <div class="col-sm-1">
                    <input type="button" class="form-control" id="add" value="Add">
                </div>
                <div class="col-sm-3">
                </div>
                <div class="col-sm-3">
                    <h3>Selected Items</h3>
                </div>
            </div>

            <div class="form-row">
                <div class="col">
                    <select name="product_list" multiple="multiple" size="10" id="lstBox1" style="min-width: 450px;"
                        class="form-control">

                        @foreach($ProductListNonSelected as $products)
                        <option value="{{ $products->id}}" style="font-weight:bold"> {{ $products->product_name}}
                        </option>
                        @endforeach


                    </select>

                </div>


                <div class="col text-center">
                    <input type="button" id="btnRight" value=">" class="btn btn-default mb20 " /><br />
                    <input type="button" id="btnLeft" value="<" class="btn btn-default mb20" /><br />

                </div>



                <div class="col">
                    <select autofocus name="pending_products[]" multiple="multiple" size="10" id='lstBox2'
                        style="min-width: 450px;" class="form-control">
                        @foreach($ProductListSelected as $products)
                        <option value="{{ $products->id}}" style="font-weight:bold"> {{ $products->product_name}}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <script type="text/javascript">
        $('#submit').click(function() {
            $('#lstBox2 option').prop('selected', true);
        });
        var host = "{{URL::to('/')}}";
        jQuery(document).ready(function($) {
            $("#error").html('');
            $('#add').click(function(e) {
                $("#error").html('');
                var ItemName = $('#ItemName').val();
                $.ajax({
                    type: "POST",
                    url: host + '/add',
                    data: {
                        "name": ItemName,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(msg) {
                        if (msg == 1) {
                            $("#error").html(
                                '<div class="alert alert-success"><strong>Success!</strong> Item Added </div>'
                            );
                            $('#ItemName').val('');

                            $.get(host + "/GetData", function(data) {
                                console.log(data);
                                var MainData;

                                for ($i = 0; $i < data.length; $i++) {
                                    MainData += "<option value='" + data[$i].id +
                                        "'>" +
                                        data[$i]
                                        .product_name + "</option>";
                                }
                                $("#lstBox1").html(MainData);

                            });
                        } else {
                            $("#error").html(
                                '<div class="alert alert-danger"><strong>Error!</strong> Item already exists !!</div>'
                            );
                        }
                    }
                });

            });

        });
        (function($) {
            $('#btnRight').click(function(e) {
                $("#error").html('');
                var selectedOpts = $('#lstBox1 option:selected');
                console.log(selectedOpts);
                if (selectedOpts.length == 0) {

                    $("#error").html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Nothing to move. !!</div>'
                    );
                    e.preventDefault();
                } else {
                    for ($i = 0; $i < selectedOpts.length; $i++) {
                        $.post(host + '/RightToLeft', {
                                id: selectedOpts[$i].value,
                                "_token": "{{ csrf_token() }}",
                            })
                            .done(function(data) {

                            });
                    }
                }
                $('#lstBox2').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            });


            $('#btnLeft').click(function(e) {
                $("#error").html('');
                var selectedOpts = $('#lstBox2 option:selected');
                console.log(selectedOpts);
                if (selectedOpts.length == 0) {
                    $("#error").html(
                        '<div class="alert alert-danger"><strong>Error!</strong> Nothing to move. !!</div>'
                    );
                    e.preventDefault();
                } else {
                    for ($i = 0; $i < selectedOpts.length; $i++) {
                        $.post(host + '/LeftToRight', {
                                id: selectedOpts[$i].value,
                                "_token": "{{ csrf_token() }}",
                            })
                            .done(function(data) {

                            });
                    }
                }
                $('#lstBox1').append($(selectedOpts).clone());
                $(selectedOpts).remove();
                e.preventDefault();
            });



        }(jQuery));
        </script>
</body>

</html>