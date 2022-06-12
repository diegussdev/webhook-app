<div class="accordion-item" id="itemRequest-{{ $key }}">
    <h2 class="accordion-header" id="panelsStayOpen-headingRequest-{{ $key }}">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseRequest-{{ $key }}" aria-expanded="false" aria-controls="panelsStayOpen-collapseRequest-{{ $key }}">
            {{ $request['method'] }} @if ($request['origin']) - {{ $request['origin'] }} @endif - {{ date('Y/m/d h:i:s A', $request['datetime']); }}
        </button>
    </h2>
    <div id="panelsStayOpen-collapseRequest-{{ $key }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingRequest-{{ $key }}" >
        <div class="accordion-body">
            @if ($request['query'])
                <div class="mb-2">
                    <span>Query</span>
                    <textarea class="form-control" aria-label="With textarea" onclick="copy('{{ $request['query'] }}','#resquestQuery{{ $key }}')" id="resquestQuery{{ $key }}" readonly>{{ trim($request['query']) }}</textarea>
                </div>
            @endif
            @if ($request['body'])
                <div class="mb-2">
                    <span>Body</span>
                    <textarea class="form-control" aria-label="With textarea" onclick="copy('{{ $request['body'] }}','#resquestBody{{ $key }}')" id="resquestBody{{ $key }}" readonly>{{ trim($request['body']) }}</textarea>
                </div>
            @endif
            @if ($request['headers'])
                <div class="mb-2">
                    <span>Headers</span>
                    <textarea class="form-control" aria-label="With textarea" onclick="copy('{{ $request['headers'] }}','#resquestHeader{{ $key }}')" id="resquestHeader{{ $key }}" readonly>{{ trim($request['headers']) }}</textarea>
                </div>
            @endif

        </div>
    </div>
</div>