<div class="accordion-item" id="itemRequest-{{ $key }}">
    <div class="accordion-header" id="panelsStayOpen-headingRequest-{{ $key }}">
        <div class="accordion-button collapsed px-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseRequest-{{ $key }}" aria-expanded="false" aria-controls="panelsStayOpen-collapseRequest-{{ $key }}">
            <div class="d-block">
                <p class="p-0 m-0 fw-bold text-secondary" style="font-size: 12px">{{ date('Y/m/d h:i:s A', $request['datetime']); }}</p>
                <div>
                    <button style="font-size: 14px; width: 100px" class="btn btn-sm px-2 py-0 mt-1 @if ($request['method'] == 'GET') btn-primary @elseif ($request['method'] == 'POST') btn-success @elseif ($request['method'] == 'PUT')  btn-warning text-light @elseif ($request['method'] == 'DELETE') btn-danger @else btn-secondary @endif">
                        {{ $request['method'] }}
                    </button>
                    <button class="btn btn-sm px-2 py-0 mt-1 btn-link fw-bold" style="text-decoration: none; font-size: 12px" disabled>{{ $request['responseCode'] }}</button>               
                </div>
            </div>
        </div>
    </div>
    <div id="panelsStayOpen-collapseRequest-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingRequest-{{ $key }}" >
        <div class="accordion-body">
            @if ($request['query'])
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Query</span>
                        <button onclick="copy('{{ $request['query'] }}','#resquestQuery{{ $key }}')" class="bg-transparent text-secondary ml-2 fw-bold" style="cursor: pointer"><i class="fa-solid fa-copy"></i><span class="ml-1" style="font-size: 10px">Copy</span></button>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" id="resquestQuery{{ $key }}" readonly>{{ trim($request['query']) }}</textarea>
                </div>
            @endif
            @if ($request['body'])
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Body</span>
                        <button onclick="copy('{{ $request['body'] }}','#resquestBody{{ $key }}')" class="bg-transparent text-secondary ml-2 fw-bold" style="cursor: pointer"><i class="fa-solid fa-copy"></i><span class="ml-1" style="font-size: 10px">Copy</span></button>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" id="resquestBody{{ $key }}" readonly>{{ trim($request['body']) }}</textarea>
                </div>
            @endif
            @if ($request['headers'])
                <div class="mb-2">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Headers</span>
                        <button onclick="copy('{{ $request['headers'] }}','#resquestHeader{{ $key }}')" class="bg-transparent text-secondary ml-2 fw-bold" style="cursor: pointer"><i class="fa-solid fa-copy"></i><span class="ml-1" style="font-size: 10px">Copy</span></button>
                    </div>
                    <textarea class="form-control" aria-label="With textarea" id="resquestHeader{{ $key }}" readonly>{{ trim($request['headers']) }}</textarea>
                </div>
            @endif

        </div>
    </div>
</div>