<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>403 Forbidden Error. - @lang('config.project')</title>
        <link href="{{ asset('css/error/404.css') }}" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300|Titillium+Web:200,300,400' rel='stylesheet' type='text/css'>
    </head>
    <body id="error-page">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div id="error-box">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="error-box-inner">
                                    <img src="{{ asset('image/error-403.png') }}" alt="Have you seen this page?" />
                                </div>
                                <h1>ERROR 403</h1>
                                <p>
                                    You are forbidden!<br/>
                                </p>
                                <p>
                                    Go back to <a href="{{ url('') }}">homepage</a>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
