<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.dark\:text-gray-500{--tw-text-opacity:1;color:#6b7280;color:rgba(107,114,128,var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }

            textarea:hover, 
            input:hover, 
            textarea:active, 
            input:active, 
            textarea:focus, 
            input:focus,
            button:focus,
            button:active,
            button:hover,
            label:focus,
            .btn:active,
            .btn.active
            {
                outline:0px !important;
                -webkit-appearance:none;
                box-shadow: none !important;
            }
        </style>
    </head>
    <body class="p-4">

        <div class="container-sm text-center">
            <h1 class="fw-bold m-0">Webhook App</h1>
            <div id="watch" class="opacity-0">00:00:00 AM</div>
        </div>

        <div class="container-sm text-bg-light p-3 rounded-2 mt-2">
            <div class="container d-flex justify-content-between">
                <h4 class="fw-bold">Fake Requester</h4>
            </div>

            <div class="container mt-2">
                <input onclick="copy('{{ $FakeRequester['url'] }}','#fakeRequesterUrl')" type="text" class="form-control text-center" id="fakeRequesterUrl" value="{{ $FakeRequester['url'] }}" readonly>
            </div>

            <div class="container mt-2">
                <p class="m-0"><i class="fa-solid fa-circle-info"></i> code = HTTP_CODE that will be returned</p>
                <p class="m-0"><i class="fa-solid fa-circle-info"></i> timeout = Seconds to wait for response</p>
                <p class="m-0"><i class="fa-solid fa-circle-info"></i> The request body will be returned in the response</p>
            </div>
        </div>

        <div class="container-sm text-bg-light mt-2 p-3 rounded-2">
            <div class="container">
                <h4 class="fw-bold">Webhook</h4>
            </div>
            
            <div class="container mt-2">
                <input onclick="copy('{{ $Webhook['url'] }}','#webhookUrl')" type="text" class="form-control text-center" id="webhookUrl" value="{{ $Webhook['url'] }}" readonly>
            </div>

            <div class="container mt-2">
                <p class="m-0"><i class="fa-solid fa-circle-info"></i> You can set return HTTP_CODE in the last path param</p>
            </div>
        </div>

        <div class="container-sm text-bg-light mt-2 p-3 rounded-2">
            <div class="container d-flex flex-wrap justify-content-between align-items-center mb-2">
                <button class="btn btn-outline-primary btn-sm" type="button" disabled>
                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                    <span class="ml-2">Loading Requests...</span>
                    
                </button>
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <button class="btn btn-outline-success btn-sm" onclick="reloadRequests('/webhook/generate')">
                        <i class="fa-solid fa-plus"></i>
                        Generate
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="reloadRequests('/webhook/clear')">
                        <i class="fa-solid fa-trash-can"></i>
                        Clear
                    </button>
                </div>
            </div>

            <div class="container mt-2">
                <div class="card card-body bg-transparent border-0 p-0">
                    <div class="accordion" id="accordionPanelRequest">
                        @foreach ($Webhook['requests'] as $key => $request)
                            @include('request', ['request' => $request])
                        @endforeach
                    </div>
                </div>

            </div>

        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            var watchTimer = setInterval(loadTimer, 1000);
            var requestsTimer = setInterval(loadRequests, 1000);
            
            function loadTimer() {
                var d = new Date(), displayDate;

                if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                    displayDate = d.toLocaleTimeString('en');
                } else {
                    displayDate = d.toLocaleTimeString('en', {timeZone: 'UTC'});
                }

                $("#watch").html(displayDate + ' - UTC');
                $("#watch").removeClass('opacity-0');
            }

            function loadRequests() {
                $.ajax({
                    url: "{{ $getRequestsUrl }}",
                })
                .done(function(response) {
                    if (response) {
                        for (var key in response) {
                            if (!response.hasOwnProperty(key)) {
                                continue;
                            };

                            if ($(`#itemRequest-${key}`).length) {
                                continue;
                            }

                            var element = response[key];
                            $('#accordionPanelRequest').prepend(element); 
                        }
                    }
                });
            }

            function reloadRequests(url) {
                $.ajax({
                    url: url,
                });

                $('#accordionPanelRequest').html('');
            }

            function copy(text, target) {
                $(target).val('Copied!').addClass('text-success');
                setTimeout(() => {
                    $(target).val(text).removeClass('text-success');
                }, 1000);
                
                var input = document.createElement('input');
                
                input.setAttribute('value', text);
                document.body.appendChild(input);
                input.select();
                
                var result = document.execCommand('copy');
                document.body.removeChild(input)
                
                return result;
            }
        </script>
    </body>
</html>
